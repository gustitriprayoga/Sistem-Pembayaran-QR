<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Attributes\On;
use Livewire\Component;

class CartPage extends Component
{
    // Properti untuk menyimpan data yang akan ditampilkan di view
    public $cartItems = [];
    public $total = 0;

    /**
     * Method mount dijalankan saat komponen pertama kali dimuat.
     * Langsung mengisi data keranjang.
     */
    public function mount()
    {
        $this->updateCartView();
    }

    /**
     * Method ini akan "mendengarkan" event 'cart-updated' yang dikirim
     * dari komponen lain (misalnya saat item baru ditambahkan).
     * Ini membuat data di halaman ini selalu sinkron.
     */
    #[On('cart-updated')]
    public function updateCartView()
    {
        $this->cartItems = CartService::getContents();
        $this->total = CartService::getTotal();
    }

    /**
     * Aksi untuk mengupdate jumlah item.
     * Terhubung dengan tombol +/- di view.
     */
    public function updateQuantity($varianMenuId, $quantity)
    {
        CartService::update($varianMenuId, $quantity);
        $this->updateCartView(); // Perbarui tampilan setelah update
        $this->dispatch('cart-updated'); // Kirim event agar counter di navbar juga update
    }

    /**
     * Aksi untuk menghapus item dari keranjang.
     * Terhubung dengan tombol "Hapus" di view.
     */
    public function removeItem($varianMenuId)
    {
        CartService::remove($varianMenuId);
        $this->updateCartView(); // Perbarui tampilan setelah item dihapus
        $this->dispatch('cart-updated'); // Kirim event agar counter di navbar juga update
    }

    /**
     * Render view dan layout.
     */
    public function render()
    {
        return view('livewire.cart-page')->layout('layouts.customer-app');
    }
}
