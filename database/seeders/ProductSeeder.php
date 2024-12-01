<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $electronicsCategory = Category::where('name', 'Electronics')->first();
        $fashionCategory = Category::where('name', 'Fashion')->first();
        
        Product::create([
            'name' => 'Smartphone',
            'description' => 'Latest model smartphone with high-end features.',
            'price' => 799.99,
            "discount_percentage" => "47.99",
            'category_id' => $electronicsCategory->id,
            'is_featured' => true,
            'image_path' => 'images/product.png',
        ]);
        Product::create([
            'name' => 'Winter Jacket',
            'description' => 'Warm and stylish jacket for winter.',
            'price' => 990.99,
            'category_id' => $fashionCategory->id,
            "discount_percentage" => "47.99",
            'is_featured' => false,
            'image_path' => 'images/product2.png',
        ]);
        
        Product::create([
            'name' => 'Running Shoes',
            'description' => 'Comfortable shoes for running and sports.',
            'price' => 590.99,
            'category_id' => $fashionCategory->id,
            "discount_percentage" => "47.99",
            'is_featured' => true,
            'image_path' => 'images/product3.png',
        ]);
        Product::create([
            'name' => 'Laptop',
            'description' => 'High-performance laptop for professionals.',
            'price' => 1200.00,
            'category_id' => $electronicsCategory->id,
            "discount_percentage" => "47.99",
            'is_featured' => true,
            'image_path' => 'images/product1.png',
        ]);
        
        Product::create([
            'name' => 'Sofas Melonies',
            'description' => 'Warm and stylish jacket for winter.',
            'price' => 999.99,
            'category_id' => $fashionCategory->id,
            "discount_percentage" => "10.99",
            'is_featured' => false,
            'image_path' => 'images/product2.png',
        ]);
        
        Product::create([
            'name' => 'Chairs',
            'description' => 'Comfortable shoes for running and sports.',
            'price' => 589.99,
            'category_id' => $fashionCategory->id,
            "discount_percentage" => "47.99",
            'is_featured' => true,
            'image_path' => 'images/product3.png',
        ]);
    }
}
