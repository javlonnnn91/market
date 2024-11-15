<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Storage;
use App\Models\StorageProduct;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_order_success()
    {
        $storage = Storage::factory()->create();
        $provider = Provider::factory()->create();
        $rootCategory = Category::factory()->create([
            'provider_id' => $provider->id
        ]);
        $childCategory = Category::factory()
            ->withParent($rootCategory)
            ->create();
        $product = Product::factory()->create([
            'category_id' => $childCategory->id,
        ]);
        $batch = Batch::factory()->create([
            'provider_id' => $provider->id
        ]);
        $storage_product = StorageProduct::factory()->create([
            'storage_id' => $storage->id,
            'product_id' => $product->id,
            'batch_id' => $batch->id
        ]);
        $client = Client::factory()->create();


        $quantity = 2;
        $response = $this->postJson('/api/order', [
            'client_id' => $client->id,
            'products' => [
                [
                    'product_id' => $storage_product->id,
                    'quantity' => $quantity,
                    'price' => 2000.00,
                    'batch_id' => $storage_product->batch_id,
                    'storage_id' => $storage_product->storage_id,
                ]
            ]
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'client_id' => $client->id,
        ]);

        $this->assertDatabaseHas('order_products', [
            'product_id' => $storage_product->id,
            'quantity' => $quantity,
        ]);
    }

    public function test_order_error()
    {
        $response = $this->postJson('/api/order', [
            'client_id' => 999,
            'products' => []
        ]);

        $response->assertStatus(422);
    }
}
