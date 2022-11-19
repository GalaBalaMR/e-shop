@extends('admin.index')
@section('main')
<h1>Upraviť Subkategóriu</h1>
<form class="container" enctype="multipart/form-data" action="{{ route('admin.subcategories.update', $subcategory->id) }}" method="POST" >
    @csrf
    @method('PUT')
    {{-- name --}}
    <div class="mb-3">
      <label for="subcategory name" class="form-label">Názov subkategórie.</label>
      <input type="text" class="form-control" id="subcategory name" aria-describedby="názov subkategórie." name="name"
      value="{{ old('name', $subcategory->name) }}">
    </div>

    {{-- short description --}}
    <div class="mb-3">
        <label for="subcategory-description" class="form-label">Krátky opis.</label>
        <textarea class="form-control" name="description" id="subcategory-description">{{ old('description', $subcategory->description) }}
        </textarea>
    </div>
    <div class="mb-3">
        <img src="{{ Storage::url($subcategory->img) }}" class="img-thumbnail mx-auto d-block" alt="..." style="height: 60vh">
    </div>
    
    {{-- images --}}
    <div class="input-group mb-3">
        <input type="file" class="form-control" name="img" multiple>
    </div>

    {{-- select category --}}
    <select class="form-select mb-3" name="category_id" aria-label="Default select example">
        <option selected>Otvor a vyber</option>
        @forelse ($categories as $key => $value)

            {{-- if there is same category id as $value, make it visible, thats old category --}}
            @if ($value == $subcategory->category_id)
            <option value="{{ $value }}" class="bg-primary">{{ $key }}</option>
            @else
            <option value="{{ $value }}">{{ $key }}</option>
            @endif
        @empty
            <option selected>Nie je nič pridané</option>
        @endforelse
    </select>

    <button type="submit" class="btn btn-primary">Zmeniť</button>

</form>
    
@endsection