<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'short_description', 'long_description', 'storage_pcs', 'price','img'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function order()
    {
        return $this->belongsToMany(Order::class);
    }

    // for decimals in price
    public function getPriceAttribute($price)
    {
        return number_format($price, 2);
    }

    public static function boot() {
        parent::boot();

        // Message for admin, about storage_pcs is under 10 pcs
        static::updated(function($item) {
            if($item->storage_pcs < 10)
            Message::create([
                'name' => 'Nedostatok produktu '. $item->name,
                'about' => 'item',
                'about_id' => $item->id,
                'content' => 'Zásoby produktu '. $item->name .' klesli pod 10 kusov. Aktuálne zásoby sú '.          $item->storage_pcs .'.'
            ]);
        });        
    }
}
