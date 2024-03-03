<?php

namespace Database\Seeders;
use App\Models\Sale;

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
    }
}
