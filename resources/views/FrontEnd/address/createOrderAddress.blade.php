@extends('layouts.guest')
@section('main')

<h1>Náhradná adresa doručenia tvojej objednávky</h1>
<form method="POST" action="{{ route('address.storeOrderAddress') }}">
    @csrf
    <div class="mb-3">
      <label for="" class="form-label">PSČ:</label>
      <input type="text" name="post_code" pattern="[0-9]{5}" class="form-control" aria-describedby="psč">
      <div class="form-text">Zadajte psč bez medzier.</div>
    </div>
    <div class="mb-3">
      <label class="form-label">Mesto:</label>
      <input type="text" name="town" class="form-control" aria-describedby="town">
      <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
      <label class="form-label">Názov ulice:</label>
      <input type="text" name="street" class="form-control" aria-describedby="Street">
    </div>
    <div class="mb-3">
      <label class="form-label">Číslo ulice:</label>
      <input type="number" name="number" class="form-control" aria-describedby="číslo ulice">
    </div>

    {{-- send delivery for card, where with if() make it first option(remembering which kind delivery user choose) --}}
    <input type="hidden" name="delivery" value="{{ session()->get('delivery') }}">
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection