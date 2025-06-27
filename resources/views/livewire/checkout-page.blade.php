<div class="container my-5">
    <div class="row g-5">
        {{-- Kolom Kiri: Detail Pesanan --}}
        <div class="col-md-5 col-lg-4 order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Ringkasan Pesanan</span>
                <span class="badge bg-primary rounded-pill">{{ count($cartItems) }}</span>
            </h4>
            <ul class="list-group mb-3">
                @foreach($cartItems as $item)
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">{{ $item['name'] }} <small> ({{ $item['quantity'] }}x)</small></h6>
                        <small class="text-body-secondary">{{ $item['variant_name'] }}</small>
                    </div>
                    <span class="text-body-secondary">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                </li>
                @endforeach
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Total (IDR)</span>
                    <strong class="fw-bolder">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                </li>
            </ul>
        </div>

        {{-- Kolom Kanan: Informasi Pelanggan & Tombol Aksi --}}
        <div class="col-md-7 col-lg-8">
            <h4 class="mb-3 fw-bold">Detail Pengiriman & Pembayaran</h4>

            <div class="alert alert-info" role="alert">
                Pesanan Anda akan diantar ke <strong>Meja {{ $tableNumber ?? '...' }}</strong>.
            </div>

            <form wire:submit.prevent="placeOrder">
                <div class="row g-3">
                    @guest
                    <div class="col-12">
                        <label for="customerName" class="form-label">Nama Anda</label>
                        <input type="text" class="form-control @error('customerName') is-invalid @enderror" id="customerName" placeholder="Masukkan nama Anda" wire:model.lazy="customerName">
                        @error('customerName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    @endguest

                    {{-- === BAGIAN METODE PEMBAYARAN BARU === --}}
                    <div class="col-12">
                        <p class="mb-2 fw-bold">Metode Pembayaran</p>
                        <div class="form-check border rounded-2 p-3 mb-2">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="payKasir" value="kasir" wire:model="paymentMethod">
                            <label class="form-check-label fw-semibold" for="payKasir">
                                Bayar Langsung ke Kasir
                            </label>
                        </div>
                        <div class="form-check border rounded-2 p-3 mb-2">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="payTransfer" value="transfer" wire:model="paymentMethod">
                            <label class="form-check-label fw-semibold" for="payTransfer">
                                Transfer Bank (BCA)
                            </label>
                        </div>
                        <div class="form-check border rounded-2 p-3 mb-2">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="payEwallet" value="ewallet" wire:model="paymentMethod">
                            <label class="form-check-label fw-semibold" for="payEwallet">
                                E-Wallet (QRIS)
                            </label>
                        </div>
                        @error('paymentMethod') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    {{-- === AKHIR BAGIAN BARU === --}}
                </div>

                <hr class="my-4">

                <button class="w-100 btn btn-primary btn-lg" type="submit">
                    <span wire:loading.remove wire:target="placeOrder">
                        Buat Pesanan & Dapatkan Kode Pembayaran
                    </span>
                    <span wire:loading wire:target="placeOrder">
                        Memproses...
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>
