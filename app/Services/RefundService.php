<?php

namespace App\Services;

use App\Repositories\RefundProductRepository;
use App\Repositories\RefundRepository;

class RefundService
{
    public function refund($data): bool
    {
        $refund_repository = new RefundRepository();
        $refund_product_repository = new RefundProductRepository();

        $refund_input = [
            'batch_id' => $data['batch_id'],
            'refund_type' => $data['refund_type'],
            'total_price' => collect($data['products'])->sum(function ($product) {
                return $product['quantity'] * $product['price'];
            })
        ];
        $refund = $refund_repository->create($refund_input);

        foreach ($data['products'] as $product_data) {
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
