# Kopi-Paste — Aplikasi Kasir Pemesanan Kopi

Repository ini dibuat untuk memenuhi tugas dari mata kuliah **Workshop Web Lanjut** dengan menggunakan **Framework Laravel 12**. Proyek ini merupakan aplikasi kasir sederhana yang digunakan untuk mengelola pemesanan kopi pada sebuah cafe.

## Fitur Utama
- Pengelolaan menu kopi dan kategori.
- Pencatatan pesanan pelanggan.
- Sistem kasir dengan perhitungan total otomatis.
- Riwayat pemesanan dan laporan dasar.
- Antarmuka responsif untuk memudahkan penggunaan oleh mahasigma maupun staf cafe.

## Teknologi yang Digunakan
- Laravel 12
- PHP 8+
- MySQL / MariaDB
- Blade Templates
- Bootstrap / Tailwind (opsional)

## Tujuan Pengembangan
Proyek ini bertujuan untuk mengimplementasikan konsep:
- MVC pada Laravel
- Manajemen basis data
- Pengembangan aplikasi web yang fungsional dan terstruktur

## Cara Menjalankan
1. Clone repository:
   ```git clone https://github.com/fyou00/kopi-paste```
2. Install dependencies:
   ```composer install --no-dev```
3. Salin file environment:
   ```cp .env.example .env```
4. Generate key
   ```php artisan key:generate```
5. Migrasi database:
   ```php artisan migrate```
6. Jalankan
   ```php artisan serve```