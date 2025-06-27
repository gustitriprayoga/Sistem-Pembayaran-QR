<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DaftarMenuResource\Pages;
use App\Models\DaftarMenu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload; // Jika pakai Spatie Media Library
use Illuminate\Database\Eloquent\Model;

class DaftarMenuResource extends Resource
{
    protected static ?string $model = DaftarMenu::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Manajemen Menu';
    protected static ?string $pluralModelLabel = 'Daftar Menu';

    public static function canCreate(): bool
    {
        // Hanya Admin yang bisa membuat menu baru
        return auth()->user()->hasRole('admin');
    }

    public static function canEdit(Model $record): bool
    {
        // Hanya Admin yang bisa mengedit menu
        return auth()->user()->hasRole('admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Menu')
                    ->schema([
                        Forms\Components\Select::make('kategori_id')
                            ->relationship('kategori', 'nama_kategori')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('nama_menu')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('deskripsi')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('url_gambar')
                            ->image()
                            ->imageEditor() // <-- Fitur editor gambar bawaan!
                            ->directory('menu-images'),
                        Forms\Components\Toggle::make('tersedia')
                            ->default(true)
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Varian Harga')
                    ->description('Tambahkan varian seperti Panas/Dingin beserta harganya.')
                    ->schema([
                        Forms\Components\Repeater::make('varian') // <-- Repeater untuk relasi!
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('nama_varian')->required(),
                                Forms\Components\TextInput::make('harga')
                                    ->label('Harga')
                                    ->numeric() // Hanya menerima input angka
                                    ->prefix('Rp') // Memberi awalan "Rp" pada field
                                    ->required(),
                                Forms\Components\Toggle::make('tersedia')->default(true),
                            ])
                            ->columns(3)
                            ->defaultItems(1) // Selalu ada 1 item varian saat membuat baru
                            ->addActionLabel('Tambah Varian'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('url_gambar')->label('Gambar'),
                Tables\Columns\TextColumn::make('nama_menu')
                    ->searchable()
                    ->description(fn(DaftarMenu $record): string => $record->deskripsi),
                Tables\Columns\TextColumn::make('kategori.nama_kategori')->sortable(),
                Tables\Columns\IconColumn::make('tersedia')->boolean(),
                Tables\Columns\TextColumn::make('varian.harga')
                    ->money('IDR')
                    ->label('Harga')
                    ->listWithLineBreaks() // Menampilkan semua harga varian
                    ->badge(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_menu_id')
                    ->relationship('kategori', 'nama_kategori')
                    ->label('Filter Kategori'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDaftarMenus::route('/'),
            'create' => Pages\CreateDaftarMenu::route('/create'),
            'edit' => Pages\EditDaftarMenu::route('/{record}/edit'),
        ];
    }
}
