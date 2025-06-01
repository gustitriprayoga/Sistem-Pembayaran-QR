<x-filament-panels::page>
    <form wire:submit.prevent="generateLaporan" class="space-y-4">
        {{ $this->form }}
    </form>

    <div class="mt-6 space-y-2">
        <h2 class="text-lg font-semibold">Ringkasan Laporan ({{ ucfirst($tipe) }})</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>Total Pendapatan: <strong>Rp {{ number_format($laporan['total']) }}</strong></div>
            <div>Jumlah Pesanan: <strong>{{ $laporan['jumlah'] }}</strong></div>
        </div>

        <div class="mt-4">
            <table class="table-auto w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-1">Tanggal</th>
                        <th class="border px-2 py-1">Kode Pesanan</th>
                        <th class="border px-2 py-1">Metode</th>
                        <th class="border px-2 py-1 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporan['data'] as $item)
                        <tr>
                            <td class="border px-2 py-1">{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}
                            </td>
                            <td class="border px-2 py-1">{{ $item->kode_pesanan }}</td>
                            <td class="border px-2 py-1">{{ $item->metode_pembayaran }}</td>
                            <td class="border px-2 py-1 text-right">Rp {{ number_format($item->total_harga) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border px-2 py-2 text-center text-gray-500">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
