<?php

namespace App\Services;

use App\Models\StorageProduct;
use App\Repositories\BatchProductRepository;
use App\Repositories\BatchRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseService
{
    public function purchase($data): JsonResponse
    {
        $batch_repository = new BatchRepository();
        $batch_product_repository = new BatchProductRepository();
        $storage_products = new StorageProduct();

        try {
            DB::beginTransaction();

            $total_price = collect($data['products'])->sum(fn($product) => $product['quantity'] * $product['unit_price']);

            $batch_input = [
                'provider_id' => $data['provider_id'],
                'total_price' => $total_price
            ];

            $batch = $batch_repository->create($batch_input);

            $batch_product_data = [];
            foreach ($data['products'] as $product_data) {
                $batch_product_data[] = [
                    'batch_id' => $batch->id,
                    'product_id' => $product_data['product_id'],
                    'quantity' => $product_data['quantity'],
                    'unit_price' => $product_data['unit_price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $storage_products->updateQuantity(
                    $data['storage_id'],
                    $batch->id,
                    $product_data['product_id'],
                    $product_data['quantity']
                );
            }

            $batch_product_repository->insertArray($batch_product_data);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error during purchase creation: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create purchase',
                'error' => $e->getMessage()
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Purchase created successfully'
        ]);
    }
}
