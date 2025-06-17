<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\AccountController as AdminAccountController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Staff\TransactionController as StaffTransactionController;
use App\Http\Controllers\Staff\ReportController as StaffReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware(['auth'])->group(function () {
    // Route::get('/', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    // Routes untuk Staff
    Route::middleware(['role:staff,admin'])->group(function () {
        // Transaction Management
        Route::resource('staff/transactions', StaffTransactionController::class)->names([
            'index' => 'staff.transactions.index',
            'create' => 'staff.transactions.create',
            'store' => 'staff.transactions.store',
            'show' => 'staff.transactions.show',
            'edit' => 'staff.transactions.edit',
            'update' => 'staff.transactions.update',
            'destroy' => 'staff.transactions.destroy',
        ]);
        Route::get('staff/accounts/{account}/ledger', [StaffTransactionController::class, 'ledger'])->name('staff.accounts.ledger');

        // Staff Reports
        Route::get('staff/reports/income-statement', [StaffReportController::class, 'incomeStatement'])->name('staff.reports.income-statement');
        Route::get('staff/reports/balance-sheet', [StaffReportController::class, 'balanceSheet'])->name('staff.reports.balance-sheet');
        Route::get('staff/reports/cash-flow', [StaffReportController::class, 'cashFlow'])->name('staff.reports.cash-flow');
    });

    // Routes untuk Admin
    Route::middleware(['role:admin'])->group(function () {
        // Account Management
        Route::resource('admin/accounts', AdminAccountController::class)->names([
            'index' => 'admin.accounts.index',
            'create' => 'admin.accounts.create',
            'store' => 'admin.accounts.store',
            'show' => 'admin.accounts.show',
            'edit' => 'admin.accounts.edit',
            'update' => 'admin.accounts.update',
            'destroy' => 'admin.accounts.destroy',
        ]);

        // Admin Transaction Management
        Route::resource('admin/transactions', AdminTransactionController::class)->names([
            'index' => 'admin.transactions.index',
            'create' => 'admin.transactions.create',
            'store' => 'admin.transactions.store',
            'show' => 'admin.transactions.show',
            'edit' => 'admin.transactions.edit',
            'update' => 'admin.transactions.update',
            'destroy' => 'admin.transactions.destroy',
        ]);
        Route::get('admin/accounts/{account}/ledger', [AdminTransactionController::class, 'ledger'])->name('admin.accounts.ledger');

        // Admin Reports
        Route::get('admin/reports/income-statement', [AdminReportController::class, 'incomeStatement'])->name('admin.reports.income-statement');
        Route::get('admin/reports/balance-sheet', [AdminReportController::class, 'balanceSheet'])->name('admin.reports.balance-sheet');
        Route::get('admin/reports/cash-flow', [AdminReportController::class, 'cashFlow'])->name('admin.reports.cash-flow');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    // ... existing admin routes ...
});

// Staff Routes
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('dashboard');
    // ... existing staff routes ...
});

require __DIR__.'/auth.php';
