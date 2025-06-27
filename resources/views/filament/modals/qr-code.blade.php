{{--
  File ini akan menjadi template untuk konten modal QR Code.
  Kita akan menggunakan class-class dari Tailwind CSS yang sudah tersedia di Filament.
--}}
<div class="flex flex-col items-center justify-center gap-4 text-center">
    <h2>TUAN COFFEE</h2>
    {{-- Tampilkan Nama Meja jika ada --}}
    @if ($namaMeja)
        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $namaMeja }}</p>
    @endif

    {{-- Tampilkan gambar QR Code jika URL-nya ada --}}
    @if ($qrCodeUrl)
        <img src="{{ $qrCodeUrl }}" alt="QR Code untuk {{ $namaMeja }}"
            style="max-width: 250px; border-radius: 0.5rem;">
    @else
        {{-- Tampilkan pesan error jika gambar tidak ditemukan --}}
        <p class="text-center text-red-500">QR Code tidak ditemukan atau belum dibuat.</p>
    @endif

    {{-- Tampilkan URL lengkap di bawah gambar jika ada --}}
    @if ($fullUrl)
        <div class="mt-2 w-full">
            <p class="text-sm text-gray-500 dark:text-gray-400">Atau kunjungi URL:</p>
            <code
                class="mt-1 inline-block bg-gray-100 dark:bg-gray-800 text-primary-600 dark:text-primary-500 p-2 rounded-lg text-sm break-all w-full">
                {{ $fullUrl }}
            </code>
        </div>
    @endif

</div>
