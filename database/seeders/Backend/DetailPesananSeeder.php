<?php

namespace Database\Seeders\Backend;

use App\Models\Backend\DetailPesanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailPesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DetailPesanan::create([
            'pesanan_id' => 1,
            'menu_id' => 1,
            'varian_menu_id' => 1,
            'jumlah' => 2,
            'harga' => 50000,
            'subtotal' => 100000,
        ]);
    }
}
