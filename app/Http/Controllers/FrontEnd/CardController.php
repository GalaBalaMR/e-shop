<?php

namespace App\Http\Controllers\FrontEnd;


use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CardController extends Controller
{
    //show card
    // with item from session
    public function showCard()
    {
        $pieces = array();
        $prices = array();
        $mix = array();

        foreach(session('items') as $item)
        {
            // find model
            $item_Col = Item::find($item['id']);

            // sum price
            $item_price = $item_Col->price;
            $item_price *= $item['pcs'];

            /*  
            change model to array for foreach loop in view
            other types(object..) alternative has lots of loop which case in error
             */
            
            $item_Col->toArray();


            $prices[$item['id']] = $item_price;

            $pieces[$item['id']] = $item['pcs'];

            // make asoc array which send to the view    
            $items_data[] = [
                'item' => $item_Col,
                'fullPrice' => $item_price,
                'pcs' => $item['pcs']
            ];


        }; 

        return view('card', compact('items_data'));
    }

    /* 
    store request data in session
    */
    public function storeInSession(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'item_pcs' => 'required'
        ]);
        //session()->put('items', []);

        $item_id = $request->id;
        $item_pcs = $request->pcs;

        Session::push('items' , [
            'id' => $item_id,
            'pcs' => $item_pcs,
        ]);
        Session::save(); 
        // end this function
        if($request->ajax())
        {
            return response()->json(['flash' => 'Podarilo sa pridať produkt.',
                                     'status'=> '1'
                                    ]);
        }
        return back()->with(['info' => 'Podarilo sa pridať produkt.', 'type' => 'success']);
    }

    /* 
    Update item in session items
    request id for finding which item
    delete this item and add new with same id and different pcs
     */
    public function updateItem(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'item_pcs' => 'required'
        ]);

        $id = $request->item_id;
        $pcs = $request->item_pcs;

        $session_item = session('items');

        /* find item in session items base on item_id */
        foreach($session_item as $index => $item)
        {
            if($item['id'] == $id)
            {
                // delete old item and make new item and push it in arr
                unset($session_item[$index]);
                array_push($session_item , [
                    'id' => $id,
                    'pcs' => $pcs,
                ]);
                
            };
        };
        // push $session_item in the session
        session()->put("items", $session_item);
        // Session::forget('items');
        
        Session::save();

        if($request->ajax())
        {
            return response()->json(['flash' => 'Podarilo sa upraviť produkt.',
                                     'status'=> '1'
                                    ]);
        }
        return back()->with(['info' => 'Podarilo sa upraviť produkt.', 'type' => 'success']);
    }

    /* 
    Remove item from card(session('items'))
     */
    public function removeItem(Request $request)
    {

        $request->validate([
            'item_id' => 'required'
        ]);

        $session_item = session('items');

        /* find item in session items base on item_id */
        foreach($session_item as $index => $item)
        {
            if($item['id'] == "1")
            {
                unset($session_item[$index]);
            };
        };
        session()->put("items", $session_item);
        // Session::forget('items');
        
        Session::save();

        // Session::save();
        if($request->ajax())
        {
            return response()->json(['flash' => 'Podarilo sa vymazať produkt.',
                                     'status'=> '1'
                                    ]);
        }
        return back()->with(['info' => 'Podarilo sa vymazať produkt.', 'type' => 'success']);
    }

    /* 
    Remove all items from card
    Forget session 'items'
     */
    public function destroyCard(Request $request)
    {
        Session::forget('items');

        if($request->ajax())
        {
            return response()->json(['flash' => 'Vaš košík bol vymazaný.',
                                     'status'=> '1'
                                    ]);
        }
        return back()->with(['info' => 'Vaš košík bol vymazaný.', 'type' => 'danger']);
    }


}
