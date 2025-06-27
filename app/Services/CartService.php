<?php

namespace App\Services;

use App\Models\Pesanan;
use App\Models\VarianMenu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * CartService Class
 *
 * Ini adalah pusat dari semua logika yang berhubungan dengan keranjang belanja.
 * Menggunakan Laravel Session untuk menyimpan data, sehingga bekerja untuk
 * pengguna yang login maupun yang belum login (tamu).
 */
class CartService
{
    /**
     * Menambahkan item ke keranjang. Jika item sudah ada, jumlahnya akan bertambah.
     *
     * @param int $varianMenuId ID dari varian menu yang akan ditambahkan.
     * @param int $quantity Jumlah yang akan ditambahkan.
     * @return void
     */
    public static function add(int $varianMenuId, int $quantity = 1): void
    {
        // Ambil isi keranjang saat ini dari session
        $cart = self::getContents();
        $varian = VarianMenu::with('daftarMenu')->find($varianMenuId);

        // Jangan lakukan apapun jika varian tidak ditemukan di database
        if (!$varian) {
            return;
        }

        // Jika item sudah ada di keranjang, tambahkan quantity-nya
        if ($cart->has($varianMenuId)) {
            $cart[$varianMenuId]['quantity'] += $quantity;
        } else {
            // Jika item baru, tambahkan ke keranjang dengan data yang diperlukan
            $cart[$varianMenuId] = [
                'id'           => $varianMenuId,
                'name'         => $varian->daftarMenu->nama_menu,
                'variant_name' => $varian->nama_varian,
                'price'        => $varian->harga,
                'quantity'     => $quantity,
                'image'        => $varian->daftarMenu->url_gambar, // Simpan path gambar untuk ditampilkan di cart
            ];
        }

        // Simpan kembali keranjang yang sudah diperbarui ke dalam session
        session(['cart' => $cart]);
    }

    /**
     * Mengupdate jumlah item di keranjang.
     *
     * @param int $varianMenuId ID varian yang akan diupdate.
     * @param int $quantity Jumlah baru.
     * @return void
     */
    public static function update(int $varianMenuId, int $quantity): void
    {
        $cart = self::getContents();

        if ($cart->has($varianMenuId)) {
            // Jika quantity 0 atau kurang, hapus item dari keranjang
            if ($quantity <= 0) {
                self::remove($varianMenuId);
            } else {
                // Jika tidak, update jumlahnya
                $cart[$varianMenuId]['quantity'] = $quantity;
                session(['cart' => $cart]);
            }
        }
    }

    /**
     * Menghapus item dari keranjang berdasarkan ID-nya.
     *
     * @param int $varianMenuId
     * @return void
     */
    public static function remove(int $varianMenuId): void
    {
        $cart = self::getContents();
        $cart->forget($varianMenuId);
        session(['cart' => $cart]);
    }

    /**
     * Mengambil seluruh isi keranjang dari session.
     * Mengembalikannya sebagai Laravel Collection agar mudah dimanipulasi.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getContents(): Collection
    {
        return collect(session('cart', []));
    }

    /**
     * Menghitung total harga dari seluruh item di keranjang.
     *
     * @return float
     */
    public static function getTotal(): float
    {
        return self::getContents()->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    /**
     * Menghitung jumlah total item (bukan jenis item) di keranjang.
     *
     * @return int
     */
    public static function getCount(): int
    {
        return self::getContents()->sum('quantity');
    }

    /**
     * Mengosongkan seluruh keranjang belanja.
     * Berguna setelah checkout berhasil.
     *
     * @return void
     */
    public static function clear(): void
    {
        session()->forget('cart');
    }

    /**
     * Memproses checkout: menyimpan data dari keranjang ke database.
     *
     * @param string $paymentMethod Metode pembayaran yang dipilih.
     * @param string|null $customerName Nama pelanggan jika memesan sebagai tamu.
     * @return \App\Models\Pesanan|null Pesanan yang baru dibuat, atau null jika gagal.
     */
    public static function checkout(string $paymentMethod, string $customerName = null): ?Pesanan
    {
        $cartItems = self::getContents();
        $mejaId = session('meja_id');
        $total = self::getTotal();

        // Validasi: Jangan proses jika keranjang kosong atau meja tidak terdeteksi.
        if ($cartItems->isEmpty() || !$mejaId) {
            return null;
        }

        // Tentukan status pembayaran awal berdasarkan metode
        $paymentStatus = ($paymentMethod === 'kasir') ? 'menunggu' : 'menunggu';

        // Buat pesanan utama di tabel 'pesanans'
        $pesanan = Pesanan::create([
            'daftar_meja_id'    => $mejaId,
            'user_id'           => Auth::id(), // Akan null jika pengguna tidak login
            'nama_pelanggan'    => !Auth::check() ? $customerName : null, // Isi nama jika tamu
            'total_bayar'       => $total,
            'metode_pembayaran' => $paymentMethod, // <-- SIMPAN METODE PEMBAYARAN
            'status_pesanan'    => 'baru',
            'status_bayar'      => $paymentStatus,
        ]);

        // Siapkan data detail pesanan untuk disimpan
        $detailPesananData = [];
        foreach ($cartItems as $itemId => $item) {
            $detailPesananData[] = [
                'pesanan_id'       => $pesanan->id,
                'varian_menu_id'   => $itemId,
                'jumlah'           => $item['quantity'],
                'harga_saat_pesan' => $item['price'],
                'created_at'       => now(),
                'updated_at'       => now(),
            ];
        }

        // Simpan semua detail pesanan ke tabel 'detail_pesanans'
        DB::table('detail_pesanans')->insert($detailPesananData);

        // Kosongkan keranjang setelah checkout berhasil
        self::clear();

        return $pesanan;
    }
}
