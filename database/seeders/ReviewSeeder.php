<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // Assuming there's a user in your database already
        $product1 = Product::where('name', 'Smartphone')->first();
        $product2 = Product::where('name', 'Laptop')->first();
        $product3 = Product::where('name', 'Winter Jacket')->first();
        $product4 = Product::where('name', 'Running Shoes')->first();
        $product5 = Product::where('name', 'Sofas Melonies')->first();
        $product6 = Product::where('name', 'Chairs')->first();

        Review::create([
            'user_id' => $user->id,
            'product_id' => $product1->id,
            'rating' => 5,
            'comment' => 'This smartphone is amazing! Highly recommend it.',
        ]);
        
        Review::create([
            'user_id' => $user->id,
            'product_id' => $product2->id,
            'rating' => 4,
            'comment' => 'Great laptop for work, but could be a little lighter.',
        ]);

        Review::create([
            'user_id' => $user->id,
            'product_id' => $product3->id,
            'rating' => 5,
            'comment' => 'This smartphone is amazing! Highly recommend it.',
        ]);
        
        Review::create([
            'user_id' => $user->id,
            'product_id' => $product4->id,
            'rating' => 4,
            'comment' => 'Great laptop for work, but could be a little lighter.',
        ]);

        Review::create([
            'user_id' => $user->id,
            'product_id' => $product5->id,
            'rating' => 5,
            'comment' => 'This smartphone is amazing! Highly recommend it.',
        ]);
        
        Review::create([
            'user_id' => $user->id,
            'product_id' => $product6->id,
            'rating' => 4,
            'comment' => 'Great laptop for work, but could be a little lighter.',
        ]);
    }
}
