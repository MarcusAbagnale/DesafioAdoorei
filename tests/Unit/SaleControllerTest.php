<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Sale;
use App\Models\Product;

class SaleControllerTest extends TestCase
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
    public function it_can_get_all_sales()
    {
        $this->actingAs($this->user);

        $response = $this->getJson('/api/sales');

        $response->assertStatus(200);
    }

    /** @test */
    /*public function it_can_create_sale()
    {
        $this->actingAs($this->user);

        $data = [
            [
                'product_id' => $this->products[0]->id,
                'quantity' => 2,
                'total_amount' => 100
            ],
            [
                'product_id' => $this->products[1]->id,
                'quantity' => 3,
                'total_amount' => 150
            ]
        ];

        $response = $this->postJson('/api/sales', $data);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Venda criada com sucesso']);
    }*/
}
