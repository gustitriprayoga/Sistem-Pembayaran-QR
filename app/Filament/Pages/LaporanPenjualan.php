<?php

namespace App\Filament\Pages;

use App\Models\Pesanan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Live; // <-- PENTING

class LaporanPenjualan extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';
    protected static ?string $navigationLabel = 'Laporan Penjualan';
    protected static string $view = 'filament.pages.laporan-penjualan';
    protected static ?int $navigationSort = 4; // Atur urutan di sidebar

    // Properti untuk menyimpan tanggal filter, #[Live] akan me-refresh halaman saat nilainya berubah
    #[Live]
    public ?string $startDate = null;
    #[Live]
    public ?string $endDate = null;

    public function mount(): void
    {
        // Atur tanggal default saat halaman pertama kali dibuka (misal: bulan ini)
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }

    // Mendefinisikan form filter tanggal
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('startDate')
                    ->label('Tanggal Mulai')
                    ->default($this->startDate),
                DatePicker::make('endDate')
                    ->label('Tanggal Selesai')
                    ->default($this->endDate),
            ])
            ->columns(2);
    }

    // Method untuk mengambil data statistik berdasarkan filter
    protected function getStats(): array
    {
        $query = Pesanan::query()
            ->where('status_bayar', 'lunas')
            ->whereBetween('created_at', [$this->startDate, $this->endDate]);

        $totalPendapatan = $query->sum('total_bayar');
        $jumlahTransaksi = $query->count();
        $rataRata = $jumlahTransaksi > 0 ? $totalPendapatan / $jumlahTransaksi : 0;

        return [
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalPendapatan))
                ->description('Total dari transaksi lunas')
                ->color('success'),
            Stat::make('Jumlah Transaksi', number_format($jumlahTransaksi))
                ->description('Jumlah pesanan yang sudah lunas')
                ->color('primary'),
            Stat::make('Rata-rata per Transaksi', 'Rp ' . number_format($rataRata))
                ->description('Rata-rata nilai setiap transaksi')
                ->color('info'),
        ];
    }

    // Method untuk mendefinisikan tabel riwayat transaksi
    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Query dasar untuk tabel, akan difilter berdasarkan tanggal
                Pesanan::query()
                    ->whereBetween('created_at', [$this->startDate, $this->endDate])
            )
            ->columns([
                TextColumn::make('id')->label('ID Pesanan'),
                TextColumn::make('created_at')->label('Waktu Pesan')->dateTime('d M Y, H:i'),
                TextColumn::make('meja.nama_meja')->badge(),
                TextColumn::make('nama_pelanggan')->label('Pelanggan')->default('Pengguna Terdaftar'),
                TextColumn::make('total_bayar')->formatStateUsing(fn($state) => 'Rp ' . number_format($state)),
                TextColumn::make('status_pesanan')->badge()->color(fn($state) => match ($state) {
                    'baru' => 'primary',
                    'diproses' => 'warning',
                    'selesai' => 'success',
                    'dibatalkan' => 'danger',
                }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public function filterHariIni()
    {
        $this->startDate = now()->startOfDay()->format('Y-m-d');
        $this->endDate = now()->endOfDay()->format('Y-m-d');
    }

    public function filterMingguIni()
    {
        $this->startDate = now()->startOfWeek()->format('Y-m-d');
        $this->endDate = now()->endOfWeek()->format('Y-m-d');
    }

    public function filterBulanIni()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }

    public function filterTahunIni()
    {
        $this->startDate = now()->startOfYear()->format('Y-m-d');
        $this->endDate = now()->endOfYear()->format('Y-m-d');
    }
}
