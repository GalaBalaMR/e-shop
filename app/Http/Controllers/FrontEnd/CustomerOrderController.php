<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirm;
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

        // Session::push('items', [
        //     'id' => '6',
        //     'pcs' => '6',
        // ]);
        // Session::save();

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
        };

        $order = Order::create([
            'items_data' => json_encode($items),
            'full_price' => $full_price,
            'user_id' => Auth::id()
        ]);

        // Connect order with items
        $order->items()->sync($ids);

        // Send mail to customer about success order
        Mail::to( $order->user->email)->send( new OrderConfirm($order));

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
