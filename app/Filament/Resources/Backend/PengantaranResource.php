<?php

namespace App\Filament\Resources\Backend;

use App\Filament\Resources\Backend\PengantaranResource\Pages;
use App\Filament\Resources\Backend\PengantaranResource\RelationManagers;
use App\Models\Backend\Pengantaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengantaranResource extends Resource
{
    protected static ?string $model = Pengantaran::class;

    protected static ?string $navigationGroup = 'Pelanggan';
    protected static ?string $label = 'List Pengantaran';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pesanan_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('alamat')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('catatan')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('biaya_pengiriman')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('nama_kurir')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DateTimePicker::make('terkirim_pada'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pesanan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('biaya_pengiriman')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('nama_kurir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('terkirim_pada')
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
            'index' => Pages\ListPengantarans::route('/'),
            'create' => Pages\CreatePengantaran::route('/create'),
            'edit' => Pages\EditPengantaran::route('/{record}/edit'),
        ];
    }
}
