<?php

namespace Database\Seeders;

use App\Models\AccountCategory;
use Illuminate\Database\Seeder;

class AccountCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'code' => '1',
                'name' => 'Aset',
                'description' => 'Kategori untuk akun-akun aset'
            ],
            [
                'code' => '2',
                'name' => 'Kewajiban',
                'description' => 'Kategori untuk akun-akun kewajiban'
            ],
            [
                'code' => '3',
                'name' => 'Modal',
                'description' => 'Kategori untuk akun-akun modal'
            ],
            [
                'code' => '4',
                'name' => 'Pendapatan',
                'description' => 'Kategori untuk akun-akun pendapatan'
            ],
            [
                'code' => '5',
                'name' => 'Beban',
                'description' => 'Kategori untuk akun-akun beban'
            ],
        ];

        foreach ($categories as $category) {
            AccountCategory::create($category);
        }
    }
} 