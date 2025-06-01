<?php

namespace Database\Factories\Backend;

use App\Models\Backend\KategoriMenu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Backend\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Backend\Menu::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');
        $this->faker = $faker;

        return [
            'kategori_id' => KategoriMenu::factory(),
            'nama' => $this->faker->unique()->words(2, true),
            'deskripsi' => $this->faker->sentence,
            'gambar' => 'default.jpg',
            'aktif' => true,
        ];
    }
}
