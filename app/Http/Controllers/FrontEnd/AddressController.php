<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    /* 
        Return view with form for order address
    */
    public function createOrderAddress()
    {
        return view('FrontEnd.address.createOrderAddress');
    }

    /* 
        Save other address for order
    */
    public function storeOrderAddress(StoreAddressRequest $request)
    {
        $request->validated();

        $address = Address::create([
            'post_code' => $request->post_code,
            'town' => $request->town,
            'street' => $request->street,
            'number' => $request->number,
            'order_id' => 4
        ]);

        // send it to card show
        $address_id = $address->id;

        
        // send delivery for card, where with if() make it first option(remembering which kind delivery user choose)
        return redirect()->route('card.show')->with(['address_id' => $address_id , 'delivery' => $request->delivery]);
    }

    /* 
        Return view with form for user address
    */
    public function createUserAddress()
    {
        return view('FrontEnd.address.createUserAddress');
    }

    /* 
        Save new address for user
    */
    public function storeUserAddress(StoreAddressRequest $request)
    {
        $request->validated();

        $address = Address::create([
            'post_code' => $request->post_code,
            'town' => $request->town,
            'street' => $request->street,
            'number' => $request->number,
            'user_id' => auth()->user()->id
        ]);

        // send it to card show
        $address_id = $address->id;

        // send delivery for card, where with if() make it first option(remembering which kind delivery user choose)
        return redirect()->route('card.show')->with(['address_id' => $address_id , 'delivery' => $request->delivery]);
    }
}
