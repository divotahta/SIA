<?php

namespace App\Http\Controllers\Staff;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\AccountCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class ReportController extends Controller
{
    public function incomeStatement(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month');

        $query = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('accounts', 'transaction_details.account_id', '=', 'accounts.id')
            ->whereYear('transactions.transaction_date', $year);

        if ($month) {
            $query->whereMonth('transactions.transaction_date', $month);
        }

        // Pendapatan (Kategori 4)
        $pendapatan = $query->clone()
            ->where('accounts.category_id', 4)
            ->select('accounts.name', DB::raw('SUM(transaction_details.credit_amount - transaction_details.debit_amount) as total'))
            ->groupBy('accounts.id', 'accounts.name')
            ->get();

        // Beban (Kategori 5)
        $beban = $query->clone()
            ->where('accounts.category_id', 5)
            ->select('accounts.name', DB::raw('SUM(transaction_details.debit_amount - transaction_details.credit_amount) as total'))
            ->groupBy('accounts.id', 'accounts.name')
            ->get();

        if ($request->has('export')) {
            $pdf = Pdf::loadView('staff.reports.income-statement-pdf', compact('pendapatan', 'beban', 'year', 'month'));
            return $pdf->download('laporan-laba-rugi-' . $year . ($month ? '-' . $month : '') . '.pdf');
        }

        return view('staff.reports.income-statement', compact('pendapatan', 'beban'));
    }

    public function balanceSheet(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month');

        $query = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('accounts', 'transaction_details.account_id', '=', 'accounts.id')
            ->whereYear('transactions.transaction_date', $year);

        if ($month) {
            $query->whereMonth('transactions.transaction_date', $month);
        }

        // Aktiva (Kategori 1) Aset
        $aktiva = $query->clone()
            ->where('accounts.category_id', 1)
            ->select('accounts.name', DB::raw('SUM(transaction_details.debit_amount - transaction_details.credit_amount) as total'))
            ->groupBy('accounts.id', 'accounts.name')
            ->get();

        // Pasiva (Kategori 2 dan 3) Kewajiban dan Modal
        $pasiva = $query->clone()
            ->whereIn('accounts.category_id', [2, 3])
            ->select('accounts.name', DB::raw('SUM(transaction_details.credit_amount - transaction_details.debit_amount) as total'))
            ->groupBy('accounts.id', 'accounts.name')
            ->get();

        if ($request->has('export')) {
            $pdf = Pdf::loadView('staff.reports.balance-sheet-pdf', compact('aktiva', 'pasiva'));
            return $pdf->download('laporan-neraca.pdf');
        }

        return view('staff.reports.balance-sheet', compact('aktiva', 'pasiva'));
    }

    public function cashFlow(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month');

        $query = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('accounts', 'transaction_details.account_id', '=', 'accounts.id')
            ->whereYear('transactions.transaction_date', $year);

        if ($month) {
            $query->whereMonth('transactions.transaction_date', $month);
        }

        // Arus Kas dari Aktivitas Operasi
        $operasi = $query->clone()
            ->whereIn('accounts.category_id', [4, 5]) // Pendapatan dan Beban
            ->select('accounts.name', DB::raw('SUM(transaction_details.credit_amount - transaction_details.debit_amount) as total'))
            ->groupBy('accounts.id', 'accounts.name')
            ->get();

        // Arus Kas dari Aktivitas Investasi
        $investasi = $query->clone()
            ->where('accounts.category_id', 1) // Aset
            ->whereNotIn('accounts.code', ['1101']) // Kecuali Kas
            ->select('accounts.name', DB::raw('SUM(transaction_details.debit_amount - transaction_details.credit_amount) as total'))
            ->groupBy('accounts.id', 'accounts.name')
            ->get();

        // Arus Kas dari Aktivitas Pendanaan
        $pendanaan = $query->clone()
            ->whereIn('accounts.category_id', [2, 3]) // Kewajiban dan Modal
            ->select('accounts.name', DB::raw('SUM(transaction_details.credit_amount - transaction_details.debit_amount) as total'))
            ->groupBy('accounts.id', 'accounts.name')
            ->get();

        // Kas Awal Periode
        $kasAwal = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('accounts', 'transaction_details.account_id', '=', 'accounts.id')
            ->where('accounts.code', '1101') // Kas
            ->where(function($q) use ($year, $month) {
                if ($month) {
                    $q->whereYear('transactions.transaction_date', $year)
                      ->whereMonth('transactions.transaction_date', '<', $month);
                } else {
                    $q->whereYear('transactions.transaction_date', '<', $year);
                }
            })
            ->select(DB::raw('SUM(transaction_details.debit_amount - transaction_details.credit_amount) as total'))
            ->value('total') ?? 0;

        if ($request->has('export')) {
            $pdf = Pdf::loadView('staff.reports.cash-flow-pdf', compact('operasi', 'investasi', 'pendanaan', 'kasAwal'));
            return $pdf->download('laporan-arus-kas-' . $year . ($month ? '-' . $month : '') . '.pdf');
        }

        return view('staff.reports.cash-flow', compact('operasi', 'investasi', 'pendanaan', 'kasAwal'));
    }

    public function balanceSheetPdf()
    {
        // Ambil data aktiva
        $aktiva = AccountCategory::where('code', '1')->first();

        // Ambil data kewajiban
        $kewajiban = AccountCategory::where('code', '2')->first();

        // Ambil data modal
        $modal = AccountCategory::where('code', '3')->first();

        // Hitung total aktiva
        $totalAktiva = Account::where('category_id', $aktiva->id)
            ->sum('total');

        // Hitung total kewajiban
        $totalKewajiban = Account::where('category_id', $kewajiban->id)
            ->sum('balance');

        // Hitung total modal
        $totalModal = Account::where('category_id', $modal->id)
            ->sum('balance');

        // Data untuk view
        $data = [
            'title' => 'Laporan Neraca',
            'date' => now()->format('d F Y'),
            'aktiva' => Account::where('category_id', $aktiva->id)->get(),
            'kewajiban' => Account::where('category_id', $kewajiban->id)->get(),
            'modal' => Account::where('category_id', $modal->id)->get(),
            'totalAktiva' => $totalAktiva,
            'totalKewajiban' => $totalKewajiban,
            'totalModal' => $totalModal,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('staff.reports.balance-sheet-pdf', $data);
        
        // Set paper size dan orientation
        $pdf->setPaper('a4', 'portrait');

        // Download PDF
        return $pdf->download('neraca-' . now()->format('Y-m-d') . '.pdf');
    }
}
