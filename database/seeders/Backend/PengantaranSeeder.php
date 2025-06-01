<?php

namespace Database\Seeders\Backend;

use App\Models\Backend\Pengantaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengantaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengantaran::create([
            'pesanan_id' => 1,
            'catatan' => 'Segera antar pesanan ini',
            'biaya_pengiriman' => 15000,
            'alamat' => 'Jl. Contoh Alamat No. 123',
            'status' => 'Menunggu',
            'nama_kurir' => 'Kurir A',
            'terikirm_pada' => now(),
        ]);
    }
}
