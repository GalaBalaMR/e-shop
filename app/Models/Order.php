<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirm;



class Order extends Model
{
    use HasFactory;

    protected $fillable = ['items_data', 'full_price', 'user_id', 'delivery']; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public static function boot() {
        parent::boot();

        // message for admin, about new order
        static::created(function($order) {
            Message::create([
                'name' => 'Nová objednávka-',
                'about' => 'order',
                'about_id' => $order->id,
                'content' => 'Zákazník '. auth()->user()->name .' si objednal tovar.'
            ]);

            // Send mail to customer about success order
            Mail::to( $order->user->email)->send( new OrderConfirm($order));
        });        
    }
}
