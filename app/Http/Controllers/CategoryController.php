<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // public function index()
    // {
    //     $categories = Category::orderBy('name', 'ASC')->get();
    //     return response()->json($categories);
    // }
    public function index()
    {
        // Fetch categories with product count
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get();

        return response()->json($categories);
    }

    public function filterProducts(Request $request)
{
    // Initialize the query builder
    $query = Product::query();

    // Filter by Category
    if ($request->has('categories') && !empty($request->categories)) {
        $query->whereIn('category_id', $request->categories);  // Assuming 'category_id' is the foreign key on the product table
    }

    // Filter by Price Range
    if ($request->has('price_min') && $request->has('price_max')) {
        $query->whereBetween('price', [$request->price_min, $request->price_max]);
    }

    // Filter by Availability 
    if ($request->has('availability')) {
        $query->where('availability', $request->availability);
    }

    // Filter by Brand
    if ($request->has('brand') && !empty($request->brand)) {
        $query->whereIn('brand', $request->brand);  // Assuming 'brand' is a column in the products table
    }

    if ($request->has('sort_by') && $request->has('sort_order')) {
        $query->orderBy($request->sort_by, $request->sort_order);
    }

    // Get the filtered products
    $products = $query->get();

    return response()->json($products);
}


public function getFilters()
{
    $categories = Category::orderBy('name', 'ASC')->get();
    $brands = Product::select('brand')->distinct()->get();  

    return response()->json([
        'categories' => $categories,
        'brands' => $brands->pluck('brand')
    ]);
}

}
