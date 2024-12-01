<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        // Start with a base query
        $query = Product::query();

        // Filter by categories if category IDs are provided
        if ($request->has('categories')) {
            $categoryIds = explode(',', $request->input('categories'));
            $query->whereIn('category_id', $categoryIds);
        }

        // Add additional filtering options as needed
        // For example, price range, search, etc.

        // Retrieve products with relationships
        $products = $query->with('category')
            ->get();

        return response()->json($products);
    }
    // public function index()
    // {
    //     $products = Product::with('category')
    //         ->withCount(['reviews as average_rating' => function ($query) {
    //             $query->select(DB::raw('coalesce(avg(rating), 0)'));
    //         }])
    //         ->get();

    //     return response()->json($products);
    // }
    public function show(Product $product)
    {
        return Inertia::render('ProductDetails', [
            'product' => $product->load(['category', 'reviews'])
        ]);
    }
    
    
}
