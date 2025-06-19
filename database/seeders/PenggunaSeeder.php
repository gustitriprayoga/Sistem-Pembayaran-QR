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
        Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'karyawan',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'pelayan',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'pengguna',
            'guard_name' => 'web'
        ]);

        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@tuan.com',
            'password' => bcrypt('admin123'),
        ]);
        $admin->assignRole('admin');

        $karyawan = \App\Models\User::create([
            'name' => 'karyawan',
            'email' => 'karyawan@tuan.com',
            'password' => bcrypt('karyawan123'),
        ]);
        $karyawan->assignRole('karyawan');

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
