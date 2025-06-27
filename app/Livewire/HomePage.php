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
    // ... (properti lainnya tetap sama) ...
    public $categories = [];
    public $bestSellers = [];
    public ?int $selectedCategoryId = null;
    public ?DaftarMenu $selectedMenu = null;
    public ?int $nomorMeja = null;
    public ?int $selectedVarianIdInModal = null;


    /**
     * Method ini dijalankan saat komponen pertama kali dimuat.
     */
    public function mount()
    {
        // Logika untuk mendeteksi meja (tetap sama)
        if (request()->has('meja')) {
            $mejaId = request()->query('meja');
            $meja = DaftarMeja::find($mejaId);
            if ($meja) {
                session(['meja_id' => $meja->id]);
            } else {
                session()->forget('meja_id');
            }
        }
        if (session()->has('meja_id')) {
            $this->nomorMeja = session('meja_id');
        }

        // Ambil kategori (tetap sama)
        $this->categories = KategoriMenu::all();

        // ======================================================================
        //      PERBAIKAN FINAL: Menggunakan Subquery Join untuk Best Seller
        // ======================================================================
        // Langkah 1: Buat subquery untuk menghitung total penjualan per varian
        $bestSellingSubquery = DB::table('detail_pesanans')
            ->select('varian_menu_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->groupBy('varian_menu_id');

        // Langkah 2: Jalankan query utama dan gabungkan (join) dengan hasil subquery
        $this->bestSellers = VarianMenu::query()
            // Pilih semua kolom dari varian menu, dan kolom total_terjual dari subquery
            ->select('varian_menus.*', 'sales.total_terjual')
            // Gabungkan dengan subquery yang kita beri nama alias 'sales'
            ->joinSub($bestSellingSubquery, 'sales', function ($join) {
                $join->on('varian_menus.id', '=', 'sales.varian_menu_id');
            })
            // Pastikan hanya mengambil varian yang punya menu induk yang valid
            ->whereHas('daftarMenu')
            // Urutkan berdasarkan total penjualan yang paling banyak
            ->orderBy('sales.total_terjual', 'desc')
            // Eager load relasi untuk ditampilkan di view
            ->with('daftarMenu.kategori')
            // Ambil 3 teratas
            ->limit(3)
            ->get();
    }

    /**
     * Properti computed untuk daftar menu (tetap sama)
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
     * Aksi filter kategori (tetap sama)
     */
    public function filterByCategory(?int $categoryId)
    {
        $this->selectedCategoryId = $categoryId;
    }

    /**
     * Aksi untuk memilih produk dan membuka modal (diperbarui).
     */
    public function selectProduct($menuId)
    {
        $menu = DaftarMenu::with('varian')->find($menuId);
        $this->selectedMenu = $menu;

        // PERBARUAN: Secara otomatis pilih varian pertama sebagai default saat modal dibuka.
        if ($menu && $menu->varian->isNotEmpty()) {
            $this->selectedVarianIdInModal = $menu->varian->first()->id;
        }

        // Kirim event ke browser untuk membuka modal
        $this->dispatch('open-product-modal');
    }

    /**
     * Aksi untuk menambah item dari luar modal (tetap sama)
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
     * Metode BARU untuk menambah item DARI DALAM MODAL.
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
     * Method render (tetap sama)
     */
    public function render()
    {
        return view('livewire.home-page')->layout('layouts.customer-app');
    }
}
