<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemStoreRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();

        return view('admin.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemStoreRequest $request)
    {
        $request->validated();

        $images=array();
        if($files=$request->file('img')){
            foreach($files as $file){
                $image = $file->store('public/item');
                $images[]=$image;
            }
        }

        Item::create([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'price' => $request->price,
            'numbers' => $request->numbers,
            'img' => implode("|", $images),
        ]);

        if($request->ajax())
        {
            return response()->json(['flash' => 'Podarilo sa vytvoriť novú položku.',
                                     'status'=> '1'
                                    ]);
        }
        return redirect()->route('admin.items.index')->with(['info' => 'Podarilo sa pridať položku', 'type' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return view('admin.items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $item = $item;
        return view('admin.items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required',
            'short_description' => 'required|max:255',
            'long_description' => 'required',
            'price' => 'required',
            'numbers' => 'required',
        ]);

        $images = $item->img;

        if($request->hasFile('img'))
        {
            Storage::delete(explode('|', $item->img));
            $images = array();

            if($files = $request->file('img'))
            {
                foreach($files as $file)
                {
                    $image = $file->store('public/item');
                    $images[] = $image;
                }
            }

            $images = implode('|', $images);

        };
        
        $item->update([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'price' => $request->price,
            'numbers' => $request->numbers,
            'img' => $images
        ]);

        if($request->ajax())
        {
            return response()->json(['flash' => 'Podarilo sa upraviť položku.',
                                     'status'=> '1'
                                    ]);
        }
        return redirect()->route('admin.items.index')->with(['info' => 'Podarilo sa upraviť položku', 'type' => 'success']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Item $item)
    {
        Storage::delete([explode('|', $item->img)]);

        $item->delete();

        if($request->ajax())
        {
            return response()->json(['flash' => 'Podarilo sa vymazať položku.',
                                     'status'=> '1'
                                    ]);
        }
        return back()->with(['info' => 'Podarilo sa vymazať položku', 'type' => 'success']);
    }
}
