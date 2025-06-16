<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountCategory;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run()
    {
        // Aset (Kategori 1)
        $aset = AccountCategory::where('code', '1')->first();
        $accounts = [
            [
                'code' => '1101',
                'name' => 'Kas',
                'type' => 'asset',
                'category_id' => $aset->id,
                'description' => 'Kas perusahaan'
            ],
            [
                'code' => '1102',
                'name' => 'Bank',
                'type' => 'asset',
                'category_id' => $aset->id,
                'description' => 'Rekening bank perusahaan'
            ],
            [
                'code' => '1201',
                'name' => 'Piutang Usaha',
                'type' => 'asset',
                'category_id' => $aset->id,
                'description' => 'Piutang dari pelanggan'
            ],
            [
                'code' => '1301',
                'name' => 'Peralatan',
                'type' => 'asset',
                'category_id' => $aset->id,
                'description' => 'Peralatan kantor'
            ],
        ];

        // Kewajiban (Kategori 2)
        $kewajiban = AccountCategory::where('code', '2')->first();
        $accounts = array_merge($accounts, [
            [
                'code' => '2101',
                'name' => 'Hutang Usaha',
                'type' => 'liability',
                'category_id' => $kewajiban->id,
                'description' => 'Hutang kepada supplier'
            ],
            [
                'code' => '2102',
                'name' => 'Hutang Bank',
                'type' => 'liability',
                'category_id' => $kewajiban->id,
                'description' => 'Hutang bank'
            ],
        ]);

        // Modal (Kategori 3)
        $modal = AccountCategory::where('code', '3')->first();
        $accounts = array_merge($accounts, [
            [
                'code' => '3101',
                'name' => 'Modal Pemilik',
                'type' => 'equity',
                'category_id' => $modal->id,
                'description' => 'Modal awal pemilik'
            ],
            [
                'code' => '3201',
                'name' => 'Laba Ditahan',
                'type' => 'equity',
                'category_id' => $modal->id,
                'description' => 'Laba yang ditahan'
            ],
        ]);

        // Pendapatan (Kategori 4)
        $pendapatan = AccountCategory::where('code', '4')->first();
        $accounts = array_merge($accounts, [
            [
                'code' => '4101',
                'name' => 'Pendapatan Jasa',
                'type' => 'revenue',
                'category_id' => $pendapatan->id,
                'description' => 'Pendapatan dari jasa'
            ],
            [
                'code' => '4102',
                'name' => 'Pendapatan Penjualan',
                'type' => 'revenue',
                'category_id' => $pendapatan->id,
                'description' => 'Pendapatan dari penjualan'
            ],
        ]);

        // Beban (Kategori 5)
        $beban = AccountCategory::where('code', '5')->first();
        $accounts = array_merge($accounts, [
            [
                'code' => '5101',
                'name' => 'Beban Gaji',
                'type' => 'expense',
                'category_id' => $beban->id,
                'description' => 'Beban gaji karyawan'
            ],
            [
                'code' => '5102',
                'name' => 'Beban Sewa',
                'type' => 'expense',
                'category_id' => $beban->id,
                'description' => 'Beban sewa kantor'
            ],
            [
                'code' => '5103',
                'name' => 'Beban Utilitas',
                'type' => 'expense',
                'category_id' => $beban->id,
                'description' => 'Beban listrik, air, dll'
            ],
        ]);

        foreach ($accounts as $account) {
            Account::create($account);
        }
    }
} 