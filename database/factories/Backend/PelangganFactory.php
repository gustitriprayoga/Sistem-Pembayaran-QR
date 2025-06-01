<?php

namespace Database\Factories\Backend;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Backend\Pelanggan>
 */
class PelangganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Backend\Pelanggan::class;

    public function definition(): array
    {
         $faker = \Faker\Factory::create('id_ID');

        return [
            'nama' => $faker->name,
            'no_wa' => '08' . $faker->numerify('##########'),
            'alamat' => $faker->address,
            'jaminan' => $faker->randomElement(['KTP', 'SIM', 'Kartu Pelajar']),
            'foto_jaminan' => 'ktp.jpg',
        ];
    }
}
