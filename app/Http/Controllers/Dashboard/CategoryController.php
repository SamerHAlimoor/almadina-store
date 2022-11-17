<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('categories.view')) {
            abort(403);
        }
        //
        $request = request();  // يعني لو فيه بيانات بدك اياهم من الget بجيبهم الك من هاي الفنكشن
        $q = Category::query();
        // $r = Category::active()->get();
        // return $r;

        // $q->dd();
        $categories = Category::with('parent')
            //  ->select('categories.*')
            // ->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as products_count')
            ->withCount([
                'products as products_count' => function ($q) {
                    $q->where('status', '=', 'active');
                }
            ])
            ->filters($request->query())->orderBy('name')->paginate(10);


        return view("dashboard.categories.index", compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (Gate::denies('categories.create')) {
            abort(403);
        }
        $parents = Category::all();
        $category = new Category(); // هاي حيلة حتي انه في انشاء الكاتيجوري يبعت  واحد فاضي لانه في حالة التعديل بنبعت اله هاد الصنف حتي يعرضهم في التعديل
        return view('dashboard.categories.create', compact('category', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Request merge

        Gate::authorize('categories.store');

        $request->validate(Category::rules($request->id), [
            'required' => 'This :attribute is Require',
            'unique' => 'This :attribute must be Unique',
        ]);
        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);
        //
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // it return object UploadedFile
            // $file->getClientMimeType();
            //$file->getSize();
            //$file->getClientOriginalName();
            //$file->getClientOriginalExtension();
            //$file->getClientOriginalExtension();
            $path = $file->store('categories', 'public');
            $data['image'] = $path;
        }



        // $data = $request->except('image');
        //$data['image'] = $this->uploadImage($request);

        // return $data;

        // Mass assignment
        $category = Category::create($data);

        // PRG
        return Redirect::route('dashboard.categories.index')
            ->with('success', 'Category created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        if (Gate::denies('categories.show')) {
            abort(403);
        }
        //
        //$category = Category::findOrFail($id);
        // dd($category);
        //return $category;
        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('categories.update');
        //
        $category = Category::findOrFail($id);
        //return $category->products;

        //select * from categories WHERE id <> $id AND (parent_id IS NULL OR parent_id <>$id)
        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $id);
            })->get();
        //->dd();  
        // dd()=> بترجع جملة الاستعلام بلغة الSQL  حتي تتاكد من الاستعلام صح ولا لا 
        // return $parents;
        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {

        //
        // return $request;
        /*$clean_date =  $request->validate(Category::rules($id), [
            'required' => 'This :attribute is Require',
            //'name.required' => 'This :attribute is Require', // for specific field
            'unique' => 'This :attribute must be Unique',
        ]);
*/
        $category = Category::findOrFail($id);

        $old_image = $category->image;

        $data = $request->except('image');
        $new_image = $this->uploadImage($request);
        if ($new_image) {
            $data['image'] = $new_image;
        }

        $category->update($data);
        //$category->fill($request->all())->save();

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }

        return Redirect::route('dashboard.categories.index')
            ->with('success', 'Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Gate::authorize('categories.delete');

        //
        //$category = Category::findOrFail($id);
        $category->delete();

        //Category::where('id', '=', $id)->delete();
        //Category::destroy($id);
        /* if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }*/


        return Redirect::route('dashboard.categories.index')
            ->with('success', 'Category deleted!');
    }



    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }

        $file = $request->file('image'); // UploadedFile Object

        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        return $path;
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        //withTrashed
        //onlyTrashed
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.trash')
            ->with('success', 'Category restored!');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')
            ->with('success', 'Category deleted forever!');
    }
}