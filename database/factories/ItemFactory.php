<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'img' => 'public/seed/empty.jpg|public/seed/empty.jpg|public/seed/empty.jpg',
            'storage_pcs' => $this->faker->numberBetween(1, 249),
            'price' => $this->faker->numberBetween(1, 249),

            'short_description' => $this->faker->paragraph(),
            'long_description' => $this->faker->paragraphs(2, true)
        ];
    }
}
