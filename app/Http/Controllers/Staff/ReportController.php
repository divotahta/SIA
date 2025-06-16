<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function incomeStatement(Request $request)
    {
        $year = $request->get('year', date('Y'));

        $revenues = Account::where('type', 'revenue')
            ->with(['transactionDetails' => function ($query) use ($year) {
                $query->whereHas('transaction', function ($q) use ($year) {
                    $q->whereYear('transaction_date', $year);
                });
            }])
            ->get();

        $expenses = Account::where('type', 'expense')
            ->with(['transactionDetails' => function ($query) use ($year) {
                $query->whereHas('transaction', function ($q) use ($year) {
                    $q->whereYear('transaction_date', $year);
                });
            }])
            ->get();

        if ($request->has('export')) {
            $pdf = PDF::loadView('staff.reports.income-statement-pdf', compact('revenues', 'expenses', 'year'));
            return $pdf->download('laporan-laba-rugi-' . $year . '.pdf');
        }

        return view('staff.reports.income-statement', compact('revenues', 'expenses', 'year'));
    }

    public function balanceSheet(Request $request)
    {
        $assets = Account::where('type', 'asset')->get();
        $liabilities = Account::where('type', 'liability')->get();
        $equities = Account::where('type', 'equity')->get();

        if ($request->has('export')) {
            $pdf = PDF::loadView('staff.reports.balance-sheet-pdf', compact('assets', 'liabilities', 'equities'));
            return $pdf->download('laporan-neraca.pdf');
        }

        return view('staff.reports.balance-sheet', compact('assets', 'liabilities', 'equities'));
    }

    public function cashFlow(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        $cashIn = Account::where('type', 'asset')
            ->where('code', 'like', '110%') // Asumsi kode kas dimulai dengan 110
            ->with(['transactionDetails' => function ($query) use ($year, $month) {
                $query->whereHas('transaction', function ($q) use ($year, $month) {
                    $q->whereYear('transaction_date', $year)
                        ->whereMonth('transaction_date', $month)
                        ->where('type', 'cash_in');
                });
            }])
            ->first();

        $cashOut = Account::where('type', 'asset')
            ->where('code', 'like', '110%')
            ->with(['transactionDetails' => function ($query) use ($year, $month) {
                $query->whereHas('transaction', function ($q) use ($year, $month) {
                    $q->whereYear('transaction_date', $year)
                        ->whereMonth('transaction_date', $month)
                        ->where('type', 'cash_out');
                });
            }])
            ->first();

        if ($request->has('export')) {
            $pdf = PDF::loadView('staff.reports.cash-flow-pdf', compact('cashIn', 'cashOut', 'year', 'month'));
            return $pdf->download('laporan-arus-kas-' . $year . '-' . $month . '.pdf');
        }

        return view('staff.reports.cash-flow', compact('cashIn', 'cashOut', 'year', 'month'));
    }
}
