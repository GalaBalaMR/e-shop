@extends('layouts.guest')
@section('main')

<!-- ======= User Section ======= -->
<section id="portfolio-details" class="portfolio-details">
    <div class="container">

    <div class="row gy-4 d-flex justify-content-center">

        <div class="col-lg-4">
        <div class="portfolio-info">
            <h3>Informácie o používateľovi</h3>
            <ul>
                <li><strong>Meno: </strong>{{ $user->name }}</li>
                <li><strong>Email: </strong> {{ $user->email }}</li>
                <li><strong>Číslo:</strong> {{ $user->phone === 0 ? $user->phone : 'Nie je zadané číslo' }}</li>
            </ul>
        </div>
        </div>

    </div>
</section><!-- End User Section -->
@endsection