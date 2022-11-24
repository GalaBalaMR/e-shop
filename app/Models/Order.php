<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Message;
use App\Mail\OrderConfirm;
use App\Observers\OrderObserver;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y');
    }

    public static function boot() {
        parent::boot();       
    }
}
