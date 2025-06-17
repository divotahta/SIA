<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $accounts = [
            // Aset (category_id = 1)
            ['code' => '1101', 'name' => 'Kas', 'category_id' => 1, 'description' => 'Kas perusahaan'],
            ['code' => '1102', 'name' => 'Bank', 'category_id' => 1, 'description' => 'Rekening bank perusahaan'],
            ['code' => '1201', 'name' => 'Piutang Usaha', 'category_id' => 1, 'description' => 'Piutang dari pelanggan'],
            ['code' => '1301', 'name' => 'Persediaan', 'category_id' => 1, 'description' => 'Persediaan barang dagangan'],
            ['code' => '1401', 'name' => 'Beban Dibayar di Muka', 'category_id' => 1, 'description' => 'Beban yang dibayar di muka'],
            ['code' => '1501', 'name' => 'Peralatan', 'category_id' => 1, 'description' => 'Peralatan kantor'],
            ['code' => '1502', 'name' => 'Akumulasi Penyusutan Peralatan', 'category_id' => 1, 'description' => 'Akumulasi penyusutan peralatan'],
            ['code' => '1601', 'name' => 'Kendaraan', 'category_id' => 1, 'description' => 'Kendaraan perusahaan'],
            ['code' => '1602', 'name' => 'Akumulasi Penyusutan Kendaraan', 'category_id' => 1, 'description' => 'Akumulasi penyusutan kendaraan'],

            // Kewajiban (category_id = 2)
            ['code' => '2101', 'name' => 'Hutang Usaha', 'category_id' => 2, 'description' => 'Hutang kepada supplier'],
            ['code' => '2102', 'name' => 'Hutang Gaji', 'category_id' => 2, 'description' => 'Hutang gaji karyawan'],
            ['code' => '2103', 'name' => 'Hutang Pajak', 'category_id' => 2, 'description' => 'Hutang pajak perusahaan'],
            ['code' => '2201', 'name' => 'Hutang Bank', 'category_id' => 2, 'description' => 'Hutang bank'],

            // Modal (category_id = 3)
            ['code' => '3101', 'name' => 'Modal', 'category_id' => 3, 'description' => 'Modal awal perusahaan'],
            ['code' => '3201', 'name' => 'Laba Ditahan', 'category_id' => 3, 'description' => 'Laba yang ditahan'],

            // Pendapatan (category_id = 4)
            ['code' => '4101', 'name' => 'Pendapatan Usaha', 'category_id' => 4, 'description' => 'Pendapatan dari usaha utama'],
            ['code' => '4201', 'name' => 'Pendapatan Lain-lain', 'category_id' => 4, 'description' => 'Pendapatan di luar usaha utama'],

            // Beban (category_id = 5)
            ['code' => '5101', 'name' => 'Beban Gaji', 'category_id' => 5, 'description' => 'Beban gaji karyawan'],
            ['code' => '5102', 'name' => 'Beban Listrik', 'category_id' => 5, 'description' => 'Beban listrik'],
            ['code' => '5103', 'name' => 'Beban Air', 'category_id' => 5, 'description' => 'Beban air'],
            ['code' => '5104', 'name' => 'Beban Telepon', 'category_id' => 5, 'description' => 'Beban telepon'],
            ['code' => '5105', 'name' => 'Beban Internet', 'category_id' => 5, 'description' => 'Beban internet'],
            ['code' => '5106', 'name' => 'Beban Sewa', 'category_id' => 5, 'description' => 'Beban sewa'],
            ['code' => '5201', 'name' => 'Beban Pajak', 'category_id' => 5, 'description' => 'Beban pajak'],
            ['code' => '5202', 'name' => 'Beban Bunga', 'category_id' => 5, 'description' => 'Beban bunga'],
            ['code' => '5203', 'name' => 'Beban Penyusutan', 'category_id' => 5, 'description' => 'Beban penyusutan'],
        ];

        foreach ($accounts as $account) {
            Account::create($account);
        }
    }
}
