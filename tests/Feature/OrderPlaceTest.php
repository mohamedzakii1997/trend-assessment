<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderPlaceTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        // Seed the database with sample data
        $this->customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $this->products = Product::factory()
            ->count(2)
            ->create([
                'stock' => 100,
            ]);
    }


    public function test_place_order_with_valid_data()
    {
        $payload = [
            'products' => [
                ['product_id' => $this->products[0]->id, 'quantity' => 5],
                ['product_id' => $this->products[1]->id, 'quantity' => 5],
            ],
        ];

        $response = $this->actingAs($this->customer, 'sanctum')
            ->postJson(route('orders.place-order'), $payload);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'order created',
                'status' => 200,
            ])
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'amount',
                    'customer' => ['id', 'name', 'email', 'role'],
                    'products' => [
                        ['id', 'name', 'price', 'quantity'],
                    ],
                ],
            ]);

        $this->assertDatabaseHas('orders', ['user_id' => $this->customer->id]);
        $this->assertDatabaseHas('order_products', ['product_id' => $this->products[0]->id]);
    }


    public function test_place_order_with_insufficient_stock()
    {
        $payload = [
            'products' => [
                ['product_id' => $this->products[0]->id, 'quantity' => $this->products[0]->stock + 1],
            ],
        ];

        $response = $this->actingAs($this->customer, 'sanctum')
            ->postJson(route('orders.place-order'), $payload);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'products.0.quantity',
                ],
            ]);

        $this->assertDatabaseMissing('orders', ['user_id' => $this->customer->id]);
    }




}
