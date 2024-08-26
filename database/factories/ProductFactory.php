<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'user_id' => User::all()->random()->id,
            'name_of_product' => $this->faker->unique()->sentence(),
            'description_of_product' => $this->faker->paragraph(),
            'categories_id' =>Category::all()->random()->id,
        ];
    }
}
