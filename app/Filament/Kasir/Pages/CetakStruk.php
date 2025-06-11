<?php

namespace App\Filament\Kasir\Pages;

use Filament\Pages\Page;
use App\Models\Pesanan;

class CetakStruk extends Page
{
    protected static string $view = 'filament.kasir.pages.cetak-struk';
    protected static ?string $navigationIcon = 'heroicon-o-printer';
    protected static ?string $navigationLabel = 'Cetak Struk';

    public $pesanan;

    public function mount(): void
    {
        $this->pesanan = Pesanan::latest()->take(10)->get();
    }
}
