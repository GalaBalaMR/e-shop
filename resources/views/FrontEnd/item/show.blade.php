 @extends('layouts.guest')
 @section('main')
 <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            <h2>Portfolio Details</h2>
            <ol>
            <li><a href="index.html">Home</a></li>
            <li>Portfolio Details</li>
            </ol>
        </div>

        </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        <div class="container">

        <div class="row gy-4">

            <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
                <div class="swiper-wrapper align-items-center">

                <div class="swiper-slide">
                    <img src="assets/img/portfolio/portfolio-1.jpg" alt="">
                </div>

                <div class="swiper-slide">
                    <img src="assets/img/portfolio/portfolio-2.jpg" alt="">
                </div>

                <div class="swiper-slide">
                    <img src="assets/img/portfolio/portfolio-3.jpg" alt="">
                </div>

                </div>
                <div class="swiper-pagination"></div>
            </div>
            </div>

            <div class="col-lg-4">
            <div class="portfolio-info">
                <h3>Informácie o výrobku</h3>
                <ul>
                @if(isset($item->category))
                    <li><strong>Kategória</strong>: {{ $item->category->name }}</li>
                @elseif(isset($item->subCategory))
                    <li><strong>Podkategória</strong>: {{ $item->subCategory->name }}</li>
                @endif
                <li><strong>Na sklade:</strong>: {{ $item->numbers }}</li>
                <li><strong>Pridaný: </strong>: {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</li>
                <li><strong>Cena:</strong>: {{ $item->price }}</li>
                </ul>
            </div>
            <div class="portfolio-description">
                <h2>{{ $item->name }}</h2>
                <p>
                    {{ $item->short_description }}
                </p>
                <p>
                    {{ $item->long_description }}
                </p>
            </div>
            </div>

        </div>

        </div>
    </section><!-- End Portfolio Details Section -->

@endsection