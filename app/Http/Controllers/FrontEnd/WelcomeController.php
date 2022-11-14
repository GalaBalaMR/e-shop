<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $random_items = Item::inRandomOrder()->take(4)->get();
        /* 
            Last added items
        */
        $last_items = Item::orderBy('created_at', 'desc')->take(4)->get();

        /*  
            best seller from table item_order, 
            count how many times is there same item_id 
        */
        $bestseller_items_id = DB::table('item_order')
                                ->groupBy('item_id')
                                ->selectRaw('count(*) as count, item_id')
                                ->pluck('count', 'item_id')
                                ->sortDesc()
                                ->take(4)
                                ->toArray();
        
        $bestseller_items = Item::find(array_keys($bestseller_items_id));


        

        return view('welcome', compact('bestseller_items', 'last_items', 'random_items'));

    }
}
