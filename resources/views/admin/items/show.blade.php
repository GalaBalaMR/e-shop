@extends('admin.index')
@section('main')
<section id="portfolio-details" class="portfolio-details">
<div class="container">

    <div class="row gy-4">

        <div id="carouselExampleControls" class="carousel slide col-sm-10 col-lg-7" data-bs-ride="carousel" style="max-height: 75vh">
            <div class="carousel-inner">
                @foreach(explode('|',$item->img) as $img)
                @if($loop->first)
                <div class="carousel-item active">
                  <img src="{{ Storage::url($img) }}" class="d-block w-100" alt="..." style="max-height: 75vh">
                </div>
                @continue
                @endif

                <div class="carousel-item">
                  <img src="{{ Storage::url($img) }}" class="d-block w-100" alt="..." style="max-height: 75vh">
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
          </div>
        

        <div class="col-lg-4">
        <div class="portfolio-info">
            <h3>Informácie o výrobku</h3>
            <ul>
            @if(isset($item->category))
                <li><strong>Kategória</strong> {{ $item->category->name }}</li>
            @elseif(isset($item->subCategory))
                <li><strong>Podkategória</strong> {{ $item->subCategory->name }}</li>
            @endif
            <li><strong>Na sklade:</strong> {{ $item->storage_pcs }}</li>
            <li><strong>Pridaný: </strong> {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</li>
            <li><strong>Cena:</strong> {{ $item->price }} €</li>
            <form action="{{ route('admin.items.destroy', $item->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Odstrániť</button>
            </form>
            
            {{-- <li>{{ $items_number }}</li> --}}
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


@section('links')

@endsection