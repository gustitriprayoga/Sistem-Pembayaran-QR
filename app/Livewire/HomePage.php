<?php

namespace App\Livewire;

use App\Models\DaftarMenu;
use App\Models\KategoriMenu;
use App\Models\VarianMenu;
use App\Services\CartService; // Asumsi Anda punya service untuk cart, jika tidak bisa diganti dengan session
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class HomePage extends Component
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     * Menyimpan semua kategori untuk filter.
     */
    public $categories = [];

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     * Menyimpan 3 produk terlaris.
     */
    public $bestSellers = [];

    /**
     * @var int|null
     * Menyimpan ID kategori yang sedang aktif dipilih.
     */
    public ?int $selectedCategoryId = null;

    /**
     * @var \App\Models\DaftarMenu|null
     * Menyimpan data menu yang dipilih untuk ditampilkan di modal.
     */
    public ?DaftarMenu $selectedMenu = null;

    /**
     * Method ini dijalankan saat komponen pertama kali dimuat.
     * Mengambil data awal yang dibutuhkan halaman.
     */
    public function mount()
    {
        // 1. Ambil semua kategori untuk ditampilkan sebagai tombol filter.
        $this->categories = KategoriMenu::all();

        // 2. Logika untuk mengambil produk paling laris (best sellers).
        $bestSellingVariantIds = DB::table('detail_pesanans')
            ->select('varian_menu_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->groupBy('varian_menu_id')
            ->orderBy('total_terjual', 'desc')
            ->limit(3) // Ambil 3 varian teratas
            ->get();

        // 3. Ambil model VarianMenu berdasarkan ID terlaris dan gabungkan dengan jumlah terjual.
        $idsToFetch = $bestSellingVariantIds->pluck('varian_menu_id');

        $this->bestSellers = VarianMenu::whereIn('id', $idsToFetch)
            // ======================================================================
            //      INI DIA PERBAIKANNYA: Filter data yang tidak punya menu induk
            // ======================================================================
            ->whereHas('daftarMenu')
            ->with('daftarMenu.kategori') // Eager load untuk performa
            ->get()
            ->map(function ($variant) use ($bestSellingVariantIds) {
                // Tambahkan properti 'total_terjual' ke setiap model varian
                $variant->total_terjual = $bestSellingVariantIds->firstWhere('varian_menu_id', $variant->id)->total_terjual;
                return $variant;
            })
            ->sortByDesc('total_terjual'); // Urutkan kembali karena whereIn tidak menjamin urutan
    }

    /**
     * Properti ini akan menghitung ulang daftar menu setiap kali filter kategori berubah.
     * Menggunakan #[Computed] untuk caching hasil query agar lebih efisien.
     */
    #[Computed]
    public function menus()
    {
        return DaftarMenu::query()
            ->where('tersedia', true)
            // Terapkan filter hanya jika $selectedCategoryId memiliki nilai
            ->when($this->selectedCategoryId, function ($query) {
                $query->where('kategori_id', $this->selectedCategoryId);
            })
            ->with(['varian', 'kategori']) // Eager load varian dan kategori
            ->get();
    }

    /**
     * Aksi untuk memfilter produk berdasarkan kategori yang diklik.
     */
    public function filterByCategory(?int $categoryId)
    {
        $this->selectedCategoryId = $categoryId;
    }

    /**
     * Aksi untuk menyiapkan data saat produk dipilih untuk dilihat detailnya.
     */
    public function selectProduct($menuId)
    {
        $this->selectedMenu = DaftarMenu::with('varian')->find($menuId);

        // Kirim event ke browser untuk memberitahu JavaScript agar membuka modal Bootstrap
        $this->dispatch('open-product-modal');
    }

    /**
     * Aksi saat tombol '+' atau 'Add to Cart' diklik.
     */
    public function addToCart($varianMenuId)
    {
        // Di sini Anda bisa memanggil Service atau handle logika session secara langsung.
        // Contoh menggunakan Service:
        CartService::add($varianMenuId);

        // Kirim event untuk didengarkan oleh komponen lain (misal: ikon keranjang di navbar)
        $this->dispatch('cart-updated');

        // Tampilkan notifikasi sukses menggunakan sistem notifikasi Filament
        \Filament\Notifications\Notification::make()
            ->title('Berhasil ditambahkan ke keranjang!')
            ->success()
            ->send();
    }

    /**
     * Method untuk me-render view dan layout.
     */
    public function render()
    {
        // Pastikan memanggil layout yang benar
        return view('livewire.home-page')->layout('layouts.customer-app');
    }
}
