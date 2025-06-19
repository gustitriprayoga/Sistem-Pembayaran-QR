<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'kasir']);
        Role::create(['name' => 'pelayan']);
        Role::create(['name' => 'pengguna']);

        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@tuan.com',
            'password' => bcrypt('admin123'),
        ]);
        $admin->assignRole('admin');

        $kasir = \App\Models\User::create([
            'name' => 'Kasir',
            'email' => 'kasir@tuan.com',
            'password' => bcrypt('kasir123'),
        ]);
        $kasir->assignRole('kasir');

        $pelayan = \App\Models\User::create([
            'name' => 'Pelayan',
            'email' => 'pelayan@tuan.com',
            'password' => bcrypt('pelayan123'),
        ]);
        $pelayan->assignRole('pelayan');

        $pengguna = \App\Models\User::create([
            'name' => 'Pengguna',
            'email' => 'pengguna@tuan.com',
            'password' => bcrypt('pengguna123'),
        ]);
        $pengguna->assignRole('pengguna');

    }
}
