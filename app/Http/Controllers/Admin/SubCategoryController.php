<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SubCategoryStoreRequest;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = SubCategory::with(['items'])->get();

        return view('admin.subcategory.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoryStoreRequest $request)
    {
        $request->validated();

        $img = $request->file('image')->store('public/subcategory');

        SubCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'img' => $img
        ]);

        if($request->ajax())
        {
            return response()->json(['flash' => 'Podarilo sa vytvoriť novú subkategóriu.',
                                     'status'=> '1'
                                    ]);
        }
        return back()->with(['info' => 'Podarilo sa pridať subkategóriu', 'type' => 'success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subkategory)
    {
        return view('admin.category.edit', compact('$subcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategoryStoreRequest $request, SubCategory $subcategory)
    {
        $request->validated();

        $image = $subcategory->img;

        if($request->hasFile('image'))
        {
            Storage::delete($subcategory->img);
            $image = $request->file('image')->store('public/subcategory');
        };

        $subcategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'img' => $image
        ]);

        if($request->ajax())
        {
            return response()->json(['flash' => 'Podarilo sa upraviť subkategóriu.',
                                     'status'=> '1'
                                    ]);
        }
        return back()->with(['info' => 'Podarilo sa upraviť subategóriu', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SubCategory $subcategory)
    {
        Storage::delete($subcategory->img);

        $subcategory->delete();

        if($request->ajax())
        {
            return response()->json(['flash' => 'Podarilo sa vymazať subkategóriu.',
                                     'status'=> '1'
                                    ]);
        }
        return back()->with(['info' => 'Podarilo sa vymazať subkategóriu', 'type' => 'success']);
    }
}
