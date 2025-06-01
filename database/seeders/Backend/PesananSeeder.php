<?php

namespace Database\Seeders\Backend;

use App\Models\Backend\Pesanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pesanan::create([
            'user_id' => 1,
            'status' => 'pending',
            'total_harga' => 0,
            'catatan' => 'Pesanan ini untuk dine-in',
            'waktu_pesan' => now(),
            'waktu_selesai' => null,
        ]);
    }
}
