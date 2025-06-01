<?php

namespace Database\Seeders\Backend;

use App\Models\Backend\Pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelanggan::create([
            'nama' => 'John Doe',
            'no_wa' => '34242342342421342',
            'alamat' => 'Jl. Contoh Alamat No. 123',
            'jaminan' => 'KTP',
            'foto_jaminan' => 'ktp_john_doe.jpg',
        ]);
    }
}
