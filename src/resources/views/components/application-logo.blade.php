<img
    src="{{ asset('logo-booking.png') }}"
    data-light-logo="{{ asset('logo-booking.png') }}"
    data-dark-logo="{{ asset('logo-w.png') }}"
    alt="{{ config('app.name', 'PPCC Booking') }}"
    onerror="this.onerror=null;this.src='{{ asset('logo-booking.png') }}';"
    {{ $attributes->merge(['class' => 'app-logo']) }}
>
