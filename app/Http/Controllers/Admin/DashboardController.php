<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data untuk dashboard
        $totalAccounts = Account::count();
        $totalTransactions = Transaction::count();
        $totalJournals = TransactionDetail::count();
        $todayTransactions = Transaction::whereDate('transaction_date', today())->count();
        $totalIncome = Transaction::where('type', 'cash_in')->sum('total_amount');
        $totalExpense = Transaction::where('type', 'cash_out')->sum('total_amount');
        $totalBalance = $totalIncome - $totalExpense;
        $totalBalance = $totalBalance > 0 ? $totalBalance : 0;


        // Mengambil 10 transaksi terakhir
        $latestTransactions = Transaction::with('details')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalAccounts',
            'totalTransactions',
            'totalJournals',
            'todayTransactions',
            'latestTransactions',
            'totalIncome',
            'totalExpense',
            'totalBalance'
        ));
    }
} 