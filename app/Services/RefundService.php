<?php

namespace App\Services;

use App\Models\StorageProduct;
use App\Repositories\RefundProductRepository;
use App\Repositories\RefundRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RefundService
{
    public function refund($data): JsonResponse
    {
        $refund_repository = new RefundRepository();
        $refund_product_repository = new RefundProductRepository();
        $storage_product = new StorageProduct();
        try {
            DB::beginTransaction();

            $total_price = collect($data['products'])->sum(fn($product) => $product['quantity'] * $product['unit_price']);

            $refund_data = [
                'batch_id' => $data['batch_id'],
                'refund_type' => $data['refund_type'],
                'total_price' => $total_price
            ];

            $refund = $refund_repository->create($refund_data);

            $refund_product_data = [];
            foreach ($data['products'] as $product_data) {
                $refund_product_data[] = [
                    'refund_id' => $refund->id,
                    'product_id' => $product_data['product_id'],
                    'quantity' => $product_data['quantity'],
                    'unit_price' => $product_data['unit_price'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                $quantity = $data['refund_type'] === 'purchase' ? -$product_data['quantity'] : $product_data['quantity'];
                $storage_product->updateQuantity(
                    $data['storage_id'],
                    $data['batch_id'],
                    $product_data['product_id'],
                    $quantity
                );
            }

            $refund_product_repository->insertArray($refund_product_data);

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error during refund creation:'. $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create refund',
                'error' => $e->getMessage(),
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Refund created successfully',
        ]);
    }

}
