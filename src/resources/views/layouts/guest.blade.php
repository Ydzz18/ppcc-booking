<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('logo-booking.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center bg-slate-100 px-4 py-8 sm:px-6">
            <div class="w-full max-w-md overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-200/70">
                <div class="border-b border-slate-100 px-6 pb-6 pt-8 sm:px-10">
                    <div class="flex justify-center">
                    <a href="/" aria-label="{{ config('app.name', 'PPCC Booking') }}">
                            <x-application-logo class="h-20 w-20 object-contain" />
                    </a>
                    </div>
                </div>

                <div class="px-6 py-8 sm:px-10">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
