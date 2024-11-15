<?php

namespace App\Repositories;

use App\Models\Refund;

class RefundRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'batch_id',
        'refund_type',
        'total_price'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Refund::class;
    }
}
