<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //

    public function index(Request $request)
    {
        return $request;
    }

    public function show(Product $product)
    {
        //dd($product);
        // return $product->id;
        if ($product->status != 'active') {
            abort(404);
        }

        return view('front.products.show', compact('product'));
    }
}