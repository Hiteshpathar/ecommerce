<?php

namespace Database\Factories;

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
            'order_number' => $this->faker->unique()->numberBetween(1, 1000000),
            'user_id' => 1,
            'sub_total' => $this->faker->numberBetween(100, 3000),
            'total_amount' => $this->faker->numberBetween(100, 3000),
            'quantity' => $this->faker->numberBetween(1, 300),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null)
        ];
    }
}
