<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCreateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_product_creation()
    {
        // Create a category to associate with the product
        $category = Category::create(['name' => 'fofo']);

        $productData = [
            'name' => 'carton',
            'price' => 4200,
            'stock' => 50,
            'category_id' => $category->id, // Using the category's id
        ];

        // Simulate a POST request to the controller's store method
        $response = $this->withHeaders([
            'Authorization' => 'Bearer 1|c8t0ZRZwtpKFSM6BZ5xziD44m1Llijv8LiLn1ibJbc4fbda5'
        ])->post(route('products.store'), $productData);


        //dd(route('products.store'),$response);
        // Ensure that the product is created in the database
        $this->assertDatabaseHas('products', [
            'name' => 'carton',
            'price' => 4200,
            'stock' => 50,
            'category_id' => $category->id,  // Make sure you're checking the correct category_id
        ]);

        // Assert that the response contains the correct message and product data
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'product created',
                'status' => 200,
                'data' => [
                    'id' => true,  // We expect 'id' to be present, but don't care about the value
                    'name' => 'carton',
                    'stock' => '50',
                    'price' => '4200',
                    'category' => [
                        'id' => $category->id,
                        'name' => 'fofo',  // Change 'Tech' to 'fofo' as that's the created category name
                    ],
                ],
                'pagination' => null,
            ]);
    }
}
