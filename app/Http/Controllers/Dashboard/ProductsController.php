<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$this->authorize('view-any', Product::class);
        // $products = Product::withoutGlobalScope('store')->paginate(10);
        $products = Product::with(['category', 'store'])->paginate();
        // SELECT * FROM products
        // SELECT * FROM categories WHERE id IN (..)
        // SELECT * FROM stores WHERE id IN (..)
        // return dd($products);

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $product = Product::findOrFail($id);
        //implode => convert array to string
        $tags = implode(',', $product->tags()->pluck('name')->toArray()); // pluck is return specific column that is name and is array of string not array of opject
        return view('dashboard.products.edit', compact('product', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $product->update($request->except('tags'));

        //بسبب المكتبة tagify بصلني البيانات التاج عبارة عن جيسون وهنا لازم استخدم ميثود
        // decode
        //  $tags = json_decode($request->post('tags'))
        //  $tags = explode(",", $request->post('tags'));
        $tags = json_decode($request->post('tags'));
        //   return $tags;
        $tag_ids = [];

        $saved_tags = Tag::all();

        foreach ($tags as $item) {
            $slug = Str::slug($item->value);
            $tag = $saved_tags->where('slug', $slug)->first();
            if (!$tag) {
                $tag = Tag::create([
                    'name' => $item->value,
                    'slug' => $slug,
                ]);
            }
            $tag_ids[] = $tag->id;
        }

        //detach => for realtationships and this to delete array in db
        //attach => to add array in db and this method have a problem that is it maybe add a previous column in db 
        $product->tags()->sync($tag_ids); // just in relationship many to many

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}