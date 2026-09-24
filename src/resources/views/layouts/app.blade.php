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
    <body class="font-sans antialiased bg-gray-100 min-h-screen md:h-screen md:overflow-hidden">
        <div class="min-h-screen bg-gray-100 flex flex-col md:h-full md:flex-row md:overflow-hidden">
            @include('layouts.navigation')

            <div class="min-w-0 flex-1 md:flex md:h-full md:min-h-0 md:flex-col">
                @isset($header)
                    <header class="w-full shrink-0 border-b border-gray-200 bg-white md:sticky md:top-0 md:z-20 md:flex md:h-20 md:items-center">
                        <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 md:px-8 md:py-0">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="min-h-screen overflow-y-auto md:min-h-0 md:flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
