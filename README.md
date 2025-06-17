# Sistem Informasi Akuntansi UMKM

Sistem Informasi Akuntansi untuk Usaha Mikro, Kecil, dan Menengah (UMKM) yang membantu dalam pengelolaan keuangan dan pembuatan laporan keuangan.

## Fitur Utama

### 1. Manajemen Akun
- Pengelolaan akun dengan kode dan kategori yang terstruktur
- Kategori akun:
  - Aktiva (1xxx)
    - Kas dan Bank (11xx)
    - Piutang (12xx)
    - Persediaan (13xx)
    - Beban Dibayar di Muka (14xx)
    - Peralatan (15xx)
    - Kendaraan (16xx)
  - Kewajiban (2xxx)
    - Hutang Usaha (21xx)
    - Hutang Bank (22xx)
  - Modal (3xxx)
    - Modal (31xx)
    - Laba Ditahan (32xx)
  - Pendapatan (4xxx)
    - Pendapatan Usaha (41xx)
    - Pendapatan Lain-lain (42xx)
  - Beban (5xxx)
    - Beban Operasional (51xx)
    - Beban Non Operasional (52xx)

### 2. Transaksi Keuangan
- Pencatatan transaksi keuangan
- Jenis transaksi:
  - Penerimaan Kas (Cash In)
  - Pengeluaran Kas (Cash Out)
  - Transaksi Umum (General)
- Detail transaksi dengan debit dan kredit
- Nomor referensi otomatis
- Deskripsi transaksi

### 3. Laporan Keuangan
- Laporan Neraca
- Laporan Laba Rugi
  - Pendapatan
  - Beban
  - Laba/Rugi
- Laporan Arus Kas
  - Arus Kas Operasi
  - Arus Kas Investasi
  - Arus Kas Pendanaan
- Export PDF untuk semua laporan

### 4. Manajemen Pengguna
- Multi-level user:
  - Admin
  - Staff
- Fitur profil pengguna
- Manajemen hak akses


## Instalasi

1. Clone repository
```bash
git clone [url-repository]
```

2. Install dependencies
```bash
composer install
```

3. Copy file .env
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Konfigurasi database di file .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sia_umkm
DB_USERNAME=root
DB_PASSWORD=
```

6. Jalankan migrasi dan seeder
```bash
php artisan migrate --seed
```

7. Jalankan server development
```bash
php artisan serve
```

## Penggunaan

1. Login dengan kredensial default:
   - Admin:
     - Email: admin@example.com
     - Password: password
   - Staff:
     - Email: staff@example.com
     - Password: password

2. Mulai dengan:
   - Mengatur akun-akun yang diperlukan
   - Mencatat transaksi keuangan
   - Membuat laporan keuangan

## Kontribusi

Silakan buat pull request untuk kontribusi. Untuk perubahan besar, harap buka issue terlebih dahulu untuk mendiskusikan perubahan yang diinginkan.

## Lisensi

[MIT](https://choosealicense.com/licenses/mit/)
