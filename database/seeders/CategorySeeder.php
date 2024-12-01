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
    public function run(): void
    {
        Category::create(['name' => 'Electronics']);
        Category::create(['name' => 'Fashion']);
        Category::create(['name' => 'Home & Furniture']);
        Category::create(['name' => 'Sports & Outdoors']);
        Category::create(['name' => 'Beauty & Health']);
        Category::create(['name' => 'Toys & Games']);
        Category::create(['name' => 'Books']);
    }
}
