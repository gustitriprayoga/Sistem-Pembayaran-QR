<?php

namespace App\Filament\Resources\Backend\PesananResource\Pages;

use App\Filament\Resources\Backend\PesananResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPesanan extends EditRecord
{
    protected static string $resource = PesananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
