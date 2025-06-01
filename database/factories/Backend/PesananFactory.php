<?php

namespace Database\Factories\Backend;

use App\Models\Backend\Pelanggan;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Backend\Pesanan>
 */
class PesananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Backend\Pesanan::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');
        $this->faker = $faker;

        return [
            'pelanggan_id' => Pelanggan::factory(),
            'kode_pesanan' => strtoupper(Str::random(10)),
            'status' => 'menunggu',
            'metode_pembayaran' => $this->faker->randomElement(['qris', 'e-wallet', 'transfer_bank', 'cod', 'tunai']),
            'saluran_pembayaran' => null,
            'referensi_pembayaran' => null,
            'total_harga' => $this->faker->numberBetween(20000, 100000),
            'qr_code' => null,
            'dibayar_pada' => null,
        ];
    }
}
