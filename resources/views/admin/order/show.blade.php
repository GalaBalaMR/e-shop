<?php use App\Models\Item; ?>

@extends('admin.index')
@section('main')
    <section id="portfolio-details" class="portfolio-details">
        <div class="container">

            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="portfolio-info">
                        <h3>Informácie o objednávke</h3>
                        <ul>
                            <li><strong>Meno zákazníka: </strong> {{ $order->user->name }}</li>
                            <li><strong>Registrovaný od: </strong> {{ $order->user->created_at }}</li>
                            <li><strong>Dátum objednávky: </strong> {{ $order->created_at }}</li>
                            <li><strong>Adresa doručenia: </strong></li>
                            <ul>
                                <li><strong>PSČ: </strong>{{ $address->post_code }}</li>
                                <li><strong>Mesto: </strong>{{ $address->town }}</li>
                                <li><strong>Ulica: </strong>{{ $address->street }}</li>
                                <li><strong>Číslo ulice:</strong>{{ $address->number }}</li>
                            </ul>
                            <li><strong>Objednané produkty</strong></li>
                            <ul>
                                @foreach (json_decode($order->items_data) as $item)
                                    <li><strong>Názov: </strong> <a class="link-dark" href="{{ route('admin.items.show', $item->id) }}">{{ Item::find($item->id)->name }}</a></li>
                                    <li><strong>Cena za ks:</strong> {{ $item->price }} </li>
                                    <li><strong>Počet: </strong> {{ $item->pcs }} kusov</li>
                                    <li><strong>Celková cena za produkt: </strong> {{ $item->full_price }} €</li>
                                    <hr>
                                @endforeach
                            </ul>
                            <li><strong>Celková suma objednávky:</strong> {{ $order->full_price }}€</li>
                        </ul>
                    </div>
                    <div class="portfolio-description">

                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Portfolio Details Section -->
@endsection
