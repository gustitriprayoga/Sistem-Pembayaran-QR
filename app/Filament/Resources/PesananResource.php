<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesananResource\Pages;
use App\Filament\Resources\PesananResource\RelationManagers;
use App\Models\Pesanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PesananResource extends Resource
{
    protected static ?string $model = Pesanan::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Manajemen Operasional';

     // Kita tidak membuat form, karena pesanan datang dari pelanggan
    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc') // Pesanan terbaru di atas
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID Pesanan')->searchable(),
                Tables\Columns\TextColumn::make('meja.nama_meja')->badge(),
                Tables\Columns\TextColumn::make('nama_pelanggan')
                    ->label('Pelanggan')
                    ->default('Pengguna Terdaftar')
                    ->description(fn (Pesanan $record): string => $record->user->name ?? ''),
                Tables\Columns\TextColumn::make('total_bayar')->money('IDR')->sortable(),
                Tables\Columns\BadgeColumn::make('status_pesanan') // <-- Badge untuk Status!
                    ->colors([
                        'primary' => 'baru',
                        'warning' => 'diproses',
                        'success' => 'selesai',
                        'danger' => 'dibatalkan',
                    ]),
                Tables\Columns\BadgeColumn::make('status_bayar')
                    ->colors([
                        'warning' => 'menunggu',
                        'success' => 'lunas',
                        'danger' => 'gagal',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y, H:i')->label('Waktu Pesan'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_pesanan')
                    ->options([
                        'baru' => 'Baru',
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // Mengarah ke halaman detail
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanans::route('/'),
            // Halaman view untuk detail seperti struk
            'view' => Pages\ViewPesanan::route('/{record}'),
        ];
    }
}
