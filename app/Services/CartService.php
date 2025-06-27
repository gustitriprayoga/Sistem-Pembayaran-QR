<?php

namespace App\Services;

use App\Models\Pesanan;
use App\Models\VarianMenu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CartService
{
    /**
     * Menambahkan item ke keranjang. Jika item sudah ada, jumlahnya akan bertambah.
     */
    public static function add(int $varianMenuId, int $quantity = 1): void
    {
        $cart = self::getContents();
        $varian = VarianMenu::with('daftarMenu')->find($varianMenuId);

        if (!$varian) {
            return;
        }

        // Jika item sudah ada di keranjang...
        if ($cart->has($varianMenuId)) {
            // === INI ADALAH PERBAIKANNYA ===
            // Ambil item yang ada, update quantity-nya, lalu masukkan kembali.
            $existingItem = $cart->get($varianMenuId);
            $existingItem['quantity'] += $quantity;
            $cart->put($varianMenuId, $existingItem);
        } else {
            // Jika item baru, tambahkan ke keranjang
            $cart->put($varianMenuId, [
                'id'           => $varianMenuId,
                'name'         => $varian->daftarMenu->nama_menu,
                'variant_name' => $varian->nama_varian,
                'price'        => $varian->harga,
                'quantity'     => $quantity,
                'image'        => $varian->daftarMenu->url_gambar,
            ]);
        }

        session(['cart' => $cart]);
    }

    /**
     * Mengupdate jumlah item di keranjang.
     */
    public static function update(int $varianMenuId, int $quantity): void
    {
        $cart = self::getContents();

        if ($cart->has($varianMenuId)) {
            if ($quantity <= 0) {
                self::remove($varianMenuId);
            } else {
                // Terapkan perbaikan yang sama di sini
                $existingItem = $cart->get($varianMenuId);
                $existingItem['quantity'] = $quantity;
                $cart->put($varianMenuId, $existingItem);

                session(['cart' => $cart]);
            }
        }
    }

    /**
     * Menghapus item dari keranjang berdasarkan ID-nya.
     */
    public static function remove(int $varianMenuId): void
    {
        $cart = self::getContents();
        $cart->forget($varianMenuId);
        session(['cart' => $cart]);
    }

    /**
     * Mengambil seluruh isi keranjang dari session.
     */
    public static function getContents(): Collection
    {
        return collect(session('cart', []));
    }

    /**
     * Menghitung total harga dari seluruh item di keranjang.
     */
    public static function getTotal(): float
    {
        return self::getContents()->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    /**
     * Menghitung jumlah total item (bukan jenis item) di keranjang.
     */
    public static function getCount(): int
    {
        return self::getContents()->sum('quantity');
    }

    /**
     * Mengosongkan seluruh keranjang belanja.
     */
    public static function clear(): void
    {
        session()->forget('cart');
    }

    /**
     * Memproses checkout: menyimpan data dari keranjang ke database.
     */
    public static function checkout(string $paymentMethod, string $customerName = null): ?Pesanan
    {
        $cartItems = self::getContents();
        $mejaId = session('meja_id');
        $total = self::getTotal();

        if ($cartItems->isEmpty() || !$mejaId) {
            return null;
        }

        $paymentStatus = ($paymentMethod === 'kasir') ? 'menunggu' : 'menunggu';

        $pesanan = Pesanan::create([
            'daftar_meja_id'    => $mejaId,
            'user_id'           => Auth::id(),
            'nama_pelanggan'    => !Auth::check() ? $customerName : null,
            'total_bayar'       => $total,
            'metode_pembayaran' => $paymentMethod,
            'status_pesanan'    => 'baru',
            'status_bayar'      => $paymentStatus,
        ]);

        $detailPesananData = $cartItems->map(function ($item) use ($pesanan) {
            return [
                'pesanan_id'       => $pesanan->id,
                'varian_menu_id'   => $item['id'],
                'jumlah'           => $item['quantity'],
                'harga_saat_pesan' => $item['price'],
                'created_at'       => now(),
                'updated_at'       => now(),
            ];
        })->toArray();

        DB::table('detail_pesanans')->insert($detailPesananData);
        self::clear();
        return $pesanan;
    }
}
