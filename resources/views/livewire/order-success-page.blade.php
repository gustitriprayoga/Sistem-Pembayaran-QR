<div class="container text-center my-5 py-5">
    <div class="py-5">
        <h1 class="display-4 fw-bold text-success">Pesanan Diterima!</h1>
        <p class="fs-4 text-muted">Nomor Pesanan Anda: <strong class="text-dark">#{{ $pesanan->id }}</strong></p>
        <hr class="w-50 mx-auto my-4">

        {{-- Logika untuk menampilkan instruksi berbeda --}}
        @if ($pesanan->metode_pembayaran === 'kasir')
            <div class="alert alert-info w-75 mx-auto">
                <h4 class="alert-heading">Langkah Selanjutnya</h4>
                <p>Silakan tunjukkan Nomor Pesanan Anda dan lakukan pembayaran langsung di kasir. Pesanan Anda akan
                    segera kami siapkan.</p>
            </div>
        @elseif($pesanan->metode_pembayaran === 'transfer')
            <div class="alert alert-light border w-75 mx-auto">
                <h4 class="alert-heading">Instruksi Transfer Bank</h4>
                <p>Silakan transfer sejumlah <strong>Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</strong>
                    ke rekening berikut:</p>
                <ul class="list-unstyled">
                    <li><strong>Bank:</strong> BCA</li>
                    <li><strong>No. Rekening:</strong> 1234567890</li>
                    <li><strong>Atas Nama:</strong> Tuan Coffee</li>
                </ul>
                <p class="mt-3">Mohon konfirmasi ke kasir setelah melakukan transfer.</p>
            </div>
        @elseif($pesanan->metode_pembayaran === 'ewallet')
            <div class="alert alert-light border w-75 mx-auto">
                <h4 class="alert-heading">Pembayaran via E-Wallet (QRIS)</h4>
                <p>Silakan scan QR Code di bawah ini menggunakan aplikasi E-Wallet Anda (GoPay, OVO, DANA, dll) untuk
                    membayar sejumlah <strong>Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</strong></p>
                <div class="my-3">
                    {{-- Menampilkan QR Code --}}
                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate(
                        'Contoh data QRIS untuk pesanan #' . $pesanan->id,
                    ) !!}
                </div>
                <p class="mt-3">Mohon konfirmasi ke kasir setelah berhasil membayar.</p>
            </div>
        @endif

        <a href="/" class="btn btn-outline-primary mt-5" wire:navigate>Kembali ke Halaman Utama</a>
    </div>
</div>
