<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'post_code' => $this->faker->randomNumber(5, true),
            'number' => $this->faker->randomNumber(5, true),
            'town' => $this->faker->word(),
            'street' => $this->faker->word(),
            'user_id' => User::inRandomOrder()->value('id'),
            'order_id' => Order::inRandomOrder()->value('id')
        ];
    }
}
