<?php

namespace Database\Seeders;

use App\Models\KategoriMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriMenu::create(['nama_kategori' => 'Kopi']);
        KategoriMenu::create(['nama_kategori' => 'Non-Kopi']);
        KategoriMenu::create(['nama_kategori' => 'Makanan Ringan']);
    }
}
