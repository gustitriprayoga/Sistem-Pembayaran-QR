<?php

namespace Database\Factories\Backend;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Backend\KategoriMenu>
 */
class KategoriMenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Backend\KategoriMenu::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');
        $this->faker = $faker;

        return [
            'nama' => $faker->unique()->randomElement(['makanan', 'minuman', 'snack', 'dessert']),
            'deskripsi' => $this->faker->sentence,
        ];
    }
}
