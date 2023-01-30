<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductTest extends TestCase
{
    // use DatabaseMigrations;

    // get list of all products
    public function testListProducts()
    {
        $this->get('/products')->seeStatusCode(200);
    }

    // create new product record
    public function testAddProductSuccess()
    {
        $product = [
            'name' => 'Product A',
            'description' => 'Just Product',
            'price' => 100,
            'quantity' => 10,
        ];

        $this->post('/product', $product)->seeStatusCode(201);
    }

    public function testShowProductById()
    {
        $product = [
            'name' => 'Product A',
            'description' => 'Just Product',
            'price' => 100,
            'quantity' => 10,
        ];

        $product = Product::create($product);

        $this->get("/product/{$product->id}")->seeStatusCode(200);
    }
}
