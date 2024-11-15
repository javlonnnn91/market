<?php

namespace Database\Seeders;

use App\Repositories\ProductRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $product_repository = new ProductRepository();
        $inputs = [
            [
                'name' => 'Ahmad Tea Earl Grey, 500g',
                'category_id' => 3,
                'tech_params' => $faker->sentence
            ],
            [
                'name' => 'Ahmad Tea Mint Green Tea, 250g',
                'category_id' => 2,
                'tech_params' => $faker->sentence
            ]

        ];
        foreach ($inputs as $input) {
            $product_repository->create($input);
        }
    }
}
