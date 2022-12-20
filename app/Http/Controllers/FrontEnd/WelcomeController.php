<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Item;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    public function index()
    {
        /* 
        variable for cache expire(23:59:00)
        */
        $expiresAt = Carbon::now()->endOfDay()->addSecond();
    
        // Random items
        if (Cache::has('random_items')){
            $random_items = Cache::get('random_items');
        } else {
            $random_items = Cache::remember('random_items', $expiresAt , function() {

                $random_items = Item::inRandomOrder()->take(4)->get();

                return $random_items;
            });
        };

        /* 
            Last added items
        */

        if (Cache::has('last_items')){
            $last_items = Cache::get('last_items');
        } else {
            $last_items = Cache::remember('last_items', $expiresAt , function() {

                $last_items = Item::orderBy('created_at', 'desc')->take(4)->get();

                return $last_items;
            });
        };
        /*  
            best seller from table item_order, 
            count how many times is there same item_id 
        */

        if (Cache::has('bestseller_items')){
            $bestseller_items = Cache::get('bestseller_items');
        } else {
            $bestseller_items = Cache::remember('bestseller_items', $expiresAt , function() {
                $bestseller_items_id = DB::table('item_order')
                                                ->groupBy('item_id')
                                                ->selectRaw('count(*) as count, item_id')
                                                ->pluck('count', 'item_id')
                                                ->sortDesc()
                                                ->take(4)
                                                ->toArray();
           
            
                $bestseller_items = Item::find(array_keys($bestseller_items_id));
                return $bestseller_items;
            });
        };
    
        return view('welcome', compact('bestseller_items', 'last_items', 'random_items'));

    }
}
