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
            'full_price' => $this->faker->randomNumber(5, false),
            'items_data' => json_encode(array('id' => Item::inRandomOrder()->value('id'), 'pcs' =>                      $this->faker->randomNumber(2, false))),//old value, not working. Need assoc array with more item and other info
            'user_id' => User::inRandomOrder()->value('id'),
            'adrress_id' => User::inRandomOrder()->value('id')
        ];
    }
}
