<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'price' => $this->faker->randomNumber(5, false),
            'pieces' => json_encode(array('id' => Item::inRandomOrder()->value('id'), 'pcs' => $this->faker->randomNumber(2, false))),
            'user_id' => User::inRandomOrder()->value('id')
        ];
    }
}
