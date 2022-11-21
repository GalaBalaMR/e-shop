<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirm;
use App\Models\Address;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CustomerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_orders = Order::where('user_id', Auth::id())->with('items');

        return view('frontEnd.order.index', compact('customer_orders'));
    }

    /**
     * Show the form for creating a new resource.
     * With compacted items_data from session
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'delivery' => 'required',
            'items'    => 'required'
        ]);

        // IFs FOR ADDRESS---------------------------------------------------------------------

        // if is set check for different address and address_id not exist, return view for make the address
        // else if is set check for different address and address_id exist, make variable address_id
        if(isset($request->change_address) && isset($request->address_id) == false )
        {
            return redirect()->route('address.createOrderAddress')->with(['delivery' => $request->delivery]);
        }elseif(isset($request->change_address) && isset($request->address_id))
        {
            $address_id = $request->address_id;
        }

        /* 
        if is set address and change address not exist, make address_id
        elseif address is not set and change not exist, redirect to address.makeShow
        */
        if(isset(auth()->user()->address) && isset($request->change_address) == false )
        {
            $address_id = auth()->user()->address->id;
        }elseif(isset(auth()->user()->address) == false && isset($request->change_address) == false )
        {
            return redirect()->route('address.createUserAddress');
        };

        // END ADDRESS IF-----------------------------------------------------


        // MAKE ORDER and SUBSTRACT ITEM---------------------------------------------------------
        $items = array();// assoc array which save in db with info about items
        $ids = array();//array of item's id for atachment(order+items)
        $full_price = 0;
        foreach($request->items as $key => $value)
        {
            // in json_decode true is for result as array
            $data = json_decode($value, true);

            // save data in items
            $items[$key] =   [   'id' => $data['item_id'],
                                'pcs' => $data['item_pcs'],
                                'price' => $data['item_price'],
                                'full_price' => $data['item_full_price']
                            ];
            
            $ids[] = $data['item_id'];
            
            $full_price += $data['item_full_price'];

            // for SUBSTRACT ITEM->storage_pcs-----------------------------------

            $item_storage = Item::find($data['item_id']);
            $item_storage_pcs = $item_storage->storage_pcs;//use it in if statement.
            $item_storage->storage_pcs -= $data['item_pcs'];
            // if is storage_pcs smaller than 0, dont make order, return back with message.
            if($item_storage->storage_pcs < 0)
            {
                return back()->with(['info' => 'Nemožno vytvoriť objednávku z dôvodu nedostatočných zásob produktu: '. $item_storage->name .'. Môžte objednať maximálne '. $item_storage_pcs .' kusov.', 'type' => 'danger']);
            }
            $item_storage->save();
            // end---------------------------------------------------------------

        };

        // For delivery type, count delivery price with full_price
        if($request->delivery === 'standard- 5€')
        {
            $full_price += 5;
            $order = Order::create([
                'items_data' => json_encode($items),
                'full_price' => $full_price,
                'user_id' => Auth::id(),
                'delivery' => 'standard- 5€'
            ]);
        }elseif($request->delivery == 'dhl- 3€')
        {
            $full_price += 3;
            $order = Order::create([
                'items_data' => json_encode($items),
                'full_price' => $full_price,
                'user_id' => Auth::id(),
                'delivery' => 'dhl- 3€'
            ]);
        }elseif($request->delivery == '123kurier- 3€')
        {
            $full_price += 3;
            $order = Order::create([
                'items_data' => json_encode($items),
                'full_price' => $full_price,
                'user_id' => Auth::id(),
                'delivery' => '123kurier- 3€'
            ]);
        }
        

        // Connect order with items
        $order->items()->sync($ids);

        // END MAKE ORDER-----------------------------------------------------------

        // CONNECT ORDER WITH ADDRESS AND SUBSTRACT ITEM----------------------------

        // for finding adrress and connect it with order, if it is other address than user's
        if(isset($request->change_address))
        {
            $address = Address::find($address_id);

            $address->order_id = $order->id;
            $address->save();

            $order->other_address = 'yes';
            $order->save();
        }

        if($request->ajax())
        {
            return response()->json(['flash' => 'Podarilo sa vytvoriť novú objednávku.',
                                     'status'=> '1'
                                    ]);
        }
        return back()->with(['info' => 'Podarilo sa vytvoriť novú objednávku.', 'type' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id)->with('items');

        return view('frontEnd.order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // $customer = User::find($id);
        // Mail::to( 'carnobusky@gmail.sk')->send( new OrderConfirm($customer));
        return 'hello';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $order = Order::find($id);

        // $order->delete();

        // if($request->ajax())
        // {
        //     return response()->json(['flash' => 'Podarilo sa .',
        //                              'status'=> '1'
        //                             ]);
        // }
        // return back()->with(['info' => 'Podarilo sa .', 'type' => 'success']);
    }
}
