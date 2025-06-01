<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SpatieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Role::create([
        'name' => 'admin',
        'guard_name' => 'web',
       ]);

       Role::create([
        'name' => 'karyawan',
        'guard_name' => 'web',
       ]);

       User::find(1)->assignRole('admin');
       User::find(2)->assignRole('karyawan');
    }
}
