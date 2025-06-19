<?php

namespace App\Filament\Resources\DaftarMejaResource\Pages;

use App\Filament\Resources\DaftarMejaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDaftarMejas extends ListRecords
{
    protected static string $resource = DaftarMejaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
