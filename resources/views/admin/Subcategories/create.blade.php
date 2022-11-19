@extends('admin.index')
@section('main')
<form class="container" enctype="multipart/form-data" action="{{ route('admin.subcategories.store') }}" method="POST" >
    @csrf

    {{-- name --}}
    <div class="mb-3">
      <label for="name" class="form-label">Názov Subkategórie.</label>
      <input type="text" class="form-control" id="name" aria-describedby="názov subkategórie" name="name">
    </div>

    {{-- short description --}}
    <div class="mb-3">
      <label for="description" class="form-label">Opis.</label>
      <textarea class="form-control" name="description" id="description"></textarea>
    </div>
    {{-- images --}}
    <div class="input-group mb-3">
        <input type="file" class="form-control" name="img" multiple>
    </div>

    <select class="form-select mb-3" name="category_id" aria-label="Default select example">
      <option selected>Otvor a vyber</option>
      @forelse ($categories as $key => $value)
      
        <option value="{{ $value }}">{{ $key }}</option>
      @empty
      <option selected>Nie je nič pridané</option>
      @endforelse
    </select>

    
    <button type="submit" class="btn btn-primary">Vytvoriť</button>
</form>
    
@endsection