<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index()
    {

        $products = Product::all()->shuffle();
        return view('product.index', compact('products'));
    }

    public function allProducts(Request $request)
    {
        $sort_by = $request->input('sort_by', 'name');
        $sort_order = $request->input('sort_order', 'asc');

        $products = Product::orderBy($sort_by, $sort_order)->get();
        return view('product.product', compact('products'));
    }
    public function categories()
    {
        $categories = Category::get();
        return view('product.categories', compact('categories'));
    }
    public function category($code = null)
    {
        $category = Category::where('code', $code)->first();
        return view('product.category', compact('category'));
    }
    public function productDetails($category, $product)
    {
        $product = Product::where('code', $product)->first();
        return view('product.productDetails', compact('product'));
    }


    public function search(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('name', 'like', '%' . $search . '%')->get();
        return view('product.search', compact('products', 'search'));
    }
}
