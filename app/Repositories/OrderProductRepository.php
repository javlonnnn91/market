<?php

namespace App\Repositories;

use App\Models\OrderProduct;

class OrderProductRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'order_id',
        'product_id',
        'batch_id',
        'quantity',
        'unit_price'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return OrderProduct::class;
    }
}
