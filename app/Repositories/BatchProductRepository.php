<?php

namespace App\Repositories;

use App\Models\BatchProduct;

class BatchProductRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'batch_id',
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
        return BatchProduct::class;
    }
}
