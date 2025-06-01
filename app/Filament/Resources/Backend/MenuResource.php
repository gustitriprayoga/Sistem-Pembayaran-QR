<?php

namespace App\Filament\Resources\Backend;

use App\Filament\Resources\Backend\MenuResource\Pages;
use App\Filament\Resources\Backend\MenuResource\RelationManagers;
use App\Models\Backend\Menu;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;
    protected static ?string $navigationGroup = 'Menu';
    protected static ?string $label = 'List Menu';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('kategori_id')
                    ->label('Kategori')
                    ->required()
                    ->relationship('kategori', 'nama')
                    ->searchable()
                    ->preload()
                    ->placeholder('Pilih Kategori'),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull(),
                FileUpload::make('gambar')
                    ->label('Gambar Menu')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '9:16',
                    ])
                    ->imageCropAspectRatio('9:16')
                    ->disk('public')
                    ->directory('menu')
                    ->required()
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/*'])
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('aktif')
                    ->label('Apakah Produk Ini Ada ?')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kategori.nama')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('gambar')
                    ->searchable(),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean(),
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
                Tables\Actions\EditAction::make()
                ->button(),
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                ->button(),

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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
