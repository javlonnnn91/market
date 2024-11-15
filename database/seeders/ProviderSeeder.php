<?php

namespace Database\Seeders;

use App\Repositories\ProviderRepository;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provider_repository = new ProviderRepository();
        $input = [
            'name' => 'Ahmad Tea',
            'tin' => '123456789',
            'address' => 'Bog`ishamol ko`chasi, 15',
            'phone' => '+998909000009'
        ];
        $provider_repository->create($input);
    }
}
