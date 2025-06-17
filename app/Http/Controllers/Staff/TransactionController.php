<?php

namespace App\Http\Controllers\Staff;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference_number', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->orderByDesc('transaction_date')->paginate(10)->withQueryString();

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

        // dd($request->all());
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'description' => 'nullable',
            'type' => 'required|in:general,adjustment,closing',
            'details' => 'required|array',
            'details.*.account_id' => 'required|exists:accounts,id',
            'details.*.debit_amount' => 'required_without:details.*.credit_amount|numeric|min:0',
            'details.*.credit_amount' => 'required_without:details.*.debit_amount|numeric|min:0',
            'details.*.description' => 'nullable'
        ]);



        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'transaction_date' => $validated['transaction_date'],
                'reference_number' => $this->generateReferenceNumber($validated['transaction_date']),
                'description' => $validated['description'],
                'type' => $validated['type'],
                'total_amount' => collect($validated['details'])->sum('debit_amount')
            ]);

            foreach ($validated['details'] as $detail) {
                $transaction->details()->create($detail);
            }

            DB::commit();
            return redirect()->route('staff.transactions.index')
                ->with('success', 'Transaksi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Transaksi gagal disimpan: ' . $e->getMessage());
        }
    }
    protected function generateReferenceNumber($date)
    {
        $dateFormatted = Carbon::parse($date)->format('Ymd');

        // Hitung jumlah transaksi di tanggal yang sama
        $count = Transaction::whereDate('transaction_date', $date)->count() + 1;

        do {
            $reference = 'TRX-' . $dateFormatted . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            $exists = Transaction::where('reference_number', $reference)->exists();
            $count++;
        } while ($exists);

        return $reference;
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
        // if ($transaction->type !== 'general') {
        //     return back()->with('error', 'Hanya transaksi umum yang dapat diedit');
        // }

        $accounts = Account::where('is_active', true)->orderBy('code')->get();
        $transaction->load('details');
        return view('staff.transactions.edit', compact('transaction', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // if ($transaction->type !== 'general') {
        //     return back()->with('error', 'Hanya transaksi umum yang dapat diedit');
        // }
        // dd($request->all());

        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'type' => 'required|in:general,adjustment,closing',
            'description' => 'nullable',
            'details' => 'required|array',
            'details.*.account_id' => 'required|exists:accounts,id',
            'details.*.debit_amount' => 'required_without:details.*.credit_amount|numeric|min:0',
            'details.*.credit_amount' => 'required_without:details.*.debit_amount|numeric|min:0',
            'details.*.description' => 'nullable'
        ]);

        DB::beginTransaction();
        try {
            $transaction->update([
                'transaction_date' => $validated['transaction_date'],
                'description' => $validated['description'],
                'type' => $validated['type'],
                'total_amount' => collect($validated['details'])->sum('debit_amount')
            ]);

            $transaction->details()->delete();
            foreach ($validated['details'] as $detail) {
                $transaction->details()->create($detail);
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

    public function ledger(Account $account, Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month');

        // Hitung saldo awal
        $saldoAwal = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('transaction_details.account_id', $account->id)
            ->where(function ($q) use ($year, $month) {
                if ($month) {
                    $q->whereYear('transactions.transaction_date', $year)
                        ->whereMonth('transactions.transaction_date', '<', $month);
                } else {
                    $q->whereYear('transactions.transaction_date', '<', $year);
                }
            })
            ->select(DB::raw('SUM(transaction_details.debit_amount - transaction_details.credit_amount) as total'))
            ->value('total') ?? 0;

        // Ambil transaksi untuk periode yang dipilih
        $query = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('transaction_details.account_id', $account->id)
            ->whereYear('transactions.transaction_date', $year);

        if ($month) {
            $query->whereMonth('transactions.transaction_date', $month);
        }

        $transactions = $query->select(
            'transactions.transaction_date',
            'transactions.reference_number',
            'transactions.description',
            'transaction_details.debit_amount',
            'transaction_details.credit_amount'
        )
            ->orderBy('transactions.transaction_date')
            ->get();

        // Hitung saldo berjalan
        $saldo = $saldoAwal;
        foreach ($transactions as $transaction) {
            $transaction->saldo = $saldo + ($transaction->debit_amount - $transaction->credit_amount);
            $saldo = $transaction->saldo;
        }

        if ($request->has('export')) {
            $pdf = PDF::loadView('staff.transactions.ledger-pdf', compact('account', 'transactions', 'saldoAwal', 'year', 'month'));
            return $pdf->download('buku-besar-' . $account->code . '-' . $year . ($month ? '-' . $month : '') . '.pdf');
        }

        return view('staff.transactions.ledger', compact('account', 'transactions', 'saldoAwal', 'year', 'month'));
    }
}
