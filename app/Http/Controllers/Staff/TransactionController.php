<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('details.account')
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);
        return view('staff.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = Account::where('is_active', true)->orderBy('code')->get();
        return view('staff.transactions.create', compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'reference_number' => 'required|unique:transactions',
            'description' => 'required',
            'type' => 'required|in:general,cash_in,cash_out',
            'details' => 'required|array|min:2',
            'details.*.account_id' => 'required|exists:accounts,id',
            'details.*.debit_amount' => 'required_without:details.*.credit_amount|numeric|min:0',
            'details.*.credit_amount' => 'required_without:details.*.debit_amount|numeric|min:0',
            'details.*.description' => 'nullable'
        ]);

        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'transaction_date' => $validated['transaction_date'],
                'reference_number' => $validated['reference_number'],
                'description' => $validated['description'],
                'type' => $validated['type'],
                'total_amount' => collect($validated['details'])->sum('debit_amount')
            ]);

            foreach ($validated['details'] as $detail) {
                $transaction->details()->create($detail);
            }

            if (!$transaction->validateBalance()) {
                throw new \Exception('Total debit dan kredit tidak sama');
            }

            DB::commit();
            return redirect()->route('staff.transactions.index')
                ->with('success', 'Transaksi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Transaksi gagal disimpan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('details.account');
        return view('staff.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        if ($transaction->type !== 'general') {
            return back()->with('error', 'Hanya transaksi umum yang dapat diedit');
        }

        $accounts = Account::where('is_active', true)->orderBy('code')->get();
        $transaction->load('details');
        return view('staff.transactions.edit', compact('transaction', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->type !== 'general') {
            return back()->with('error', 'Hanya transaksi umum yang dapat diedit');
        }

        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'description' => 'required',
            'details' => 'required|array|min:2',
            'details.*.account_id' => 'required|exists:accounts,id',
            'details.*.debit_amount' => 'required_without:details.*.credit_amount|numeric|min:0',
            'details.*.credit_amount' => 'required_without:details.*.debit_amount|numeric|min:0',
            'details.*.description' => 'nullable'
        ]);

        DB::beginTransaction();
        try {
            $transaction->update([
                'transaction_date' => $validated['transaction_date'],
                'description' => $validated['description']
            ]);

            $transaction->details()->delete();
            foreach ($validated['details'] as $detail) {
                $transaction->details()->create($detail);
            }

            if (!$transaction->validateBalance()) {
                throw new \Exception('Total debit dan kredit tidak sama');
            }

            DB::commit();
            return redirect()->route('staff.transactions.index')
                ->with('success', 'Transaksi berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Transaksi gagal diperbarui: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction->type !== 'general') {
            return back()->with('error', 'Hanya transaksi umum yang dapat dihapus');
        }

        DB::beginTransaction();
        try {
            $transaction->details()->delete();
            $transaction->delete();
            DB::commit();

            return redirect()->route('staff.transactions.index')
                ->with('success', 'Transaksi berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Transaksi gagal dihapus: ' . $e->getMessage());
        }
    }

    public function ledger(Account $account)
    {
        $transactions = $account->transactionDetails()
            ->with('transaction')
            ->orderBy('created_at')
            ->get();

        return view('staff.transactions.ledger', compact('account', 'transactions'));
    }
}
