<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Event;
use App\Models\Order;
use App\Models\Message;
use App\Charts\RandomChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
// use LaravelFullCalendar\Event;

class AdminController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::where('error', 'yes')->get();

        $orders = Order::all();
        $chart_orders = $orders->pluck('created_at' , 'full_price');
        $chart = new RandomChart;
        $chart->labels($chart_orders->values());
        $chart->dataset('Cena produktu', 'line', $chart_orders->keys());
      
        return view('admin.dashboard', compact('chart', 'orders', 'messages'));
    }
}
