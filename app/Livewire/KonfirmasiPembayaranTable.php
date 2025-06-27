<?php

namespace App\Livewire;

use App\Models\Pesanan;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class KonfirmasiPembayaranTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Pesanan::query()->where('status_bayar', 'menunggu')
            )
            ->defaultSort('created_at', 'asc')
            ->heading('Konfirmasi Pembayaran (Kasir)')
            ->description('Pesanan yang menunggu pembayaran di kasir.')
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('daftarMeja.nama_meja')->badge(),
                TextColumn::make('nama_pelanggan')->label('Pelanggan')->default('Pengguna Terdaftar'),
                TextColumn::make('detailPesanan')
                    ->label('Item Pesanan')
                    ->html()
                    ->formatStateUsing(function ($record) {
                        return $record->detailPesanan->map(function ($item) {
                            // Tambahkan pengecekan untuk memastikan relasi tidak null
                            if ($item->varianMenu && $item->varianMenu->daftarMenu) {
                                return $item->jumlah . 'x ' . $item->varianMenu->daftarMenu->nama_menu . ' (' . $item->varianMenu->nama_varian . ')';
                            }
                            return 'Item tidak valid';
                        })->implode('<br>');
                    }),
                BadgeColumn::make('status_pesanan')->colors(['primary' => 'baru', 'warning' => 'diproses']),
                BadgeColumn::make('metode_pembayaran')->colors(['primary' => 'kasir', 'warning' => 'transfer', 'success' => 'ewallet']),
                TextColumn::make('total_bayar')->formatStateUsing(fn ($state) => 'Rp ' . number_format($state)),
            ])
            ->actions([
                TableAction::make('konfirmasiBayar')
                    ->label('Bayar Lunas')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Pesanan $record) {
                        $record->update(['status_bayar' => 'lunas']);
                        Notification::make()->title('Pembayaran Lunas')->body("Pesanan #{$record->id} telah dikonfirmasi.")->success()->send();
                    }),
            ]);
    }

    public function render()
    {
        return view('livewire.konfirmasi-pembayaran-table');
    }
}
