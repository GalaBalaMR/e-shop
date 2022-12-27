@extends('layouts.guest')
@section('main')

    {{-- Shoping card --}}
    <section class="h-100 h-custom" id="card">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12">
                    <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-8">
                                    <div class="p-5">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                                            <h6 class="mb-0 text-muted">
                                                @if (isset($items_number) && $items_number != 0)
                                                    Počet položiek: <span class="card_pcs">{{ $items_number }}</span>.
                                                @else
                                                    Nepridal si žiadnu položku.
                                                @endif
                                            </h6>
                                        </div>
                                        <hr class="my-4">

                                        {{-- start item --}}
                                        @forelse($items_data as $item)
                                            <div class="row mb-4 d-flex justify-content-between align-items-center"
                                                id="card-item-{{ $item['item']['id'] }}">
                                                <div class="col-md-2 col-lg-2 col-xl-2">

                                                    {{-- foreach pictures and show just first --}}
                                                    @forelse(explode('|',$item['item']['img']) as $img)
                                                        @if ($loop->first)
                                                            <img src="{{ Storage::url($img) }}" class="img-fluid rounded-3"
                                                                alt="Cotton T-shirt">
                                                        @endif
                                                    @empty
                                                        <p>Bez obrázku</p>
                                                    @endforelse
                                                </div>
                                                <div class="col-md-3 col-lg-2 col-xl-2">
                                                    <h6 class="text-muted">item</h6>
                                                    <h6 class="text-black mb-0">{{ $item['item']['name'] }}</h6>
                                                </div>
                                                <form
                                                    class="card_item_update col-md-3 col-lg-2 col-xl-2 d-flex align-items-start flex-column"
                                                    action="{{ route('card.update') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="item_id" value="{{ $item['item']['id'] }}">
                                                    <div class="d-flex mb-1">
                                                        <button class="btn btn-link px-0"
                                                            onclick="this.parentNode.querySelector('input[type=number]').stepDown(); return false">
                                                            <i class="bi bi-dash"></i>
                                                        </button>

                                                        <input id="card-pcs-{{ $item['item']['id'] }}" min="0"
                                                            name="item_pcs" value="{{ $item['pcs'] }}" type="number"
                                                            class="form-control form-control-sm no-arrow" />

                                                        <button class="btn btn-link px-0"
                                                            onclick="this.parentNode.querySelector('input[type=number]').stepUp(); return false">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <button type="submit"
                                                        class="d-block mx-auto btn btn-warning rounded-pill p-1 py-0 text-light">
                                                        Zmeniť
                                                    </button>
                                                </form>
                                                <div class="col-md-3 col-lg-2 col-xl-2 p-0">
                                                    <h6 class="mb-0">Kus za € {{ $item['item']['price'] }}</h6>
                                                </div>
                                                <div class="col-md-3 col-lg-2 col-xl-2 p-0">
                                                    <h6 class="mb-0">Dokopy: € <span
                                                            class="card-item-price-{{ $item['item']['id'] }}">{{ $item['fullPrice'] }}</span>
                                                    </h6>
                                                </div>
                                                <div class="col-md-1 col-lg-1 col-xl-1">
                                                    <form action="{{ route('card.remove') }}" method="post"
                                                        class="card_item_delete">
                                                        @csrf
                                                        <input type="hidden" name="item_id"
                                                            value="{{ $item['item']['id'] }}">
                                                        <button type="submit" class=" btn link-danger decoration-none"><i
                                                                class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>

                                            <hr class="my-4">
                                            {{-- End item --}}
                                        @empty
                                            Nepridal si žiadny výrobok.
                                        @endforelse


                                        <div class="pt-5">
                                            <h6 class="mb-0"><a href="{{ route('item.index') }}" class="text-body"><i
                                                        class="fas fa-long-arrow-alt-left me-2"></i>Späť do obchodu</a></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 bg-grey">
                                    <div class="p-5">
                                        @auth
                                            <h3 class="fw-bold mb-5 mt-2 pt-1">Zhrnutie</h3>
                                            <hr class="my-4">
                                            <div class="d-flex justify-content-between mb-4">

                                                @if (isset($items_number))
                                                    <h5 class="text-uppercase">Počet v košíku: <span
                                                            class="card_pcs">{{ $items_number }}</span></h5>
                                                    <h5>€ <span class="card-full-price">{{ $full_price }}</span></h5>
                                                @else
                                                    <h5 class="text-uppercase">Nie je pridaná žiadna položka.</h5>
                                                    <h5>€ 0,00</h5>
                                                @endif
                                            </div>

                                            <h5 class="text-uppercase mb-3">Shipping</h5>

                                            {{-- form for create order --}}
                                            <form action="{{ route('orders.store') }}" method="post">
                                                <div class="mb-4 pb-2">
                                                    <select class="select" name="delivery">
                                                        @if (session()->has('delivery'))
                                                            <option value="{{ session()->get('delivery') }}">
                                                                {{ session()->get('delivery') }}</option>
                                                        @endif
                                                        <option value="standard- 5€">Standard-Delivery- €5.00</option>
                                                        <option value="dhl- 3€">DHL- €4.00</option>
                                                        <option value="123kurier- 3€">123Kuriér- €3.00</option>
                                                    </select>
                                                </div>

                                                <hr class="my-4">

                                                <div class="form-check">
                                                    {{-- if has session address id, check other address --}}
                                                    @if (session()->has('address_id'))
                                                        <input class="form-check-input" type="checkbox" name="change_address"
                                                            value="1" id="flexCheckDefault" checked>
                                                    @else
                                                        <input class="form-check-input" type="checkbox" name="change_address"
                                                            value="1" id="flexCheckDefault">
                                                    @endif
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Iná adresa
                                                    </label>
                                                </div>

                                                <div class="d-flex justify-content-between mb-5">
                                                    <h5 class="text-uppercase">Total price</h5>
                                                    <h5>€ <span class="card-full-price">{{ $full_price }}</span></h5>
                                                </div>

                                                @csrf
                                                @forelse ($items_data as $item)
                                                    <input type="hidden" name="items[]"
                                                        value="{{ json_encode(['item_id' => $item['item']['id'], 'item_pcs' => $item['pcs'], 'item_price' => $item['item']['price'], 'item_full_price' => $item['fullPrice']]) }}">

                                                @empty
                                                @endforelse

                                                @if (isset($address_id))
                                                    <input type="hidden" name="address_id" value="{{ $address_id }}">
                                                @endif
                                                <button type="submit" class="btn btn-dark btn-block btn-lg"
                                                    data-mdb-ripple-color="dark">Objednať</button>
                                            </form>

                                        @endauth

                                        @guest
                                            <h3 class="fw-bold mb-5 mt-2 pt-1">Pre pokračovanie musíš byť prihlásený, allebo
                                                registrovaný</h3>
                                            <hr class="my-4">
                                            <div class="card-body">
                                                <form method="POST" action="{{ route('register') }}">
                                                    @csrf

                                                    <div class="row mb-3">
                                                        <label for="name"
                                                            class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="name" type="text"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                name="name" value="{{ old('name') }}" required
                                                                autocomplete="name" autofocus>

                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="email"
                                                            class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="email" type="email"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                name="email" value="{{ old('email') }}" required
                                                                autocomplete="email">

                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="password"
                                                            class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="password" type="password"
                                                                class="form-control @error('password') is-invalid @enderror"
                                                                name="password" required autocomplete="new-password">

                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="password-confirm"
                                                            class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="password-confirm" type="password" class="form-control"
                                                                name="password_confirmation" required
                                                                autocomplete="new-password">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-0">
                                                        <div class="col-md-6 offset-md-4">
                                                            <button type="submit" class="btn btn-primary">
                                                                {{ __('Register') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-0 mt-4">
                                                        <div class="col-md-6 offset-md-4">
                                                            <a href="/sign-in/github" class="btn btn-secondary btn-block">
                                                                prihlásiť sa cez github!
                                                            </a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <a href="{{ route('login') }}">Prihlásiť sa</a>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
