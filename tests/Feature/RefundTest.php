<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Storage;
use App\Models\StorageProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RefundTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_refund_success()
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
        StorageProduct::factory()->create([
            'storage_id' => $storage->id,
            'product_id' => $product->id,
            'batch_id' => $batch->id
        ]);

        $refund_type = 'purchase'; //sale
        $quantity = 2;
        $response = $this->postJson('/api/refund', [
            'batch_id' => $batch->id,
            'storage_id' => $storage->id,
            'refund_type' => $refund_type,
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => 1000.00,
                ]
            ]
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('refunds', [
            'batch_id' => $batch->id,
            'refund_type' => $refund_type
        ]);
        $this->assertDatabaseHas('refund_products', [
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);
    }

    public function test_refund_error()
    {
        $response = $this->postJson('/api/refund', [
            'batch_id' => 999,
            'storage_id' => 999,
            'products' => []
        ]);

        $response->assertStatus(422);
    }
}
