<?php

namespace Database\Seeders;

use App\Models\DaftarMeja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaftarMejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            DaftarMeja::create([
                'nama_meja' => 'Meja ' . str_pad($i, 2, '0', STR_PAD_LEFT),
            ]);
        }
    }
}
