<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Food',
                'user_id' => 1,
                'is_default' => 1,
            ],
            [
                'name' => 'Transport',
                'user_id' => 1,
                'is_default' => 1,
            ],
            [
                'name' => 'Bills',
                'user_id' => 1,
                'is_default' => 1,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
