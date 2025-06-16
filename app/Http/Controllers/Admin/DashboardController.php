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
        
        // Mengambil 5 transaksi terakhir
        $latestTransactions = Transaction::with('details')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalAccounts',
            'totalTransactions',
            'totalJournals',
            'todayTransactions',
            'latestTransactions'
        ));
    }
} 