<?php

namespace App\Services;

use App\Repositories\BatchProductRepository;
use App\Repositories\BatchRepository;
use App\Repositories\StorageProductRepository;

class PurchaseService
{
    public function purchase($data): bool
    {
        $batch_repository = new BatchRepository();
        $batch_product_repository = new BatchProductRepository();
        $storage_product_repository = new StorageProductRepository();

        $batch_input = [
            'provider_id' => $data['provider_id'],
            'total_price' => collect($data['products'])->sum(function ($product) {
                return $product['quantity'] * $product['price'];
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

            $storage_product_input = [
                'storage_id' => $data['storage_id'],
                'batch_id' => $batch->id,
                'product_id' => $product_data['product_id'],
                'quantity' => $product_data['quantity'],
            ];
            $storage_product_repository->create($storage_product_input);
        }
        return true;
    }
}
