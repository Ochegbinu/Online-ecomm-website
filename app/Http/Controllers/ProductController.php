<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->withCount(['reviews as average_rating' => function ($query) {
                $query->select(DB::raw('coalesce(avg(rating), 0)'));
            }])
            ->get();

        return response()->json($products);
    }
    public function show(Product $product)
    {
        return Inertia::render('ProductDetails', [
            'product' => $product->load(['category', 'reviews'])
        ]);
    }
    
    
}
