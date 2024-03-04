<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductSale;
use App\Models\Sale;
use Database\Factories\ProductSaleFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Sale::factory()->count(10)->create();
        Product::factory()->count(10)->create();
        ProductSale::factory()->count(10)->create();
    }
}
