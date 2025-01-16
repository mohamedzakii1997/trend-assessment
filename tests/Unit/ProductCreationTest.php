<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCreationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_product_creation()
    {

        $productData = [
            'name' => 'personal computer',
            'price' => 1000,
            'stock' => 100,
        ];


        $product = Product::create($productData);

        // Assert the product was created in the database
        $this->assertDatabaseHas('products', $productData);

        // check if the product instance is correct
        $this->assertEquals('personal computer', $product->name);
        $this->assertEquals(1000, $product->price);
        $this->assertEquals(100, $product->stock);
    }
}
