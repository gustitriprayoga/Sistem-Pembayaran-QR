<?php

namespace Database\Factories\Backend;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Backend\Menu;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Backend\VarianMenu>
 */
class VarianMenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Backend\VarianMenu::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');
        $this->faker = $faker;

        return [
            'menu_id' => Menu::factory(),
            'varian' => $this->faker->randomElement(['panas', 'dingin']),
            'harga' => $this->faker->numberBetween(5000, 20000),
        ];
    }
}
