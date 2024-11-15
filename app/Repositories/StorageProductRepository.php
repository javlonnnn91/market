<?php

namespace App\Repositories;

use App\Models\StorageProduct;

class StorageProductRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'storage_id',
        'product_id',
        'batch_id',
        'quantity'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return StorageProduct::class;
    }
}
