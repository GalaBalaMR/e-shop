<h1 class="text-center">{{ $slot }}</h1>
<section id="portfolio" class="portfolio">
<div class="row portfolio-container d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">

    @forelse($items as $item)
        @if( $item->category_id == null)
            <div class="col-lg-3 col-md-6 portfolio-item filter-sub-{{ $item->sub_category_id }}">
        @else
            <div class="col-lg-3 col-md-6 portfolio-item filter-cat-{{ $item->category_id }}">
        @endif

            <div class="portfolio-wrap mb-0">
                @foreach(explode('|',$item->img) as $img)
                @if($loop->first)
                <img src="{{ Storage::url($img) }}" class="img-fluid" alt="">
                @endif
                @endforeach
                <div class="portfolio-info">

                <h4 class="mb-0">{{ $item->name }}</h4>
                <p>
                    {{ $item->short_description }}
                </p>
                <div class="d-flex justify-content-between w-100 mb-2">
                    <blockquote class="text-warning mb-0">
                        Na sklade: {{ $item->storage_pcs }} ks
                    </blockquote>
                    <blockquote class="text-warning mb-0 me-3">
                        {{ $item->price }} €
                    </blockquote>
                </div>
                <div class="portfolio-links d-flex justify-content-around w-100">
                    
                    {{-- foreach pictures and show just first --}}
                    @foreach(explode('|',$item->img) as $img)
                        @if($loop->first)
                            <a href="{{ Storage::url($img) }}" data-gallery="portfolioGallery" class="portfolio-lightbox" title="{{ $item->name }}"><i class="bx bx-plus"></i></a>
                        @endif
                    @endforeach

                    <a href="{{ route('item.show', ['id' => $item->id]) }}" title="More Details"><i class="bx bx-link"></i></a>

                    <form action="{{ route('card.store') }}" method="post" class="d-flex justify-content-center pb-1">
                        @csrf
                        <input type="number" name="item_pcs" class="me-3" id="" min="1" max="{{ $item->storage_pcs }}">
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <input type="hidden" name="storage_pcs" value="{{ $item->storage_pcs }}">
                        <button type="submit" class="btn btn-warning rounded-pill">Kúpiť</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    @empty
        <p>Na ponuke pracujeme!</p>
    @endforelse
    

    
</div>
</section>
    
