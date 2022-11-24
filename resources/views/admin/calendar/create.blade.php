@extends('admin.index')
@section('main')
    <form action="{{ route('admin.create_event') }}" method="post" class="m-1">
        @csrf

        <div class="mb-3">
            <label for="" class="form-label">Názov udalosti</label>
            <input type="text" class="form-control" name="title" placeholder="názov">
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Začiatok</label>
            <input type="datetime-local" class="form-control" name="start">
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Koniec</label>
            <input type="datetime-local" class="form-control" name="end">
        </div>

        <button type="submit" class="btn btn-primary">Vytvoriť</button>
    </form>

@endsection

@section('links')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.27.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
@endsection