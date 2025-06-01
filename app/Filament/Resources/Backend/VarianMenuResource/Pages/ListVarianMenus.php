<?php

namespace App\Filament\Resources\Backend\VarianMenuResource\Pages;

use App\Filament\Resources\Backend\VarianMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVarianMenus extends ListRecords
{
    protected static string $resource = VarianMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
