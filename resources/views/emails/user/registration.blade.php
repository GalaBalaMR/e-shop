@component('mail::message')
# Vítame ťa!

Sme potešený, že ťa {{ $name }} môžme privítať v našich radoch!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
