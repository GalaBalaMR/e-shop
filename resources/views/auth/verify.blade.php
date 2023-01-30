@extends('layouts.guest')

@section('main')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Overenie tvojej emailovej adresy') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Pred pokračovaním, prosím over svoj email.') }}
                    {{ __('Ak si potvrdzujúci email nedostal, ') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('klikni sem pre odoslanie ďalšieho.') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
