<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{Category, Provider, Storage, Product};

class PurchaseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_purchase_success()
    {
        $provider = Provider::factory()->create();
        $storage = Storage::factory()->create();
        $rootCategory = Category::factory()->create([
            'provider_id' => $provider->id
        ]);
        $childCategory = Category::factory()
            ->withParent($rootCategory)
            ->create();
        $product = Product::factory()->create([
            'category_id' => $childCategory->id,
        ]);

        $response = $this->postJson('/api/purchase', [
            'provider_id' => $provider->id,
            'storage_id' => $storage->id,
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 10,
                    'unit_price' => 1000.00,
                ]
            ]
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('batches', [
            'provider_id' => $provider->id
        ]);
        $this->assertDatabaseHas('batch_products', [
            'product_id' => $product->id,
            'quantity' => 10
        ]);
        $this->assertDatabaseHas('storage_products', [
            'storage_id' => $storage->id,
            'product_id' => $product->id,
            'quantity' => 10
        ]);
    }

    public function test_purchase_error()
    {
        $response = $this->postJson('/api/purchase', [
            'provider_id' => 999,
            'storage_id' => 999,
            'products' => []
        ]);

        $response->assertStatus(422);
    }
}
