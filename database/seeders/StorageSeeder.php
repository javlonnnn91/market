<?php

namespace Database\Seeders;

use App\Repositories\StorageRepository;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $storage_repository = new StorageRepository();
        $input = [
            'name' => $faker->company,
            'address' => $faker->address,
        ];
        $storage_repository->create($input);
    }
}
