<?php use App\Models\Item; ?>

@extends('layouts.guest')
@section('main')
    <!-- ======= Order Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        <div class="container">

            <div class="row gy-4 d-flex justify-content-center">

                <div class="col-lg-4">
                    <div class="portfolio-info">
                        <h3>Informácie o vašich objednávkach</h3>
                        @forelse ($customer_orders as $orders)
                            <ul>
                                <li><strong>Dátum: </strong>{{ $orders->created_at }}</li>
                                <li><strong>Mesto: </strong>
                                    {{ $orders->other_address === 'yes' ? $orders->address->FullAddress : auth()->user()->address->FullAddress }}
                                </li>
                                <li><strong>Produkty: </strong></li>
                                <li>
                                    <ul class="ms-4">
                                        @foreach (json_decode($orders->items_data) as $item)
                                        <li><strong>Názov produktu: </strong> {{ Item::find($item->id)->name }}</li>
                                        <li><strong>Cena za kus: </strong> {{ $item->price }} €</li>
                                        <li><strong>Počet kusov: </strong> {{ $item->pcs }} kusov.</li>
                                        <li><strong>Celková suma: </strong> {{ $item->full_price }} €.</li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><strong>Spôsob doručenia: </strong> {{ $orders->delivery }}</li>
                                <li><strong>Celková suma:</strong> {{ $orders->full_price }} €</li>
                            </ul>
                            <hr>
                        @empty
                            <p>Zatiaľ si nespravil žiadnu objednávku.</p>
                        @endforelse
                    </div>
                </div>

            </div>
    </section><!-- End Order Section -->
@endsection
