<div>
    <div class="container my-5">
        {{-- Hero Section --}}
        <div
            class="row align-items-center justify-content-center text-center text-md-start hero-section p-4 p-md-5 mb-5">
            <div class="col-md-6">
                <h1 class="display-4 fw-bolder text-body-emphasis">The Happiest Hour<br>of The Year</h1>
                <p class="lead text-body-secondary">Dapatkan akses eksklusif untuk semua promo minuman spesial di musim
                    ini.</p>
                <button class="btn btn-lg btn-primary">Send Me Magic</button>
            </div>
            <div class="col-md-4 text-center d-none d-md-block">
                {{-- Anda bisa menaruh gambar besar di sini --}}
                <img src="/path/to/hero-image.png" class="img-fluid">
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

    {{-- Modal untuk Detail Produk --}}
    <div wire:ignore.self class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            @if ($selectedMenu)
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">{{ $selectedMenu->nama_menu }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ Storage::url($selectedMenu->url_gambar) }}" class="img-fluid rounded mb-3"
                            alt="{{ $selectedMenu->nama_menu }}">
                        <p>{{ $selectedMenu->deskripsi }}</p>
                        <hr>
                        <div class="mb-3">
                            <label for="varianSelect" class="form-label">Pilih Varian:</label>
                            <select class="form-select" id="varianSelect">
                                @foreach ($selectedMenu->varian as $varian)
                                    <option value="{{ $varian->id }}">
                                        {{ $varian->nama_varian }} - Rp
                                        {{ number_format($varian->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary">Tambah ke Keranjang</button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            const productModal = new bootstrap.Modal(document.getElementById('productModal'));

            // Dengar event dari Livewire untuk membuka modal
            Livewire.on('open-product-modal', () => {
                productModal.show();
            });
        });
    </script>
@endpush
