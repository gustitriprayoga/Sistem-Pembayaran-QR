<?php

namespace App\Filament\Resources\DaftarMenuResource\Pages;

use App\Filament\Resources\DaftarMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDaftarMenu extends EditRecord
{
    protected static string $resource = DaftarMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
