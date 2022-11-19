@extends('admin.index')
@section('main')
<h1>Upraviť kategóriu</h1>
<form class="container" enctype="multipart/form-data" action="{{ route('admin.categories.update', $category->id) }}" method="POST" >
    @csrf
    @method('PUT')
    {{-- name --}}
    <div class="mb-3">
      <label for="item-name" class="form-label">Názov položky.</label>
      <input type="text" class="form-control" id="item-name" aria-describedby="názov položky" name="name"
      value="{{ old('name', $category->name) }}">
    </div>

    {{-- short description --}}
    <div class="mb-3">
        <label for="category-description" class="form-label">Krátky opis.</label>
        <textarea class="form-control" name="description" id="category-description">{{ old('description', $category->description) }}
        </textarea>
    </div>
    <div class="mb-3">
        <img src="{{ Storage::url($category->img) }}" class="img-fluid mx-auto d-block" alt="...">
    </div>
    
    {{-- images --}}
    <div class="input-group mb-3">
        <input type="file" class="form-control" name="img[]" multiple>
    </div>
    <button type="submit" class="btn btn-primary">Zmeniť</button>
</form>
    
@endsection