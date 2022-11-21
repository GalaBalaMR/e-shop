<?php use App\Models\Item;?>
@component('mail::message')
# Hello my dear {{ $order->user->name }};

Prijali sme od Teba objednávku číslo {{ $order->id }}.

Objednal si produkty:
<ul>
    @foreach (json_decode($order->items_data) as $item)
        <li> {{ Item::find($item->id)->name }}v cene {{ $item->price }} € a počte {{ $item->pcs }} kusov. Celkova cena je {{ $item->full_price }} €.</li>
    @endforeach
    <li>Spôsob doručenia je {{ $order->delivery }}</li>
</ul>
<hr>
<h2>Na adresu:</h2>
<ul>
@if($order->address()->exists())
<li>{{ $order->address->post_code }}</li>
<li>{{ $order->address->town }}</li>
<li>{{ $order->address->street }}</li>
<li>{{ $order->address->number }}</li>
@else
<li>{{ auth()->user()->address->post_code }}</li>
<li>{{ auth()->user()->address->town }}</li>
<li>{{ auth()->user()->address->street }}</li>
<li>{{ auth()->user()->address->number }}</li>
@endif
</ul>

Za celú objednávku ste zaplatili: {{ $order->full_price }} €.

Vďaka,<br>
{{ config('app.name') }}
@endcomponent
