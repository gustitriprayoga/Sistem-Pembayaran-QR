<?php

namespace Database\Seeders\Backend;

use App\Models\Backend\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'kategori_id' => 1,
            'nama' => 'Nasi Goreng',
            'deskripsi' => 'Nasi goreng spesial dengan bumbu rahasia',
            'gambar' => 'nasi_goreng.jpg',
            'aktif' => true,
        ]);
    }
}
