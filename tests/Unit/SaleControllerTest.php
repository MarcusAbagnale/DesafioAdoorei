<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\User;
use App\Models\Sale;
use App\Models\Product;
use App\Models\ProductSale;

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

    public function testCanGetSaleById()
    {
        $user = User::factory()->create();
        $sale = Sale::factory()->create();
        $products = Product::factory()->count(2)->create();
        
        foreach ($products as $product) {
            ProductSale::create([
                'sale_id' => $sale->sale_id,
                'product_id' => $product->product_id,
                'quantity' => 10,
                'total_amount' => $product->price * 10,
            ]);
        }
        
        $expectedJson = [
            'sale_id',
            'amount',
            'products', 
        ];
        
        
        $this->actingAs($user);
        
        $response = $this->getJson('/api/sales/' . $sale->sale_id);
    
        $response->assertStatus(200)
                 ->assertJsonStructure($expectedJson);
    }
    

    /** @test */
    public function it_can_create_sale()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/api/sales/register', [
            'sales' => [
                [
                    "product_id" => 1,
                    "quantity" => 15,
                    "total_amount" => 8200
                ],
                [
                    "product_id" => 2,
                    "quantity" => 10,
                    "total_amount" => 9000
                ]
            ]
        ]);


        $response->assertStatus(201);
        $response->assertJson(['message' => 'Venda criada com sucesso']);
    }
}
