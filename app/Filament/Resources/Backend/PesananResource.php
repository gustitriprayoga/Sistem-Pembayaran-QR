<?php

namespace App\Filament\Resources\Backend;

use App\Filament\Resources\Backend\PesananResource\Pages;
use App\Filament\Resources\Backend\PesananResource\RelationManagers;
use App\Models\Backend\Pesanan;
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

    protected static ?string $navigationGroup = 'Pesanan';
    protected static ?string $label = 'List Pesanan';


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pelanggan_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('kode_pesanan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('metode_pembayaran')
                    ->required(),
                Forms\Components\TextInput::make('saluran_pembayaran')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('referensi_pembayaran')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('total_harga')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('qr_code')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DateTimePicker::make('dibayar_pada'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pelanggan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kode_pesanan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('metode_pembayaran'),
                Tables\Columns\TextColumn::make('saluran_pembayaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('referensi_pembayaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_harga')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qr_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dibayar_pada')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'create' => Pages\CreatePesanan::route('/create'),
            'edit' => Pages\EditPesanan::route('/{record}/edit'),
        ];
    }
}
