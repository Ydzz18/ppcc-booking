<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        @include('layouts.theme-init')

        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-900 transition-colors duration-200 min-h-screen lg:h-screen lg:overflow-hidden dark:bg-slate-950 dark:text-slate-100">
        <div class="app-shell min-h-screen bg-gray-100 flex flex-col lg:h-full lg:flex-row lg:overflow-hidden dark:bg-slate-950" x-data="liveNotifications(@js($notificationCount ?? 0), @js(($headerNotifications ?? collect())->map(fn ($notification) => ['id' => $notification->id, 'task_name' => $notification->task?->task_name ?? __('Booking'), 'client_name' => $notification->client?->client_name ?? __('Unknown client'), 'status' => ucfirst($notification->submission_status ?: 'pending'), 'url' => route('bookings.edit', $notification)])), @js(route('notifications.live')), @js(route('notifications.viewed')))" x-init="start()">
            @include('layouts.navigation')

            <div class="min-w-0 flex-1 lg:flex lg:h-full lg:min-h-0 lg:flex-col">
                @isset($header)
                    <header class="w-full shrink-0 border-b border-gray-200 bg-white lg:sticky lg:top-0 lg:z-20 lg:flex lg:h-20 lg:items-center dark:border-slate-800 dark:bg-slate-900">
                        <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-4 px-4 py-6 sm:px-6 lg:px-8 lg:py-0">
                            <div class="min-w-0 flex-1">
                                {{ $header }}
                            </div>

                            <div class="app-header-actions flex shrink-0 items-center gap-2">
                                <div class="relative" @click.outside="notificationsOpen = false" @keydown.escape.window="notificationsOpen = false">
                                    <button type="button" x-on:click="notificationsOpen = !notificationsOpen; if (notificationsOpen) markNotificationsViewed()" :aria-expanded="notificationsOpen.toString()" aria-controls="header-notifications" class="relative inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-300 bg-white text-slate-600 transition hover:border-yellow-400/50 hover:bg-gray-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-yellow-400/50 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-300 dark:hover:bg-slate-900/70 dark:hover:text-yellow-300" aria-label="{{ __('Notifications') }}" title="{{ __('Notifications') }}">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75a4.5 4.5 0 0 1 4.5 4.5v2.2c0 .93.25 1.84.71 2.62l.75 1.31H6.04l.75-1.31A4.91 4.91 0 0 0 7.5 10.45V8.25A4.5 4.5 0 0 1 12 3.75ZM9.75 18.25a2.25 2.25 0 0 0 4.5 0"/>
                                        </svg>
                                        <span x-show="notificationCount > 0" x-cloak x-text="notificationCount > 99 ? '99+' : notificationCount" class="absolute -right-1 -top-1 inline-flex min-w-4 items-center justify-center rounded-full bg-amber-400 px-1 text-[10px] font-bold leading-4 text-amber-950"></span>
                                    </button>

                                    <div id="header-notifications" x-show="notificationsOpen" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-1 scale-95" class="fixed right-4 top-16 z-[60] w-[min(22rem,calc(100vw-2rem))] origin-top-right rounded-lg border border-gray-200 bg-white shadow-xl ring-1 ring-black/5 dark:border-slate-700 dark:bg-slate-900" style="display: none;" @click.stop>
                                        <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3 dark:border-slate-800">
                                            <div>
                                                <h2 class="text-sm font-semibold text-gray-900 dark:text-slate-100">{{ __('Notifications') }}</h2>
                                                <p class="mt-0.5 text-xs text-gray-500 dark:text-slate-400">{{ __('Open bookings needing attention') }}</p>
                                            </div>
                                            <span x-show="notificationCount > 0" x-cloak class="rounded-full bg-amber-400 px-2 py-1 text-xs font-semibold text-amber-950" x-text="notificationCount"></span>
                                        </div>
                                        <div class="max-h-[min(20rem,calc(100vh-10rem))] overflow-y-auto">
                                            <template x-for="notification in headerNotifications" :key="notification.id">
                                                <a :href="notification.url" x-on:click.prevent="visitNotification(notification.url)" class="block border-b border-gray-100 px-4 py-3 transition hover:bg-gray-50 dark:border-slate-800 dark:hover:bg-slate-800/60">
                                                    <p class="truncate text-sm font-medium text-gray-900 dark:text-slate-100" x-text="notification.task_name"></p>
                                                    <p class="mt-1 truncate text-xs text-gray-500 dark:text-slate-400"><span x-text="notification.client_name"></span> · <span x-text="notification.status"></span></p>
                                                </a>
                                            </template>
                                            <p x-show="headerNotifications.length === 0" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-slate-400">
                                                {{ __('You are all caught up.') }}
                                            </p>
                                        </div>
                                        <div class="border-t border-gray-100 p-3 dark:border-slate-800">
                                            <a href="{{ route('notifications.index') }}" x-on:click.prevent="visitNotification($el.href)" class="block rounded-md bg-gray-900 px-3 py-2 text-center text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 dark:bg-amber-400 dark:text-amber-950 dark:hover:bg-amber-300">{{ __('View all notifications') }}</a>
                                        </div>
                                    </div>
                                    <div x-show="toast" x-cloak x-transition class="fixed bottom-5 right-5 z-[70] w-[min(24rem,calc(100vw-2rem))] rounded-lg border border-amber-300 bg-white p-4 shadow-xl dark:border-amber-500/40 dark:bg-slate-900" role="status" aria-live="polite">
                                        <div class="flex items-start gap-3">
                                            <span class="mt-0.5 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-800 dark:bg-amber-400/15 dark:text-amber-300" aria-hidden="true">!</span>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-slate-100">{{ __('New task notification') }}</p>
                                                <p class="mt-1 truncate text-sm text-gray-600 dark:text-slate-300" x-text="toast?.task_name"></p>
                                                <p class="truncate text-xs text-gray-500 dark:text-slate-400" x-text="toast?.client_name"></p>
                                                <a :href="toast?.url" x-on:click.prevent="visitNotification(toast.url)" class="mt-2 inline-block text-sm font-semibold text-amber-800 hover:underline dark:text-amber-300">{{ __('Review booking') }}</a>
                                            </div>
                                            <button type="button" x-on:click="toast = null" class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-md text-gray-500 hover:bg-gray-100 dark:text-slate-300 dark:hover:bg-slate-800" aria-label="{{ __('Dismiss notification') }}">&times;</button>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('profile.edit') }}" class="app-header-profile hidden h-9 w-9 items-center justify-center rounded-lg border border-gray-300 bg-white text-slate-600 transition hover:border-yellow-400/50 hover:bg-gray-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-yellow-400/50 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-300 dark:hover:bg-slate-900/70 dark:hover:text-yellow-300 md:inline-flex" aria-label="Profile" title="Profile">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </header>
                @endisset

                <main class="app-main min-h-screen overflow-y-auto lg:min-h-0 lg:flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @if (session('status'))
            <div class="pointer-events-none fixed bottom-5 right-5 z-50">
                <div class="pointer-events-auto rounded-lg border border-slate-700 bg-slate-900/80 px-3 py-2 text-xs font-medium text-slate-200 shadow-lg shadow-slate-950/40 backdrop-blur-sm">
                    {{ session('status') }}
                </div>
            </div>
        @endif
    </body>
</html>
