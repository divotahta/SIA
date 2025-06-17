<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LedgerController extends Controller
{
    public function index()
    {
        $accounts = Account::orderBy('code')->get();
        return view('staff.ledger.index', compact('accounts'));
    }

    public function show(Account $account, Request $request)
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
            $pdf = PDF::loadView('staff.ledger.pdf', compact('account', 'transactions', 'saldoAwal', 'year', 'month'));
            return $pdf->download('buku-besar-' . $account->code . '-' . $year . ($month ? '-' . $month : '') . '.pdf');
        }

        return view('staff.ledger.show', compact('account', 'transactions', 'saldoAwal', 'year', 'month'));
    }
} 