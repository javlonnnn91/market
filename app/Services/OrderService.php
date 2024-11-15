<?php

namespace App\Services;

use App\Models\StorageProduct;
use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;

class OrderService
{
    public function order($data): bool
    {
        $order_repository = new OrderRepository();
        $order_product_repository = new OrderProductRepository();
        $storage_products = new StorageProduct();

        $order_input = [
            'client_id' => $data['client_id'],
            'total_price' => collect($data['products'])->sum(function ($product) {
                return $product['quantity'] * $product['price'];
            })
        ];

        $order = $order_repository->create($order_input);

        foreach ($data['products'] as $product_data) {
            $order_product_input = [
                'order_id' => $order->id,
                'product_id' => $product_data['product_id'],
                'batch_id' => $product_data['batch_id'],
                'quantity' => $product_data['quantity'],
                'unit_price' => $product_data['price']
            ];
            $order_product_repository->create($order_product_input);

            $storage_products->out($product_data['storage_id'], $product_data['batch_id'], $product_data['product_id'], $product_data['quantity']);
        }
        return true;
    }
}
