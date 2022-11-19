@extends('admin.index')
@section('main')
<h1>Zmeniť položku</h1>
<form class="container" enctype="multipart/form-data" action="{{ route('admin.items.update', $item->id) }}" method="POST" >
    @csrf
    @method('PUT')
    {{-- name --}}
    <div class="mb-3">
      <label for="item-name" class="form-label">Názov položky.</label>
      <input type="text" class="form-control" id="item-name" aria-describedby="názov položky" name="name"
      value="{{ old('name', $item->name) }}">
    </div>

    {{-- short description --}}
    <div class="mb-3">
        <label for="item-short_description" class="form-label">Krátky opis.</label>
        <textarea class="form-control" name="short_description" id="item-short_description">{{ old('short_description', $item->short_description) }}
        </textarea>
    </div>

    {{-- long description --}}
    <div class="mb-3">
        <label for="item-long_description" class="form-label">Dlhý opis.</label>
        <textarea class="form-control" name="long_description" id="item-long_description">{{ old('long_description', $item->long_description) }}
        </textarea>
    </div>

    {{-- price --}}
    <div class="mb-3">
      <label for="item-price" class="form-label">Cena položky.</label>
      <input type="number" class="form-control" id="item-price" aria-describedby="názov položky" name="price" 
      value="{{ old('price', $item->price) }}">
    </div>

    {{-- pieces in the store --}}
    <div class="mb-3">
      <label for="item-numbers" class="form-label">Počet kusov položky.</label>
      <input type="number" class="form-control" id="item-numbers" aria-describedby="názov položky" name="numbers"
      value="{{ old('numbers', $item->numbers) }}">
    </div>

    <div id="carouselExampleControls" class="carousel slide w-75 mx-auto mb-3" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach (explode("|", $item->img) as $item)
                @if ($loop->first)
                    <div class="carousel-item active">
                        <img src="{{ Storage::url($item) }}" class="d-block w-100" alt="..." style="height: 60vh">
                    </div>
                    @continue
                @endif
                <div class="carousel-item">
                    <img src="{{ Storage::url($item) }}" class="d-block w-100" alt="..." style="height: 60vh">
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

    {{-- images --}}
    <div class="input-group mb-3">
        <input type="file" class="form-control" name="img[]" multiple>
    </div>
    <button type="submit" class="btn btn-primary">Zmeniť</button>
</form>
    
@endsection