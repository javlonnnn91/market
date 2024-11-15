<?php

namespace App\Repositories;

use App\Models\Batch;

class BatchRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'provider_id',
        'total_price'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Batch::class;
    }
}
