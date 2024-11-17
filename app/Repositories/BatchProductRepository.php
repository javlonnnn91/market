<?php

namespace App\Repositories;

use App\Models\BatchProduct;
use Illuminate\Support\Facades\DB;

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

    public function insertArray(array $batch_product_data): void
    {
        BatchProduct::insertArray($batch_product_data);
    }

    public function model(): string
    {
        return BatchProduct::class;
    }
}
