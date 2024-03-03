<?php

namespace Tests\Feature;

use App\Http\Controllers\SaleController;
use Tests\TestCase;
use App\Models\User;

final class SaleControllerTest extends TestCase
{
    private SaleController $saleController;


    protected function setUp(): void
    {
        parent::setUp();

        $this->saleController = new SaleController();
        $this->app->instance(SaleController::class, $this->saleController);
    }


   /* protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->saleController);
    }*/

    public function testIndex(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get('/api/sales')
            ->assertStatus(200);
    }

    public function testShow(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get('/api/sales/23')
            ->assertStatus(200);
    }
/*
    public function testStore(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->post('/path', [ ])
            ->assertStatus(200);
    }

    public function testAddProductsToSale(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get('/path')
            ->assertStatus(200);
    }

    public function testCancel(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get('/path')
            ->assertStatus(200);
    }*/
}
