<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['post_code','town','street','number', 'user_id', 'order_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(User::class);
    }

    public function getTownAttribute($value)
    {
        return ucfirst($value);
    }

    public function getStreetAttribute($value)
    {
        return ucfirst($value);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->town}, {$this->street}, {$this->number}";
    }

}
