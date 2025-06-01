<?php

namespace Database\Seeders\Backend;

use App\Models\Backend\KategoriMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriMenu::create([
            'nama' => 'Makanan',
            'deskripsi' => 'makanan',
        ]);

        KategoriMenu::create([
            'nama' => 'Minuman',
            'deskripsi' => 'minuman',
        ]);
    }
}
