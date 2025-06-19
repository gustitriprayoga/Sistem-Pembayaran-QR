<div class="flex justify-center">
    @if ($qrCodeUrl)
        <img src="{{ $qrCodeUrl }}" alt="QR Code">
        <p class="mt-4 text-center text-sm">{{ $namaMeja }}</p>
    @else
        <p class="text-center">QR Code tidak ditemukan atau belum dibuat.</p>
    @endif
</div>
