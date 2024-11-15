<?php

namespace App\Services;

use App\Models\StorageProduct;
use App\Repositories\BatchProductRepository;
use App\Repositories\BatchRepository;

class PurchaseService
{
    public function purchase($data): bool
    {
        $batch_repository = new BatchRepository();
        $batch_product_repository = new BatchProductRepository();
        $storage_products = new StorageProduct();

        $batch_input = [
            'provider_id' => $data['provider_id'],
            'total_price' => collect($data['products'])->sum(function ($product) {
                return $product['quantity'] * $product['unit_price'];
            })
        ];
        $batch = $batch_repository->create($batch_input);

        foreach ($data['products'] as $product_data) {

            $batch_product_input = [
                'batch_id' => $batch->id,
                'product_id' => $product_data['product_id'],
                'quantity' => $product_data['quantity'],
                'unit_price' => $product_data['unit_price'],
            ];
            $batch_product_repository->create($batch_product_input);

            $storage_products->in($data['storage_id'], $batch->id, $product_data['product_id'], $product_data['quantity']);
        }
        return true;
    }
}
