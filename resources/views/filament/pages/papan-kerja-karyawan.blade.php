<x-filament-panels::page>

    {{--
      Gunakan Grid Layout untuk menata dua komponen berdampingan di layar besar.
      Di layar kecil (mobile), komponen akan tersusun secara vertikal.
    --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Kolom untuk Tabel Konfirmasi Pembayaran --}}
        <div>
            {{-- Panggil komponen Livewire untuk tabel konfirmasi pembayaran --}}
            @livewire('konfirmasi-pembayaran-table')
        </div>

        {{-- Kolom untuk Tabel Pesanan Masuk --}}
        <div>
            {{-- Panggil komponen Livewire untuk tabel pesanan masuk --}}
            @livewire('pesanan-masuk-table')
        </div>

    </div>

</x-filament-panels::page>
