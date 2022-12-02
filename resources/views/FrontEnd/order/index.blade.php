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
                <li><strong>Mesto: </strong> {{ $orders->other_address === 'yes' ? $orders->address->FullAddress : auth()->user()->address->FullAddress }}</li>
                <li><strong>Ulica: </strong> {{ $orders->other_address === 'yes' ? $orders->address->FullAddress : auth()->user()->address->FullAddress }}</li>
                {{-- <li><strong>Adresa: </strong> {{ $user->phone === 0 ? $user->phone : 'Nie je zadané číslo'  }}</li> --}}
                <li>
                    <strong>Položky: </strong>
                    <ol>
                @foreach ($orders->items as $item)
                    <li class="ms-2">{{ $item->name }}</li>
                @endforeach
                    </ol>
                </li>
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