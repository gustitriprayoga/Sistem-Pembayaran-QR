<?php

namespace Database\Seeders;

use App\Models\DaftarMenu;
use App\Models\KategoriMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuDanVarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID Kategori
        $kopi = KategoriMenu::where('nama_kategori', 'Kopi')->first();
        $nonKopi = KategoriMenu::where('nama_kategori', 'Non-Kopi')->first();
        $makanan = KategoriMenu::where('nama_kategori', 'Makanan Ringan')->first();

        // --- MENU KOPI ---
        $kopiSusu = DaftarMenu::create([
            'id_kategori' => $kopi->id,
            'nama_menu' => 'Kopi Susu',
            'deskripsi' => 'Kopi susu dengan gula aren pilihan.'
        ]);
        $kopiSusu->varian()->createMany([
            ['nama_varian' => 'Panas', 'harga' => 18000],
            ['nama_varian' => 'Dingin', 'harga' => 20000],
        ]);

        $americano = DaftarMenu::create([
            'id_kategori' => $kopi->id,
            'nama_menu' => 'Americano',
            'deskripsi' => 'Espresso dengan tambahan air.'
        ]);
        $americano->varian()->createMany([
            ['nama_varian' => 'Panas', 'harga' => 15000],
            ['nama_varian' => 'Dingin', 'harga' => 17000],
        ]);

        // --- MENU NON-KOPI ---
        $tehLemon = DaftarMenu::create([
            'id_kategori' => $nonKopi->id,
            'nama_menu' => 'Teh Lemon',
            'deskripsi' => 'Teh segar dengan perasan lemon.'
        ]);
        $tehLemon->varian()->createMany([
            ['nama_varian' => 'Panas', 'harga' => 12000],
            ['nama_varian' => 'Dingin', 'harga' => 14000],
        ]);

        // --- MENU MAKANAN ---
        $kentang = DaftarMenu::create([
            'id_kategori' => $makanan->id,
            'nama_menu' => 'Kentang Goreng',
            'deskripsi' => 'Kentang goreng renyah disajikan dengan saus.'
        ]);
        $kentang->varian()->create(['nama_varian' => 'Original', 'harga' => 22000]);
    }
}
