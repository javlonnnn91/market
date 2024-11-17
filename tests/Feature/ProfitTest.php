<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Provider;
use Tests\TestCase;

class ProfitTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_profit_success()
    {
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
        $client = Client::factory()->create();
        $order = Order::factory()->create([
            'client_id' => $client->id,
        ]);
        OrderProduct::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'batch_id' => $batch->id
        ]);

        $response = $this->getJson("/api/profit?batch_id=$batch->id");

        $response->assertStatus(200);
    }

    public function test_profit_error()
    {
        $response = $this->getJson('/api/profit');

        $response->assertStatus(422);
    }
}
