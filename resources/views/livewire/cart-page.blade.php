<div class="container my-5">
    <h1 class="display-5 fw-bold mb-4">Keranjang Belanja Anda 🛒</h1>

    @forelse($cartItems as $item)
        {{-- Kartu untuk setiap item di keranjang --}}
        <div class="card mb-3 shadow-sm">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    {{-- Gambar dan Nama Produk --}}
                    <div class="col-md-5 d-flex align-items-center mb-3 mb-md-0">
                        <img src="{{ !empty($item['image']) && Storage::disk('public')->exists($item['image']) ? Storage::url($item['image']) : asset('frontend/produk/default-produk.png') }}"
                            alt="{{ $item['name'] }}" style="width: 80px; height: 80px; object-fit: cover;"
                            class="rounded me-4">
                        <div>
                            <h5 class="fw-bold mb-0">{{ $item['name'] }}</h5>
                            <p class="text-muted mb-1">{{ $item['variant_name'] }}</p>
                            <p class="fw-bold text-primary mb-0">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Kontrol Kuantitas --}}
                    <div class="col-md-3 d-flex justify-content-center mb-3 mb-md-0">
                        <div class="input-group" style="max-width: 140px;">
                            <button class="btn btn-outline-secondary" type="button" wire:loading.attr="disabled"
                                wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})">-</button>
                            <input type="text" class="form-control text-center fw-bold"
                                value="{{ $item['quantity'] }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" wire:loading.attr="disabled"
                                wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})">+</button>
                        </div>
                    </div>

                    {{-- Subtotal dan Tombol Hapus --}}
                    <div class="col-md-4 d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted d-block d-md-none">Subtotal:</span>
                            <p class="fw-bolder fs-5 mb-0">Rp
                                {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                        </div>
                        <button class="btn btn-link text-danger" wire:loading.attr="disabled"
                            wire:click="removeItem({{ $item['id'] }})">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        {{-- Tampilan jika keranjang kosong --}}
        <div class="text-center py-5 my-5">
            <p class="fs-4 text-muted">Keranjang Anda masih kosong.</p>
            <p class="text-muted">Mari kita isi dengan beberapa kopi nikmat!</p>
            <a href="/" class="btn btn-primary btn-lg mt-3">Mulai Belanja</a>
        </div>
    @endforelse

    {{-- Ringkasan dan Tombol Checkout --}}
    @if (count($cartItems) > 0)
        <div class="card mt-4 shadow-lg">
            <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h5 class="fw-bold mb-0">Total Belanja:</h5>
                    <p class="display-6 fw-bolder text-primary mb-0">Rp {{ number_format($total, 0, ',', '.') }}</p>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg px-5" wire:navigate>Lanjutkan ke Checkout</a>
            </div>
        </div>
    @endif
</div>
