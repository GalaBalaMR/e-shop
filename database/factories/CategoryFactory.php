<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraphs(2, true),
            'img' => 'public/seed/empty.jpg',
        ];
    }
}
