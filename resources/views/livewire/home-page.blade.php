<div>
    <div class="container my-5">
        {{-- Hero Section --}}
        <div
            class="row align-items-center justify-content-center text-center text-md-start hero-section p-4 p-md-5 mb-5">
            <div class="col-md-6">
                <h1 class="display-4 fw-bolder text-body-emphasis">TUAN COFFEE<br>PESEN KOPI MUDAH HANYA DISINI</h1>
                <p class="lead text-body-secondary">Dapatkan askses cepat memesan menu dengan cara Scan QR yang ada
                    dimeja kamu!.</p>

                {{-- Cek apakah meja sudah terdeteksi menggunakan $nomorMeja --}}
                @if (empty($nomorMeja))
                    {{-- Tombol dengan teks baru yang memicu Livewire event --}}
                    <button class="btn btn-lg btn-primary" wire:click="openQrScanner">
                        SCAN DISINI
                    </button>
                    <p class="text-muted mt-2">Tekan tombol di atas untuk memulai pemindaian QR.</p>
                @else
                    {{-- Jika meja sudah terdeteksi, tampilkan pesan selamat datang --}}
                    <p class="lead fw-bold text-success">
                        ✅ Meja Terpilih: Meja #{{ $nomorMeja }}
                    </p>
                    <p class="text-body-secondary">Anda siap memesan! Gulir ke bawah untuk melihat menu.</p>
                @endif

            </div>
            <div class="col-md-4 text-center d-none d-md-block">
                {{-- Anda bisa menaruh gambar besar di sini --}}
                <img src="{{ asset('frontend/banner/banner.jpg') }}" class="img-fluid">
            </div>
        </div>

        {{-- Section Produk Paling Laris --}}
        <section class="mb-5">
            <h2 class="display-6 fw-bold mb-4">Paling Laris 🔥</h2>
            <div class="row">
                @foreach ($bestSellers as $varian)
                    {{-- Ganti pemanggilan menjadi 'daftarMenu' sesuai dengan nama relasi baru Anda --}}
                    @if ($varian->daftarMenu)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 text-center pt-5 pb-4">
                                <span class="badge bg-danger best-seller-badge">{{ $varian->total_terjual }}
                                    Terjual</span>
                                {{-- Ganti di sini --}}
                                <img src="{{ !empty($varian->daftarMenu->url_gambar) && Storage::disk('public')->exists($varian->daftarMenu->url_gambar)
                                    ? Storage::url($varian->daftarMenu->url_gambar)
                                    : asset('frontend/produk/default-produk.png') }}"
                                    class="card-img-top" alt="{{ $varian->daftarMenu->nama_menu }}">
                                <div class="card-body d-flex flex-column">
                                    {{-- Dan ganti di sini --}}
                                    <h5 class="card-title fw-bold fs-4">{{ $varian->daftarMenu->nama_menu }}</h5>
                                    <p class="card-text text-muted">{{ $varian->nama_varian }}</p>
                                    <p class="card-text fs-3 fw-bolder mt-auto">Rp
                                        {{ number_format($varian->harga, 0, ',', '.') }}</p>
                                    <button class="btn btn-primary mt-3" wire:click="addToCart({{ $varian->id }})">Add
                                        to Basket</button>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>

        {{-- Section Menu Kami dengan Filter Kategori --}}
        <section>
            <h2 class="display-6 fw-bold mb-4">Menu Kami</h2>
            <ul class="nav nav-pills justify-content-center mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ is_null($selectedCategoryId) ? 'active' : '' }}" href="#"
                        wire:click.prevent="filterByCategory(null)">Semua</a>
                </li>
                @foreach ($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link {{ $selectedCategoryId == $category->id ? 'active' : '' }}" href="#"
                            wire:click.prevent="filterByCategory({{ $category->id }})">{{ $category->nama_kategori }}</a>
                    </li>
                @endforeach
            </ul>

            <div class="row" wire:loading.class.delay="opacity-50" wire:target="filterByCategory">
                @foreach ($this->menus as $menu)
                    @php $defaultVarian = $menu->varian->first(); @endphp
                    @if ($defaultVarian)
                        <div class="col-lg-3 col-md-4 col-6 mb-4">
                            <div class="card h-100 text-center pt-5 pb-4">
                                <img src="{{ !empty($menu->url_gambar) && Storage::disk('public')->exists($menu->url_gambar)
                                    ? Storage::url($menu->url_gambar)
                                    : asset('frontend/produk/default-produk.png') }}"
                                    alt="{{ $menu->nama_menu }}"
                                    class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold fs-5">{{ $menu->nama_menu }}</h5>
                                    <p class="card-text fs-4 fw-bolder mt-auto">Rp
                                        {{ number_format($defaultVarian->harga, 0, ',', '.') }}</p>
                                    <button class="btn btn-outline-primary mt-3"
                                        wire:click="selectProduct({{ $menu->id }})">Pilih Opsi</button>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
    </div>

    {{-- Input file tersembunyi untuk memicu kamera/scan QR --}}
    {{-- CATATAN PENTING: Pemicuan kamera pada mobile browser SANGAT sensitif terhadap event dan harus dilakukan sesegera mungkin --}}
    <input type="file" id="qrScannerInput" accept="image/*" capture="environment" style="display:none;">

    {{-- Modal untuk Detail Produk --}}
    <div wire:ignore.self class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            @if ($selectedMenu)
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold" id="productModalLabel">{{ $selectedMenu->nama_menu }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ !empty($selectedMenu->url_gambar) && Storage::disk('public')->exists($selectedMenu->url_gambar) ? Storage::url($selectedMenu->url_gambar) : asset('frontend/produk/default-produk.png') }}"
                            class="img-fluid rounded mb-3" alt="{{ $selectedMenu->nama_menu }}">
                        <p>{{ $selectedMenu->deskripsi }}</p>
                        <hr>
                        <div class="mb-3">
                            <label for="varianSelect" class="form-label fw-semibold">Pilih Varian:</label>

                            {{-- PERBAIKAN: Tambahkan wire:model.live ke <select> --}}
                            <select class="form-select" id="varianSelect" wire:model.live="selectedVarianIdInModal">
                                @foreach ($selectedMenu->varian as $varian)
                                    <option value="{{ $varian->id }}">
                                        {{ $varian->nama_varian }} - Rp
                                        {{ number_format($varian->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>

                        {{-- PERBAIKAN: Tambahkan wire:click ke tombol utama --}}
                        <button type="button" class="btn btn-primary px-4" wire:click="addSelectedVarianToCart"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="addSelectedVarianToCart">
                                Tambah ke Keranjang
                            </span>
                            <span wire:loading wire:target="addSelectedVarianToCart">
                                Menambahkan...
                            </span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            const productModalElement = document.getElementById('productModal');
            const productModal = new bootstrap.Modal(productModalElement);
            const qrScannerInput = document.getElementById('qrScannerInput');

            // Dengar event dari Livewire untuk MEMBUKA modal produk
            Livewire.on('open-product-modal', () => {
                productModal.show();
            });

            // Dengar event dari Livewire untuk MENUTUP modal produk
            Livewire.on('close-product-modal', () => {
                productModal.hide();
            });

            // Perbaikan: Dengar event dari Livewire untuk memicu kamera/scan QR
            Livewire.on('open-qr-scanner-modal', () => {
                // Memicu klik pada input file tersembunyi
                // Ini adalah cara standar (meski tidak selalu sempurna) untuk memicu kamera di mobile browser.
                qrScannerInput.click();
            });

            // Opsional: Listener untuk memproses hasil scan dari file yang dipilih
            qrScannerInput.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    const file = e.target.files[0];
                    // TODO: Di sini, tambahkan integrasi dengan library QR scanner JavaScript (misalnya, jsQR)
                    // untuk memproses file (gambar) yang diambil dari kamera.

                    console.log('Gambar/QR Code diterima. Perlu logika untuk membaca QR dari file.');
                    alert(
                        "QR Code diterima. Silakan lanjutkan implementasi logika pemindaian QR di sisi klien.");

                    // Setelah ID meja berhasil dipindai dan diverifikasi, Anda akan me-redirect pengguna
                    // ke URL beranda dengan query parameter 'meja':
                    // window.location.href = `/?meja=HASIL_SCAN_ID_MEJA`;
                }
            });
        });
    </script>
@endpush
