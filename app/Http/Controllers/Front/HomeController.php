<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index()
    {
        //take مش باجينيشن برجع فقط 8 عناصر  
        //limit() =take()
        $products = Product::with('category')->active()->latest()->limit(8)->get();
        //
        // $cart = Cart::with('product')->get();

        // dd($cart);
        return view('front.home', compact('products'));
    }
}