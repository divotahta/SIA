<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\AccountCategory;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::with('category')
            ->orderBy('code')
            ->paginate(10);

        return view('admin.accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = AccountCategory::orderBy('name')->get();
        return view('admin.accounts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:accounts,code',
            'name' => 'required',
            'category_id' => 'required|exists:account_categories,id',
            'description' => 'nullable',
        ]);

        Account::create($validated);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Akun berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        $categories = AccountCategory::orderBy('name')->get();
        return view('admin.accounts.edit', compact('account', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        $validated = $request->validate([
            'code' => 'required|unique:accounts,code,' . $account->id,
            'name' => 'required',
            'category_id' => 'required|exists:account_categories,id',
            'description' => 'nullable',
        ]);

        $account->update($validated);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        if ($account->transactionDetails()->exists()) {
            return back()->with('error', 'Akun tidak dapat dihapus karena masih digunakan dalam transaksi.');
        }

        $account->delete();

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
}
