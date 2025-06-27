<?php

namespace App\Livewire;

use App\Models\Pesanan;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\SelectAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class PesananMasukTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Pesanan::query()->where('status_bayar', 'lunas')->whereIn('status_pesanan', ['baru', 'diproses'])
            )
            ->defaultSort('created_at', 'asc')
            ->heading('Pesanan Masuk (Dapur/Bar)')
            ->description('Pesanan yang siap untuk diproses dan disajikan.')
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('daftarMeja.nama_meja')->badge(),
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
                TextColumn::make('created_at')->label('Tanggal Konfirmasi')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: false),
            ])
            ->actions([
                SelectAction::make('ubahStatus')
                    ->label('Ubah Status')
                    ->options([
                        'diproses' => 'Proses Pesanan',
                        'selesai' => 'Selesaikan Pesanan',
                    ])
                    ->action(function (Pesanan $record, $data) {
                        $record->update(['status_pesanan' => $data['status']]);
                        $meja = $record->meja;
                        if ($meja) {
                            $newStatusMeja = ($data['status'] === 'diproses') ? 'tidak tersedia' : 'tersedia';
                            $meja->update(['status_meja' => $newStatusMeja]);
                        }
                        Notification::make()->title('Status pesanan diperbarui')->success()->send();
                    })
            ]);
    }

    public function render()
    {
        return view('livewire.pesanan-masuk-table');
    }
}
