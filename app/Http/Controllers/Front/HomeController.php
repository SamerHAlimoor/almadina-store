<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index()
    {
        //take مش باجينيشن برجع فقط 8 عناصر  
        //limit() =take()
        $products = Product::with('category')->active()->latest()->limit(8)->get();
        //dd($products);
        return view('front.home', compact('products'));
    }
}