<x-filament-panels::page>
    {{-- Bagian Filter Tanggal --}}
    <div class="mb-6">
        <form wire:submit="updateReport"
            class="p-4 border rounded-lg bg-white shadow-sm dark:bg-gray-800 dark:border-gray-700">
            {{ $this->form }}
        </form>
    </div>

    {{-- Bagian Tombol Filter Cepat (Harian, Mingguan, dll) --}}
    <div class="mb-6 flex flex-wrap gap-2">
        <x-filament::button wire:click="filterHariIni" color="gray">Hari Ini</x-filament::button>
        <x-filament::button wire:click="filterMingguIni" color="gray">Minggu Ini</x-filament::button>
        <x-filament::button wire:click="filterBulanIni" color="gray">Bulan Ini</x-filament::button>
        <x-filament::button wire:click="filterTahunIni" color="gray">Tahun Ini</x-filament::button>
    </div>

    {{-- Bagian Laporan Ringkas (Statistik) - INI KODE YANG BENAR --}}
    <div class="mb-6">
        @php
            $stats = $this->getStats();
        @endphp
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8">
            @if (!empty($stats))
                @foreach ($stats as $stat)
                    <div
                        class="relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-white/10">
                        <div class="flex items-center gap-x-4">
                            <div @class([
                                'flex items-center justify-center rounded-lg bg-gray-100 ring-1 ring-gray-950/10 dark:bg-gray-700 dark:ring-white/20',
                                match ($stat->getColor()) {
                                    'success' => 'text-success-500',
                                    'warning' => 'text-warning-500',
                                    'danger' => 'text-danger-500',
                                    'primary' => 'text-primary-500',
                                    default => 'text-gray-500',
                                },
                            ]) style="height: 40px; width: 40px;">
                                @if ($icon = $stat->getIcon())
                                    @svg($icon, 'h-6 w-6')
                                @endif
                            </div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ $stat->getLabel() }}
                            </div>
                        </div>
                        <div class="mt-4 flex items-end gap-x-2">
                            <p class="text-3xl font-semibold tracking-tight text-gray-950 dark:text-white">
                                {{ $stat->getValue() }}
                            </p>
                        </div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $stat->getDescription() }}
                        </p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- Bagian Riwayat Transaksi (Tabel) --}}
    <div>
        <h2 class="text-xl font-bold tracking-tight mb-4 dark:text-white">
            Riwayat Transaksi
        </h2>
        {{ $this->table }}
    </div>

</x-filament-panels::page>
