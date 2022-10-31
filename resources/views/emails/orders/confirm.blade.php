<?php use App\Models\Item;?>
@component('mail::message')
# Hello my dear {{ $order->user->name }};

Prijali sme od Teba objednávku číslo {{ $order->id }}.

Objednal si produkty:
<ul>
    @foreach (json_decode($order->items_data) as $item)
        <li> {{ Item::find($item->id)->name }}v cene {{ $item->price }} a počte {{ $item->pcs }} kusov. Celkova cena je {{ $item->full_price }}</li>
    @endforeach
</ul>

Za celú objednávku ste zaplatili:{{ $order->full_price }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
