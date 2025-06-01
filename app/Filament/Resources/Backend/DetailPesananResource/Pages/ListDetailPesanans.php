<?php

namespace App\Filament\Resources\Backend\DetailPesananResource\Pages;

use App\Filament\Resources\Backend\DetailPesananResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDetailPesanans extends ListRecords
{
    protected static string $resource = DetailPesananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
