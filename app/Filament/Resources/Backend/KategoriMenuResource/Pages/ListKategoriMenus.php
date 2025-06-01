<?php

namespace App\Filament\Resources\Backend\KategoriMenuResource\Pages;

use App\Filament\Resources\Backend\KategoriMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKategoriMenus extends ListRecords
{
    protected static string $resource = KategoriMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
