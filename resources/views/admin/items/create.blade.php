@extends('admin.index')
@section('main')
<form class="container" enctype="multipart/form-data" action="{{ route('admin.items.store') }}" method="POST" >
    @csrf

    {{-- name --}}
    <div class="mb-3">
      <label for="item-name" class="form-label">Názov položky.</label>
      <input type="text" class="form-control" id="item-name" aria-describedby="názov položky" name="name">
    </div>

    {{-- short description --}}
    <div class="mb-3">
      <label for="item-short_description" class="form-label">Krátky opis.</label>
      <textarea class="form-control" name="short_description" id="item-short_description"></textarea>
    </div>

    {{-- long description --}}
    <div class="mb-3">
      <label for="item-long_description" class="form-label">Dlhý opis.</label>
      <textarea class="form-control" name="long_description" id="item-long_description"></textarea>
    </div>

    {{-- price --}}
    <div class="mb-3">
      <label for="item-price" class="form-label">Cena položky.</label>
      <input type="number" class="form-control" id="item-price" aria-describedby="názov položky" name="price">
    </div>

    {{-- pieces in the store --}}
    <div class="mb-3">
      <label for="item-numbers" class="form-label">Počet kusov položky.</label>
      <input type="number" class="form-control" id="item-numbers" aria-describedby="názov položky" name="numbers">
    </div>

    {{-- images --}}
    <div class="input-group mb-3">
        <input type="file" class="form-control" name="img[]" multiple>
    </div>
    <button type="submit" class="btn btn-primary">Vytvoriť</button>
</form>
    
@endsection