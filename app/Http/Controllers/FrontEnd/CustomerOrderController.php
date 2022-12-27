<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Mail\OrderConfirm;
use App\Events\OrderCreated;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreOrderRequest;

class CustomerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_orders = Order::where('user_id', auth()->user()->id)->with('address')->get();

        return view('frontEnd.order.index', compact('customer_orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $request->validated();

        // IFs FOR ADDRESS---------------------------------------------------------------------

        // if is set check for different address and address_id not exist, return view for make the address
        // else if is set check for different address and address_id exist, make variable address_id
        if (isset($request->change_address) && isset($request->address_id) == false) {
            return redirect()->route('address.createOrderAddress')->with(['delivery' => $request->delivery]);
        } elseif (isset($request->change_address) && isset($request->address_id)) {
            $address_id = $request->address_id;
        }

        /* 
        if is set address and change address not exist, make address_id
        elseif address is not set and change not exist, redirect to address.makeShow
        */
        if (isset(auth()->user()->address) && isset($request->change_address) == false) {
            $address_id = auth()->user()->address->id;
        } elseif (isset(auth()->user()->address) == false && isset($request->change_address) == false) {
            return redirect()->route('address.createUserAddress');
        };

        // END ADDRESS IF-----------------------------------------------------


        // MAKE ORDER and SUBSTRACT ITEM---------------------------------------------------------
        $items = array(); // assoc array which save in db with info about items
        $ids = array(); //array of item's id for atachment(order+items)
        $full_price = 0;
        foreach ($request->items as $key => $value) {
            // in json_decode true is for result as array
            $data = json_decode($value, true);

            // save data in items
            $items[$key] =   [
                'id' => $data['item_id'],
                'pcs' => $data['item_pcs'],
                'price' => $data['item_price'],
                'full_price' => $data['item_full_price']
            ];

            $ids[] = $data['item_id'];

            $full_price += $data['item_full_price'];

            // for SUBSTRACT ITEM->storage_pcs-----------------------------------

            $item_storage = Item::find($data['item_id']);
            $item_storage_pcs = $item_storage->storage_pcs; //use it in if statement.
            $item_storage->storage_pcs -= $data['item_pcs'];
            // if is storage_pcs smaller than 0, dont make order, return back with message.
            if ($item_storage->storage_pcs < 0) {
                return back()->with(['info' => 'Nemožno vytvoriť objednávku z dôvodu nedostatočných zásob produktu: ' . $item_storage->name . '. Môžte objednať maximálne ' . $item_storage_pcs . ' kusov.', 'type' => 'danger']);
            }
            $item_storage->save();
            // end---------------------------------------------------------------

        };

        // For delivery type, count delivery price with full_price
        if ($request->delivery === 'standard- 5€') {
            $full_price += 5;
            $order = Order::create([
                'items_data' => json_encode($items),
                'full_price' => $full_price,
                'user_id' => Auth::id(),
                'delivery' => 'standard- 5€'
            ]);
        } elseif ($request->delivery == 'dhl- 3€') {
            $full_price += 3;
            $order = Order::create([
                'items_data' => json_encode($items),
                'full_price' => $full_price,
                'user_id' => Auth::id(),
                'delivery' => 'dhl- 3€'
            ]);
        } elseif ($request->delivery == '123kurier- 3€') {
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
        if (isset($request->change_address)) {
            $address = Address::find($address_id);

            $address->order_id = $order->id;
            $address->save();

            $order->other_address = 'yes';
            $order->save();
        }

        // Send mail to customer about success order
        Mail::to($order->user->email)->send(new OrderConfirm($order));

        // Send message to admin about order, forget session items and items_number
        event(new OrderCreated($order));

        if ($request->ajax()) {
            return response()->json([
                'flash' => 'Podarilo sa vytvoriť novú objednávku.',
                'status' => '1'
            ]);
        }
        return redirect()->to('/card/show#card')->with(['info' => 'Podarilo sa vytvoriť novú objednávku.', 'type' => 'success']);
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
