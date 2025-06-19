<?php

namespace App\Filament\Resources\DaftarMejaResource\Pages;

use App\Filament\Resources\DaftarMejaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage; // <-- Import Storage
use SimpleSoftwareIO\QrCode\Facades\QrCode; // <-- Import QrCode

class CreateDaftarMeja extends CreateRecord
{
    protected static string $resource = DaftarMejaResource::class;

    protected function afterCreate(): void
    {
        // $this->record berisi data meja yang baru saja dibuat
        $meja = $this->record;

        // Tentukan path dan nama file
        $path = 'qrcodes/meja-' . $meja->id . '.svg';

        // Buat QR code dalam format SVG (lebih jernih)
        $qrCode = QrCode::format('svg')
            ->size(300)
            ->generate(url('/pesan?meja=' . $meja->id));

        // Simpan file QR code ke dalam storage
        Storage::disk('public')->put($path, $qrCode);

        // Simpan path file ke database
        $meja->qr_code_path = $path;
        $meja->save();
    }
}
