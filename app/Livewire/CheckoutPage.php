<?php

namespace App\Livewire;

use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert; // Import Facade SweetAlert

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

        // Modifikasi Logika Pengecekan Keranjang
        if ($this->cartItems->isEmpty()) {
            // Jika keranjang kosong, kirim SweetAlert Error dan redirect
            Alert::error('Keranjang Kosong', 'Keranjang belanja Anda kosong.')->persistent(true);
            return $this->redirect('/', navigate: true);
        }

        // Modifikasi Logika Pengecekan Meja (Menggunakan SweetAlert Error)
        if (!$this->tableNumber) {
            // Jika meja belum terdeteksi, kirim SweetAlert Error
            Alert::error('Meja Belum Dipilih', 'Anda harus memindai QR code meja terlebih dahulu sebelum melanjutkan ke pembayaran.')
                ->persistent(true); // Opsi: buat notif tetap ada sampai ditutup manual

            // Redirect ke halaman utama
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

        // Cek lagi untuk memastikan meja tidak hilang di tengah proses
        if (!$this->tableNumber) {
            // Kirim notifikasi error SweetAlert dan hentikan proses
            Alert::error('Kesalahan Sesi', 'Terjadi kesalahan. Mohon pindai QR code meja Anda kembali.')->persistent(true);
            return;
        }

        // Panggil service checkout dengan metode pembayaran yang dipilih
        $pesanan = CartService::checkout(
            paymentMethod: $this->paymentMethod,
            customerName: Auth::guest() ? $this->customerName : null
        );

        if ($pesanan) {
            // Kirim notifikasi sukses SweetAlert dan redirect
            Alert::success('Pesanan Berhasil Dibuat!', 'Terima kasih. Pesanan Anda sedang diproses.')
                ->persistent(true);

            return $this->redirect(route('order.success', ['pesanan' => $pesanan->id]), navigate: true);
        } else {
            // Handle kegagalan checkout
            Alert::error('Gagal Membuat Pesanan', 'Terjadi kesalahan saat memproses pesanan Anda. Silakan coba lagi.')->persistent(true);
            return;
        }
    }

    public function render()
    {
        return view('livewire.checkout-page')->layout('layouts.customer-app');
    }
}
