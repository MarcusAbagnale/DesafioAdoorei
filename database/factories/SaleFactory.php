<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sale;
use Faker\Generator as Faker;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition()
    {
        return [
            'total_amount' => $this->faker->randomFloat(2, 10, 100),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
            'cancelled_at' => null, 
        ];
    }
}

