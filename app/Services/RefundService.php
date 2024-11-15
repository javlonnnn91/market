<?php

namespace App\Services;

use App\Models\StorageProduct;
use App\Repositories\RefundProductRepository;
use App\Repositories\RefundRepository;

class RefundService
{
    public function refund($data): bool
    {
        $refund_repository = new RefundRepository();
        $refund_product_repository = new RefundProductRepository();
        $storage_products = new StorageProduct();
        $refund_input = [
            'batch_id' => $data['batch_id'],
            'refund_type' => $data['refund_type'],
            'total_price' => collect($data['products'])->sum(function ($product) {
                return $product['quantity'] * $product['unit_price'];
            })
        ];
        $refund = $refund_repository->create($refund_input);

        foreach ($data['products'] as $product_data) {
            if($data['refund_type'] == 'purchase') {
                $storage_products->out($data['storage_id'], $data['batch_id'], $product_data['product_id'], $product_data['quantity']);
            }else{
                $storage_products->in($data['storage_id'], $data['batch_id'], $product_data['product_id'], $product_data['quantity']);
            }

            $refund_product_input = [
                'refund_id' => $refund->id,
                'product_id' => $product_data['product_id'],
                'quantity' => $product_data['quantity'],
                'unit_price' => $product_data['unit_price'],
            ];
            $refund_product_repository->create($refund_product_input);
        }
        return true;
    }
}
