<?php

namespace App\Http\Controllers\FrontEnd;


use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
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
        $items_data = array();
        $full_price = 0;
        $items_number = 0;
        
        if(session()->has('items'))
        {

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

                $full_price +=  $item_price;
    
            };
            // Session::forget('items');

            // for count session items
            foreach(session('items') as $item)
            {
                $items_number+= 1;
            }
        }

        /* 
            when make new address, send new address id to view card,
            where with isset can sent it to order.create
        */
        if(session()->has('address_id'))
        {
            $address_id = session()->get('address_id');
            return view('FrontEnd.card.show', compact('items_data', 'full_price', 'items_number', 'address_id')); 
        }

        return view('FrontEnd.card.show', compact('items_data', 'full_price', 'items_number'));

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

        $item_id = $request->item_id;
        $item_pcs = $request->item_pcs;

        Session::push('items' , [
            'id' => $item_id,
            'pcs' => 0,
        ]);

        $session_items = session('items');
        $items_number = 0;

        // if session exist, foreach it and compare its id, with request
        // for not having duplicate in session, if is there some, count it pcs with request pcs and delete it
        if(session()->has('items'))
        {
            foreach($session_items as $index => $item)
            {
                if($item['id'] == $item_id)
                {
                    // if is ids same, count item pcs form old session and from request
                    $item_pcs += $item['pcs'];
                    // delete old item and make new item and push it in arr
                    unset($session_items[$index]);

                }
            } 
            
        }

        // after control, if is not duplicate, we can add request to session
        array_push($session_items , [
            'id' => $item_id,
            'pcs' => $item_pcs,
        ]);

        // push $session_item in the session
        session()->put("items", $session_items);

        Session::save();
        
        // count  session items
        foreach($session_items as $item)
        {
            $items_number+= 1;
        }
        
        // after add session just remove and add new session with actual number 
        Session::forget('items_number');
        Session::put('items_number' , $items_number);

        // end this function
        if($request->ajax())
        {
            return response()->json(['flash' => 'Podarilo sa pridať produkt.',
                                     'status'=> '1'
                                    ]);
        };

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

        $session_items = session('items');

        /* find item in session items base on item_id */
        foreach($session_items as $index => $item)
        {
            if($item['id'] == $request->item_id)
            {
                unset($session_items[$index]);
            };
        };
        session()->put("items", $session_items);
        // Session::forget('items');
        
        Session::save();
        // count  session items
        $items_number = 0;
        foreach($session_items as $item)
        {
            $items_number+= 1;
        }
        
        // after add session just remove and add new session with actual number 
        Session::forget('items_number');
        Session::put('items_number' , $items_number);

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
