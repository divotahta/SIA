<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        // Transaksi Modal Awal
        $modalPemilik = Account::where('code', '3101')->first();
        $kas = Account::where('code', '1101')->first();

        DB::transaction(function () use ($modalPemilik, $kas) {
            $transaction = Transaction::create([
                'transaction_date' => now(),
                'reference_number' => 'TRX-' . date('Ymd') . '-001',
                'description' => 'Setoran modal awal',
                'type' => 'cash_in',
                'total_amount' => 100000000
            ]);

            // Debit Kas
            $transaction->details()->create([
                'account_id' => $kas->id,
                'debit_amount' => 100000000,
                'credit_amount' => 0,
                'description' => 'Penerimaan modal awal'
            ]);

            // Kredit Modal
            $transaction->details()->create([
                'account_id' => $modalPemilik->id,
                'debit_amount' => 0,
                'credit_amount' => 100000000,
                'description' => 'Setoran modal awal'
            ]);
        });

        // Transaksi Pembelian Peralatan
        $peralatan = Account::where('code', '1301')->first();
        $bank = Account::where('code', '1102')->first();

        DB::transaction(function () use ($peralatan, $bank) {
            $transaction = Transaction::create([
                'transaction_date' => now(),
                'reference_number' => 'TRX-' . date('Ymd') . '-002',
                'description' => 'Pembelian peralatan kantor',
                'type' => 'cash_out',
                'total_amount' => 15000000
            ]);

            // Debit Peralatan
            $transaction->details()->create([
                'account_id' => $peralatan->id,
                'debit_amount' => 15000000,
                'credit_amount' => 0,
                'description' => 'Pembelian peralatan kantor'
            ]);

            // Kredit Bank
            $transaction->details()->create([
                'account_id' => $bank->id,
                'debit_amount' => 0,
                'credit_amount' => 15000000,
                'description' => 'Pembayaran peralatan kantor'
            ]);
        });

        // Transaksi Pendapatan Jasa
        $pendapatanJasa = Account::where('code', '4101')->first();

        DB::transaction(function () use ($pendapatanJasa, $kas) {
            $transaction = Transaction::create([
                'transaction_date' => now(),
                'reference_number' => 'TRX-' . date('Ymd') . '-003',
                'description' => 'Pendapatan jasa konsultasi',
                'type' => 'cash_in',
                'total_amount' => 5000000
            ]);

            // Debit Kas
            $transaction->details()->create([
                'account_id' => $kas->id,
                'debit_amount' => 5000000,
                'credit_amount' => 0,
                'description' => 'Penerimaan pendapatan jasa'
            ]);

            // Kredit Pendapatan
            $transaction->details()->create([
                'account_id' => $pendapatanJasa->id,
                'debit_amount' => 0,
                'credit_amount' => 5000000,
                'description' => 'Pendapatan jasa konsultasi'
            ]);
        });
    }
} 