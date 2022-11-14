<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class CustomerItemController extends Controller
{
    public function index()
    {
        $mix = Category::with(['subCategories', 'subCategories'])->get();
        $items = Item::all();

        

        return view('FrontEnd.item.index', compact('mix', 'items'));  
        // return dd($blbost->id);
    }

    public function show($id)
    {
        $item = Item::with('category', 'subCategory')->find($id);

        return view('FrontEnd.item.show', compact('item'));
    }
}
