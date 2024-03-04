<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Factory; 
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected $products;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_can_get_all_products()
    {
        $this->actingAs($this->user);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
    }

}
