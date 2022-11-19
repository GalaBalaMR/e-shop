<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Charts\RandomChart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        $chart_items = $items->pluck('name' , 'price');
        $chart = new RandomChart;
        $chart->labels($chart_items->values());
        $chart->dataset('Cena produktu', 'line', $chart_items->keys());
        
        return view('admin.dashboard', compact('chart', 'items'));
    }
}
