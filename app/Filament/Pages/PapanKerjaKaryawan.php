<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

/**
 * PapanKerjaKaryawan Class
 * * Halaman ini sekarang hanya bertindak sebagai "wadah" atau layout.
 * Semua logika tabel telah dipindahkan ke komponen Livewire terpisah.
 * File ini TIDAK BOLEH menggunakan trait 'InteractsWithTable'.
 */
class PapanKerjaKaryawan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-view-columns';

    protected static ?string $navigationLabel = 'Papan Kerja';

    protected static ?string $title = 'Papan Kerja Karyawan';

    protected static string $view = 'filament.pages.papan-kerja-karyawan';

    protected static ?int $navigationSort = -1; // Letakkan di paling atas

    /**
     * Kontrol hak akses ke halaman ini.
     * Hanya pengguna dengan peran 'karyawan' yang bisa mengakses.
     */
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('karyawan');
    }
}
