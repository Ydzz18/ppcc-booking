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

                <div class="px-6 py-4 sm:px-10">
                    <div class="mb-4 flex justify-end">
                        <button type="button" data-theme-toggle aria-label="Toggle theme" class="inline-flex h-9 w-9 items-center justify-center rounded-md text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-500">
                            <svg data-theme-icon class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path class="dark:hidden" stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.5m0 13V21m9-9h-2.5M5.5 12H3m15.5 6.5-1.8-1.8M8.3 8.3 6.5 6.5m0 11 1.8-1.8m7.4-7.4 1.8-1.8M12 7.5A4.5 4.5 0 1 1 7.5 12 4.5 4.5 0 0 1 12 7.5Z" />
                                <path class="hidden dark:block" stroke-linecap="round" stroke-linejoin="round" d="M21 12.8A8.8 8.8 0 0 1 11.2 3a9 9 0 1 0 9.8 9.8Z" />
                            </svg>
                        </button>
                    </div>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
