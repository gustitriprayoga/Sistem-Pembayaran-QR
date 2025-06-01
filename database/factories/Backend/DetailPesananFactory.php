<?php

namespace Database\Factories\Backend;

use App\Models\Backend\Menu;
use App\Models\Backend\Pesanan;
use App\Models\Backend\VarianMenu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Backend\DetailPesanan>
 */
class DetailPesananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Backend\DetailPesanan::class;

    public function definition(): array
    {
        $harga = $this->faker->numberBetween(8000, 25000);
        $jumlah = $this->faker->numberBetween(1, 5);
        return [
            'pesanan_id' => Pesanan::factory(),
            'menu_id' => Menu::factory(),
            'varian_id' => VarianMenu::factory(),
            'jumlah' => $jumlah,
            'harga' => $harga,
            'subtotal' => $jumlah * $harga,
            'catatan' => $this->faker->optional()->sentence,
        ];
    }
}
