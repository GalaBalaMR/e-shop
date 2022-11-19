<?php

namespace App\Models;

use App\Models\SubCategory;
use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'img'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
    
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
