<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::inRandomOrder()->take(8)->get();
        return view('product.index', compact('products'));
    }


    public function allProducts(Request $request)
    {

        $products = Product::withSort($request->sort)->get();
        return view('product.product', compact('products'));
    }

    public function categories()
    {
        $categories = Category::all();
        return view('product.categories', compact('categories'));
    }

    public function category(Request $request, $code = null)
    {
        $category = Category::where('code', $code)->firstOrFail();

        $products = $category->products()->withSort($request->sort)->get();

        return view('product.category', compact('category', 'products'));
    }

    public function productDetails($category, $product)
    {
        $product = Product::where('code', $product)->firstOrFail();
        return view('product.productDetails', compact('product'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $products = Product::where('name', 'like', "%{$search}%")
            ->withSort($request->sort)
            ->get();

        return view('product.search', compact('products', 'search'));
    }
}
