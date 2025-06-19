<?php

namespace App\Filament\Resources\DaftarMejaResource\Pages;

use App\Filament\Resources\DaftarMejaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDaftarMeja extends EditRecord
{
    protected static string $resource = DaftarMejaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
