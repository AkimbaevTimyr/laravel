<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        $products = Cache::remember('products:all', 60*60, function () {
            return Product::all();
        });

        return view('products', ['products' => $products]);
    }

    public function show($id)
    {
        $product = Cache::get("posts:{$id}");
        return view('product', ['product' => $product]);
    }
    
}
