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

    // Izin Akses
    public static function canViewAny(): bool
    {
        // Admin dan Karyawan bisa melihat daftar pesanan
        return auth()->user()->hasAnyRole(['admin', 'karyawan']);
    }

    // Karyawan tidak bisa mengedit atau menghapus, hanya admin
    public static function canEdit($record): bool
    {
        return auth()->user()->hasRole('admin');
    }

    // Kita tidak membuat form, karena pesanan datang dari pelanggan
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pesanan')
                    ->schema([
                        Forms\Components\TextInput::make('id')
                            ->label('ID Pesanan')
                            ->disabled(),
                        Forms\Components\Select::make('meja.nama_meja')
                            ->label('Meja')
                            ->disabled(),
                        Forms\Components\TextInput::make('nama_pelanggan')
                            ->label('Nama Pelanggan')
                            ->placeholder('Pengguna Terdaftar')
                            ->disabled(),
                        Forms\Components\TextInput::make('user.name')
                            ->label('Akun Pengguna')
                            ->placeholder('Tamu')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Waktu Pesan')
                            ->displayFormat('d M Y, H:i')
                            ->disabled(),
                        Forms\Components\TextInput::make('total_bayar')
                            ->label('Total Pembayaran')
                            ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                            ->disabled(),
                        Forms\Components\TextInput::make('status_pesanan')
                            ->label('Status Pesanan')
                            ->disabled(),
                        Forms\Components\TextInput::make('status_bayar')
                            ->label('Status Pembayaran')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Rincian Item')
                    ->schema([
                        Forms\Components\Repeater::make('detailPesanan')
                            ->relationship('detailPesanan')
                            ->label(false)
                            ->schema([
                                Forms\Components\TextInput::make('varianMenu.menu.nama_menu')
                                    ->label('Nama Menu')
                                    ->disabled(),
                                Forms\Components\TextInput::make('varianMenu.nama_varian')
                                    ->label('Varian')
                                    ->disabled(),
                                Forms\Components\TextInput::make('jumlah')
                                    ->numeric()
                                    ->disabled(),
                                Forms\Components\TextInput::make('harga_saat_pesan')
                                    ->label('Harga Satuan')
                                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                                    ->disabled(),
                            ])
                            ->columns(4)
                            ->addable(false) // Sembunyikan tombol "Add"
                            ->deletable(false) // Sembunyikan tombol "Delete"
                    ])
            ]);
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
                    ->description(fn(Pesanan $record): string => $record->user->name ?? ''),
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
            'view' => Pages\ViewPesanan::route('/{record}'),
        ];
    }
}
