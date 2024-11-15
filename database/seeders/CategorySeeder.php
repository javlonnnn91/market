<?php

namespace Database\Seeders;

use App\Repositories\CategoryRepository;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category_repository = new CategoryRepository();
        $inputs = [
            [
                'name' => 'Ahmad Tea',
                'provider_id' => 1,
                'level' => 1
            ],
            [
                'name' => 'Green Tea',
                'parent_id' => 1,
                'level' => 2
            ],
            [
                'name' => 'Black Tea',
                'parent_id' => 1,
                'level' => 2
            ],
            [
                'name' => 'White Tea',
                'parent_id' => 1,
                'level' => 2
            ],

        ];
        foreach ($inputs as $input) {
            $category_repository->create($input);
        }
    }
}
