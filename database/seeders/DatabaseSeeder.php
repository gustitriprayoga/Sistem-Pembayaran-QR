<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Backend\KategoriMenu;
use App\Models\Backend\Pelanggan;
use App\Models\Backend\Pesanan;
use App\Models\Backend\DetailPesanan;
use App\Models\Backend\Pengantaran;
use App\Models\Backend\Menu;
use App\Models\Backend\VarianMenu;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);

        User::create([
            'name' => 'karyawan',
            'email' => 'karyawan@gmail.com',
            'password' => bcrypt('karyawan'),
        ]);

        $this->call([
            SpatieSeeder::class,
            // Add other seeders here if needed
        ]);

        KategoriMenu::factory(3)->has(
            Menu::factory(3)->has(
                VarianMenu::factory(2)
            )
        )->create();

        Pelanggan::factory(10)->create()->each(function ($pelanggan) {
            $pesanan = Pesanan::factory()->create([
                'pelanggan_id' => $pelanggan->id,
            ]);

            DetailPesanan::factory(3)->create([
                'pesanan_id' => $pesanan->id,
            ]);

            Pengantaran::factory()->create([
                'pesanan_id' => $pesanan->id,
            ]);
        });
    }
}
