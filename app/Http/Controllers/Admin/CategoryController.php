<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CategoryStoreRequest;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with(['subCategories','subCategories.items', 'items'])->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $request->validated();

        $img = $request->file('img')->store('public/categories');
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'img' => $img
        ]);

        if($request->ajax())
        {
            return response()->json(['flash' => 'Podarilo sa vytvoriť novú kategóriu.',
                                     'status'=> '1'
                                    ]);
        }
        return redirect()->route('admin.categories.index')->with(['info' => 'Podarilo sa pridať Kategóriu', 'type' => 'success']);
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
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryStoreRequest $request, Category $category)
    {
        $request->validated();

        $image = $category->img;

        if($request->hasFile('image')){
            Storage::delete($category->img);
            $image = $request->file('image')->store('public/categories');
        };

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'img' => $image
        ]);

        if($request->ajax())
        {
            return response()->json(['flash' => 'Podarilo sa upraviť kategóriu.',
                                     'status'=> '1'
                                    ]);
        }
        return redirect()->route('admin.categories.index')->with(['info' => 'Podarilo sa upraviť Kategóriu', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        Storage::delete($category->img);

        $category->delete();
        
        if($request->ajax())
        {
            return response()->json(['flash' => 'Podarilo sa vymazať kategóriu.',
                                     'status'=> '1'
                                    ]);
        }
        return back()->with(['info' => 'Podarilo sa vymazať Kategóriu', 'type' => 'success']);

    }
}
