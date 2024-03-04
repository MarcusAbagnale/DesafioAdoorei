<?php

namespace Database\Factories;

use App\Models\ProductSale;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductSaleFactory extends Factory
{
    protected $model = ProductSale::class;

    public function definition()
    {
        return [
            'product_id' => \App\Models\Product::factory()->create()->product_id,
            'sale_id' => \App\Models\Sale::factory()->create()->sale_id,
            'quantity' => $this->faker->numberBetween(1, 10),
            'total_amount' => $this->faker->numberBetween(1, 10),
        ];
    }
}
