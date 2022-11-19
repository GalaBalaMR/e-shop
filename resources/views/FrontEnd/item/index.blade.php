@extends('layouts.guest')
@section('main')
<!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
        <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>Portfolio</h2>
            <p>Check our Portfolio</p>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
                <li data-filter="*" class="filter-active">All</li>
                
                @forelse($mix as $mix)

                    {{-- If category has a subcategory, make dropdown --}}
                    @if($mix->subCategories->count())
                        <div class="dropup d-inline">
                        <button class="btn  dropdown-toggle dropup" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $mix->name }}
                        </button>
                        <ul class="dropdown-menu ">
                            {{-- Make li in dropdown for all item in category --}}
                            <li data-filter=".filter-cat-{{ $mix->id }}">Nezaradené</li>

                            {{-- If has subcategory, make dropdown li --}}
                            @foreach($mix->subCategories as $sub)
                                <li data-filter=".filter-sub-{{ $sub->id }}">{{ $sub->name }}</li>
                            @endforeach
                        </ul>
                        </div>
                    @else
                        <li data-filter=".filter-cat-{{ $mix->id }}">{{ $mix->name }}</li>
                    @endif
                @empty
                <p>nič</p>
                @endforelse
            </ul>
            </div>
        </div>

        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

            @forelse($items as $item)
                @if( $item->category_id == null)
                    <div class="col-lg-4 col-md-6 portfolio-item filter-sub-{{ $item->sub_category_id }}">
                @else
                    <div class="col-lg-4 col-md-6 portfolio-item filter-cat-{{ $item->category_id }}">
                @endif

                    <div class="portfolio-wrap">
                        @foreach(explode('|',$item->img) as $img)
                        @if($loop->first)
                        <img src="{{ Storage::url($img) }}" class="img-fluid" alt="">
                        @endif
                        @endforeach
                        <div class="portfolio-info">
                        <h4>{{ $item->name }}</h4>
                        <p>{{ $item->short_description }}</p>
                        <div class="portfolio-links">
                            
                            {{-- foreach pictures and show just first --}}
                            @foreach(explode('|',$item->img) as $img)
                                @if($loop->first)
                                    <a href="{{ Storage::url($img) }}" data-gallery="portfolioGallery" class="portfolio-lightbox" title="{{ $item->name }}"><i class="bx bx-plus"></i></a>
                                @endif
                            @endforeach

                            <a href="{{ route('item.show', ['id' => $item->id]) }}" title="More Details"><i class="bx bx-link"></i></a>
                            <form action="{{ route('card.store') }}" method="post">
                                @csrf
                                <input type="number" name="item_pcs" id="" min="0">
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <button type="submit" class="btn btn-warning rounded-pill">Pridať do košíku</button>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Eshop je prázdny.</p>
            @endforelse
            

            
        </div>

        </div>
    </section><!-- End Portfolio Section -->
    
@endsection