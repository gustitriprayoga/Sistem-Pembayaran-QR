<?php

namespace App\Filament\Resources\Backend\VarianMenuResource\Pages;

use App\Filament\Resources\Backend\VarianMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVarianMenu extends EditRecord
{
    protected static string $resource = VarianMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
