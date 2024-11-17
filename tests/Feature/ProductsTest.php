<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\BatchProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Storage;
use App\Models\StorageProduct;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_product_success()
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

        $response = $this->getJson("/api/product?batch_id=$batch->id");

        $response->assertStatus(200);
    }

    public function test_product_error()
    {
        $response = $this->getJson('/api/product');

        $response->assertStatus(422);
    }
}
