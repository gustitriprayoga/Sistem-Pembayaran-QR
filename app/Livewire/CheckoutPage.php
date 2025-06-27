<?php

namespace App\Livewire;

use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CheckoutPage extends Component
{
    // Properti untuk menyimpan data dari view
    public $cartItems = [];
    public $total = 0;
    public ?string $customerName = '';
    public ?int $tableNumber = null;
    public ?string $paymentMethod = 'kasir'; // <-- Properti baru, default ke 'kasir'

    /**
     * Aturan validasi untuk form.
     */
    protected function rules()
    {
        return [
            'customerName' => Auth::guest() ? 'required|string|min:3' : 'nullable',
            'paymentMethod' => 'required|in:kasir,transfer,ewallet', // <-- Validasi untuk metode pembayaran
        ];
    }

    protected $messages = [
        'customerName.required' => 'Silakan masukkan nama Anda.',
        'customerName.min' => 'Nama harus terdiri dari minimal 3 karakter.',
        'paymentMethod.required' => 'Silakan pilih metode pembayaran.',
    ];

    /**
     * Dijalankan saat komponen dimuat.
     */
    public function mount()
    {
        $this->cartItems = CartService::getContents();
        $this->total = CartService::getTotal();
        $this->tableNumber = session('meja_id');

        if ($this->cartItems->isEmpty() || !$this->tableNumber) {
            return $this->redirect('/', navigate: true);
        }

        if (Auth::check()) {
            $this->customerName = Auth::user()->name;
        }
    }

    /**
     * Aksi yang dijalankan saat tombol "Buat Pesanan" ditekan.
     */
    public function placeOrder()
    {
        $this->validate();

        // Panggil service checkout dengan metode pembayaran yang dipilih
        $pesanan = CartService::checkout(
            paymentMethod: $this->paymentMethod,
            customerName: Auth::guest() ? $this->customerName : null
        );

        if ($pesanan) {
            return $this->redirect(route('order.success', ['pesanan' => $pesanan->id]), navigate: true);
        } else {
            // Handle kegagalan
        }
    }

    public function render()
    {
        return view('livewire.checkout-page')->layout('layouts.customer-app');
    }
}
