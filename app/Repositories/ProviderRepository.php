<?php

namespace App\Repositories;

use App\Models\Provider;

class ProviderRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'tin',
        'address',
        'phone'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Provider::class;
    }
}
