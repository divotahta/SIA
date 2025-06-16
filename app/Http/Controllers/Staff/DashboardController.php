<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data untuk dashboard
        $totalTransactions = Transaction::count();
        $totalJournals = TransactionDetail::count();
        $todayTransactions = Transaction::whereDate('transaction_date', today())->count();
        
        // Mengambil 5 transaksi terakhir
        $latestTransactions = Transaction::with('details')
            ->latest()
            ->take(5)
            ->get();

        return view('staff.dashboard', compact(
            'totalTransactions',
            'totalJournals',
            'todayTransactions',
            'latestTransactions'
        ));
    }
} 