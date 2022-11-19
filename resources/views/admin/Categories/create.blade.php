@extends('admin.index')
@section('main')
<form class="container" enctype="multipart/form-data" action="{{ route('admin.categories.store') }}" method="POST" >
    @csrf

    {{-- name --}}
    <div class="mb-3">
      <label for="name" class="form-label">Názov categórie.</label>
      <input type="text" class="form-control" id="name" aria-describedby="názov categórie" name="name">
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
    <button type="submit" class="btn btn-primary">Vytvoriť</button>
</form>
    
@endsection