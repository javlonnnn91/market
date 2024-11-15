<?php

namespace App\Repositories;

use App\Models\RefundProduct;

class RefundProductRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'refund_id',
        'product_id',
        'quantity',
        'unit_price'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return RefundProduct::class;
    }
}
