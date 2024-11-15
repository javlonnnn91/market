<?php

namespace App\Repositories;

use App\Models\Storage;

class StorageRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'address'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Storage::class;
    }
}
