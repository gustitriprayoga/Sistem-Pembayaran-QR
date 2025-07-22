# Sistem Pemesanan QR Code - Tuan Coffee V1

![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?style=for-the-badge&logo=laravel)
![Livewire](https://img.shields.io/badge/Livewire-3-4d56e0?style=for-the-badge)
![Filament](https://img.shields.io/badge/Filament-3-f59e0b?style=for-the-badge)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap)

Sebuah aplikasi web modern yang dirancang untuk Tuan Coffee, memungkinkan pelanggan untuk memesan menu secara langsung dari meja mereka hanya dengan melakukan pemindaian QR Code. Proyek ini dibangun menggunakan TALL stack (Tailwind di backend) dan Bootstrap 5 di frontend untuk pengalaman pelanggan yang optimal.

## Daftar Isi
- [Tentang Proyek](#tentang-proyek)
  - [Fitur Utama](#fitur-utama)
  - [Dibangun Dengan](#dibangun-dengan)
- [Memulai](#memulai)
  - [Prasyarat](#prasyarat)
  - [Instalasi](#instalasi)
- [Cara Penggunaan](#cara-penggunaan)
  - [Panel Admin](#panel-admin)
  - [Alur Pelanggan](#alur-pelanggan)
- [Roadmap Fitur](#roadmap-fitur)

## Tentang Proyek

Proyek ini bertujuan untuk mendigitalisasi proses pemesanan di Tuan Coffee, mengatasi masalah antrean panjang di kasir dan meningkatkan efisiensi operasional. Pelanggan dapat dengan mudah melihat menu, memilih varian, memesan, dan mendapatkan instruksi pembayaran langsung dari ponsel mereka.

### Fitur Utama

* **Panel Admin (Filament):**
    * Manajemen Peran & Pengguna (Admin & Karyawan) menggunakan `spatie/laravel-permission`.
    * CRUD lengkap untuk Menu, Kategori, dan Varian (dengan harga berbeda).
    * Manajemen Meja dengan fitur **Generate QR Code** otomatis untuk setiap meja.
    * Halaman Laporan Penjualan dinamis dengan filter Harian, Mingguan, Bulanan, dan Tahunan.
    * Tampilan detail pesanan masuk yang informatif.

* **Frontend Pelanggan (Livewire + Bootstrap 5):**
    * **Deteksi Meja Otomatis:** Scan QR code akan langsung membawa pelanggan ke halaman pemesanan dengan nomor meja yang sudah terdeteksi.
    * **Halaman Dinamis:** Menampilkan produk "Paling Laris" beserta jumlah penjualan dan daftar menu yang bisa difilter per kategori.
    * **Modal Detail Produk:** Pengguna bisa memilih varian produk (misal: Panas/Dingin) sebelum menambahkan ke keranjang.
    * **Sistem Keranjang Belanja:** Keranjang belanja interaktif berbasis Session, berfungsi bahkan untuk pelanggan yang belum login.
    * **Alur Checkout:** Proses checkout dengan pilihan metode pembayaran (Kasir, Transfer Bank, E-Wallet) dan halaman sukses yang menampilkan instruksi pembayaran/QRIS.

### Dibangun Dengan

Berikut adalah teknologi utama yang digunakan dalam proyek ini:

* [Laravel 10](https://laravel.com/)
* [Livewire 3](https://livewire.laravel.com/)
* [Filament 3](https://filamentphp.com/)
* [Bootstrap 5](https://getbootstrap.com/)
* [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v1/introduction)
* [Simple QrCode](https://www.simplesoftware.io/docs/simple-qrcode)

## Memulai

Untuk menjalankan proyek ini secara lokal, ikuti langkah-langkah berikut.

### Prasyarat

Pastikan Anda sudah menginstal perangkat lunak berikut di mesin Anda:
* PHP (versi 8.1+)
* Composer
* Node.js & NPM
* Database (misal: MySQL, MariaDB)

### Instalasi

1.  **Clone repository**
    ```sh
    git clone [https://url-repository-anda.git](https://url-repository-anda.git)
    cd nama-proyek
    ```

2.  **Install dependensi PHP**
    ```sh
    composer install
    ```

3.  **Install dependensi JavaScript**
    ```sh
    npm install && npm run build
    ```

4.  **Siapkan file Environment**
    Salin file `.env.example` menjadi `.env`.
    ```sh
    cp .env.example .env
    ```
    Kemudian, generate application key.
    ```sh
    php artisan key:generate
    ```

5.  **Konfigurasi Database**
    Buat database baru, lalu buka file `.env` dan sesuaikan variabel `DB_*` dengan kredensial database Anda.
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=tuan_coffee
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Jalankan Migrasi dan Seeder**
    Perintah ini akan membuat semua tabel database dan mengisinya dengan data awal (termasuk user admin & karyawan, menu, meja, dan data transaksi palsu).
    ```sh
    php artisan migrate:fresh --seed
    ```

7.  **Buat Storage Link**
    Ini penting untuk menampilkan gambar produk dan QR code yang di-generate.
    ```sh
    php artisan storage:link
    ```

8.  **Jalankan server pengembangan**
    ```sh
    php artisan serve
    ```
    Aplikasi sekarang berjalan di `http://127.0.0.1:8000`.

## Cara Penggunaan

### Panel Admin

* **URL:** `http://127.0.0.1:8000/admin`
* **Login Admin:**
    * Email: `admin@tuancoffee.com`
    * Password: `password`
* **Login Karyawan:**
    * Email: `karyawan@tuancoffee.com`
    * Password: `password`

Admin memiliki akses penuh, sementara Karyawan hanya bisa melihat menu, meja, dan pesanan masuk.

### Alur Pelanggan

Untuk mensimulasikan pemindaian QR code di meja, Anda bisa langsung mengakses URL dengan menambahkan parameter `?meja={id}`.

* **Contoh:** Buka `http://127.0.0.1:8000/?meja=1` di browser Anda.
    Ini akan mensimulasikan pelanggan yang sedang duduk di **Meja 1**.

## Roadmap Fitur

Beberapa ide fitur yang bisa dikembangkan di masa depan:
* [ ] Integrasi dengan Payment Gateway (Midtrans, Xendit) untuk pembayaran E-Wallet dan VA otomatis.
* [ ] Sistem Poin & Loyalty untuk pelanggan terdaftar.
* [ ] Notifikasi real-time ke panel admin saat pesanan baru masuk menggunakan WebSockets.
* [ ] Fitur reservasi meja.
* [ ] Fitur reservasi meja.

