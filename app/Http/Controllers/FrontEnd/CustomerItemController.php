<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class CustomerItemController extends Controller
{
    public function index()
    {
        $mix = Category::with(['subCategories'])->get();
        $items = Item::with('reviews')->get();


        // foreach if item has reviews and if user evaluated that item
        // if it is not evaluated from actual user, set evaluated false, and in blade show form for evaluating
        foreach ($items as $item) {
            if ($item->reviews()->exists()) {
                $stars = [];
                $evaluated = false;
                foreach ($item->reviews as $review) {
                    if (auth()->check()) {
                        if (auth()->user()->id === $review->user_id) {
                            $evaluated = true;
                        }
                    }
                    $stars[] = $review->stars;
                }
                $stars = intval(array_sum($stars) / count($stars));
                $item->stars = $stars;
                $item->evaluated = $evaluated;
            }
        }
        // return dd($items);



        return view('FrontEnd.item.index', compact('mix', 'items'));
        // return dd($blbost->id);
    }

    public function show($id)
    {
        $item = Item::with('category', 'subCategory', 'reviews')->find($id);

        if ($item->reviews()->exists()) {
            $stars = [];
            $evaluated = false;
            foreach ($item->reviews as $review) {
                if (auth()->check()) {
                    if (auth()->user()->id === $review->user_id) {
                        $evaluated = true;
                    }
                }
                $stars[] = $review->stars;
            }
            $stars = intval(array_sum($stars) / count($stars));
            $item->stars = $stars;
            $item->evaluated = $evaluated;
        }
        return view('FrontEnd.item.show', compact('item'));
    }
}
