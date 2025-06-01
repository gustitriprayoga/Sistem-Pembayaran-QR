<?php

namespace Database\Factories\Backend;

use App\Models\Backend\Pesanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Backend\Pengantaran>
 */
class PengantaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Backend\Pengantaran::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');
        $this->faker = $faker;

        return [
            'pesanan_id' => Pesanan::factory(),
            'alamat' => $this->faker->address,
            'catatan' => $this->faker->optional()->sentence,
            'biaya_pengiriman' => $this->faker->numberBetween(5000, 15000),
            'status' => 'menunggu',
            'nama_kurir' => $this->faker->name,
        ];
    }
}
