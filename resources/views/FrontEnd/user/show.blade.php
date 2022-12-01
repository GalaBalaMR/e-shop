@extends('layouts.guest')
@section('main')

<!-- ======= Portfolio Details Section ======= -->
<section id="portfolio-details" class="portfolio-details">
    <div class="container">

    <div class="row gy-4">

        <div class="col-lg-4">
        <div class="portfolio-info">
            <h3>Informácie o používateľovi</h3>
            <ul>
                <li><strong>Meno: </strong>{{ $user->name }}</li>
                <li><strong>Email: </strong>: {{ $user->email }}</li>
                <li><strong>Číslo:</strong>: {{ $user->phone }}</li>
                <li>
                </li>
            </ul>
        </div>
        </div>

    </div>
</section><!-- End Portfolio Details Section -->
@endsection