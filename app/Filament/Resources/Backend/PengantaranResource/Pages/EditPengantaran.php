<?php

namespace App\Filament\Resources\Backend\PengantaranResource\Pages;

use App\Filament\Resources\Backend\PengantaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengantaran extends EditRecord
{
    protected static string $resource = PengantaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
