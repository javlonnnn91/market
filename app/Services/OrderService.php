<?php

namespace App\Services;

use App\Models\StorageProduct;
use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function order($data): JsonResponse
    {
        $order_repository = new OrderRepository();
        $order_product_repository = new OrderProductRepository();
        $storage_products = new StorageProduct();

        try {
            DB::beginTransaction();

            $total_price = collect($data['products'])->sum(fn($product) => $product['quantity'] * $product['price']);

            $order_input = [
                'client_id' => $data['client_id'],
                'total_price' => $total_price
            ];

            $order = $order_repository->create($order_input);

            $order_product_data = [];
            foreach ($data['products'] as $product_data) {
                $order_product_data[] = [
                    'order_id' => $order->id,
                    'product_id' => $product_data['product_id'],
                    'batch_id' => $product_data['batch_id'],
                    'quantity' => $product_data['quantity'],
                    'unit_price' => $product_data['price'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                $storage_products->updateQuantity(
                    $product_data['storage_id'],
                    $product_data['batch_id'],
                    $product_data['product_id'],
                    -$product_data['quantity']
                );
            }
            $order_product_repository->insertArray($order_product_data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error during order creation: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 400);
        }
        return response()->json([
            'success' => true,
            'message' => 'Order created successfully'
        ]);
    }
}
