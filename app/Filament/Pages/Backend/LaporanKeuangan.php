<?php

namespace App\Filament\Pages\Backend;

use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use App\Models\Backend\Pesanan;
use Illuminate\Support\Carbon;
use Filament\Forms;
use Illuminate\Contracts\View\View;

class LaporanKeuangan extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';
    protected static string $view = 'filament.pages.laporan-keuangan';
    protected static ?string $navigationLabel = 'Laporan Keuangan';
    protected static ?string $title = 'Laporan Keuangan';

    public ?string $tipe = 'harian';
    public ?string $tanggal = null;
    public $laporan = [];

    public function mount(): void
    {
        $this->tanggal = now()->format('Y-m-d');
        $this->generateLaporan();
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('tipe')
                ->options([
                    'harian' => 'Harian',
                    'mingguan' => 'Mingguan',
                    'bulanan' => 'Bulanan',
                    'tahunan' => 'Tahunan',
                ])
                ->label('Jenis Laporan')
                ->reactive()
                ->afterStateUpdated(fn () => $this->generateLaporan()),

            DatePicker::make('tanggal')
                ->label('Tanggal Acuan')
                ->reactive()
                ->afterStateUpdated(fn () => $this->generateLaporan()),
        ];
    }

    public function generateLaporan()
    {
        $query = Pesanan::query()
            ->where('status', 'selesai');

        $tanggal = Carbon::parse($this->tanggal);

        if ($this->tipe === 'harian') {
            $query->whereDate('created_at', $tanggal);
        } elseif ($this->tipe === 'mingguan') {
            $query->whereBetween('created_at', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
        } elseif ($this->tipe === 'bulanan') {
            $query->whereMonth('created_at', $tanggal->month)
                  ->whereYear('created_at', $tanggal->year);
        } elseif ($this->tipe === 'tahunan') {
            $query->whereYear('created_at', $tanggal->year);
        }

        $this->laporan = [
            'total' => $query->sum('total_harga'),
            'jumlah' => $query->count(),
            'data' => $query->orderByDesc('created_at')->get(),
        ];
    }
}
