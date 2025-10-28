<?php

namespace App\Livewire;

use App\Models\DaftarMeja;
use App\Models\DaftarMenu;
use App\Models\KategoriMenu;
use App\Models\VarianMenu;
use App\Services\CartService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class HomePage extends Component
{
    public $categories = [];
    public $bestSellers = [];
    public ?int $selectedCategoryId = null;
    public ?DaftarMenu $selectedMenu = null;
    // Properti yang menyimpan ID meja yang terdeteksi dari sesi/URL
    public ?int $nomorMeja = null;
    public ?int $selectedVarianIdInModal = null;


    /**
     * Method ini dijalankan saat komponen pertama kali dimuat.
     */
    public function mount()
    {
        // Logika untuk mendeteksi meja dari URL (?meja=...)
        if (request()->has('meja')) {
            $mejaId = request()->query('meja');
            $meja = DaftarMeja::find($mejaId);
            if ($meja) {
                // Simpan ID meja ke dalam sesi jika valid
                session(['meja_id' => $meja->id]);
            } else {
                session()->forget('meja_id');
            }
        }
        // Ambil ID meja dari sesi
        if (session()->has('meja_id')) {
            $this->nomorMeja = session('meja_id');
        }

        // Ambil kategori
        $this->categories = KategoriMenu::all();

        // Mengambil Best Seller
        $bestSellingSubquery = DB::table('detail_pesanans')
            ->select('varian_menu_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->groupBy('varian_menu_id');

        $this->bestSellers = VarianMenu::query()
            ->select('varian_menus.*', 'sales.total_terjual')
            ->joinSub($bestSellingSubquery, 'sales', function ($join) {
                $join->on('varian_menus.id', '=', 'sales.varian_menu_id');
            })
            ->whereHas('daftarMenu')
            ->orderBy('sales.total_terjual', 'desc')
            ->with('daftarMenu.kategori')
            ->limit(3)
            ->get();
    }

    /**
     * Properti computed untuk daftar menu.
     */
    #[Computed]
    public function menus()
    {
        return DaftarMenu::query()
            ->where('tersedia', true)
            ->when($this->selectedCategoryId, function ($query) {
                $query->where('kategori_id', $this->selectedCategoryId);
            })
            ->with(['varian', 'kategori'])
            ->get();
    }

    /**
     * Aksi filter kategori.
     */
    public function filterByCategory(?int $categoryId)
    {
        $this->selectedCategoryId = $categoryId;
    }

    /**
     * Aksi untuk memilih produk dan membuka modal.
     */
    public function selectProduct($menuId)
    {
        $menu = DaftarMenu::with('varian')->find($menuId);
        $this->selectedMenu = $menu;

        // Secara otomatis pilih varian pertama sebagai default saat modal dibuka.
        if ($menu && $menu->varian->isNotEmpty()) {
            $this->selectedVarianIdInModal = $menu->varian->first()->id;
        }

        // Kirim event ke browser untuk membuka modal
        $this->dispatch('open-product-modal');
    }

    /**
     * Metode BARU: Mengirim event untuk membuka fungsionalitas QR Scanner.
     * Metode ini dipanggil saat tombol "OPEN CAMERA TO SCAN QR" ditekan.
     */
    public function openQrScanner()
    {
        // Kirim event untuk memberitahu JavaScript agar mengarahkan ke halaman/modal QR Scanner.
        // Asumsi rute pemindaian QR adalah '/scan-qr'. Jika berbeda, sesuaikan di JavaScript.
        $this->dispatch('open-qr-scanner-modal');
    }

    /**
     * Aksi untuk menambah item dari luar modal (tanpa opsi varian).
     */
    public function addToCart($varianMenuId)
    {
        CartService::add($varianMenuId);
        $this->dispatch('cart-updated');
        \Filament\Notifications\Notification::make()
            ->title('Berhasil ditambahkan ke keranjang!')
            ->success()
            ->send();
    }

    /**
     * Metode untuk menambah item DARI DALAM MODAL.
     */
    public function addSelectedVarianToCart()
    {
        // Cek apakah ada varian yang dipilih
        if ($this->selectedVarianIdInModal) {
            $this->addToCart($this->selectedVarianIdInModal);

            // Kirim event untuk menutup modal setelah berhasil ditambahkan
            $this->dispatch('close-product-modal');
        }
    }

    /**
     * Method render.
     */
    public function render()
    {
        return view('livewire.home-page')->layout('layouts.customer-app');
    }
}
