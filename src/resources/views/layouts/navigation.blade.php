<nav x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false" class="relative z-40 shrink-0 lg:sticky lg:top-0 lg:z-auto lg:h-screen lg:self-start lg:overflow-hidden">
    <!-- Primary Navigation Menu -->
    <div class="landscape-desktop-sidebar relative hidden h-full min-h-screen w-64 flex-col border-r border-gray-200 bg-white lg:flex">
        <div class="mobile-sidebar-brand flex h-20 items-center border-b border-gray-100 px-6">
            <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-3">
                <x-application-logo class="block h-9 w-9 shrink-0 object-contain" />
                <span class="mobile-sidebar-label truncate text-sm font-semibold tracking-tight text-slate-900 dark:text-slate-100">{{ config('app.name', 'PPCC Booking') }}</span>
            </a>
        </div>

        <div class="mobile-sidebar-nav-list flex-1 space-y-2 p-4">
            <p class="mobile-sidebar-label px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ __('Workspace') }}</p>
            <div class="flex flex-col space-y-1">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" title="{{ __('Dashboard') }}">
                        <svg class="mobile-sidebar-icon h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75h6.5v6.5h-6.5zm10 0h6.5v6.5h-6.5zm-10 10h6.5v6.5h-6.5zm10 0h6.5v6.5h-6.5z" /></svg>
                        <span class="mobile-sidebar-label">{{ __('Dashboard') }}</span>
                    </x-nav-link>
                    <div title="{{ __('Bookings') }}" class="mobile-sidebar-group flex w-full items-center justify-between rounded-lg border border-transparent px-3 py-2 text-sm font-medium {{ request()->routeIs('bookings.*') ? 'border-yellow-400/40 bg-yellow-400/10 text-yellow-600 shadow-sm shadow-yellow-500/10 dark:text-yellow-300' : 'text-slate-700 dark:text-slate-300' }}">
                        <svg class="mobile-sidebar-icon h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75v3m9-3v3m-12 3h15m-13.5-4.5h12a1.5 1.5 0 0 1 1.5 1.5v11.5a1.5 1.5 0 0 1-1.5 1.5h-12a1.5 1.5 0 0 1-1.5-1.5V6.75a1.5 1.5 0 0 1 1.5-1.5Z" /></svg>
                        <span class="mobile-sidebar-label">{{ __('Bookings') }}</span>
                    </div>
                    <div class="mobile-sidebar-subnav ml-3 space-y-1 border-l border-slate-700 pl-3">
                        <a href="{{ route('bookings.index', ['tab' => 'entry']) }}" title="{{ __('Task Entry') }}" class="mobile-sidebar-link block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('bookings.*') && request('tab', 'entry') === 'entry' ? 'border border-yellow-400/40 bg-yellow-400/10 font-semibold text-yellow-600 dark:text-yellow-300' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800/60 dark:hover:text-slate-100' }}"><svg class="mobile-sidebar-icon h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5.25v13.5m6.75-6.75H5.25" /></svg><span class="mobile-sidebar-label">{{ __('Task Entry') }}</span></a>
                        <a href="{{ route('bookings.index', ['tab' => 'monitoring']) }}" title="{{ __('Task Monitoring') }}" class="mobile-sidebar-link block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('bookings.*') && request('tab') === 'monitoring' ? 'border border-yellow-400/40 bg-yellow-400/10 font-semibold text-yellow-600 dark:text-yellow-300' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800/60 dark:hover:text-slate-100' }}"><svg class="mobile-sidebar-icon h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5V12m5 7.5V4.5m5 15v-10m5 10V8" /></svg><span class="mobile-sidebar-label">{{ __('Task Monitoring') }}</span></a>
                    </div>
                    <div title="{{ __('Settings') }}" class="mobile-sidebar-group flex w-full items-center justify-between rounded-lg border border-transparent px-3 py-2 text-sm font-medium {{ request()->routeIs('settings.*') ? 'border-yellow-400/40 bg-yellow-400/10 text-yellow-600 shadow-sm shadow-yellow-500/10 dark:text-yellow-300' : 'text-slate-700 dark:text-slate-300' }}">
                        <svg class="mobile-sidebar-icon h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5Z" /><path stroke-linecap="round" stroke-linejoin="round" d="m19.4 15 .1.1a1.5 1.5 0 1 1-2.12 2.12l-.1-.1a1.5 1.5 0 0 0-2.56 1.06v.32a1.5 1.5 0 1 1-3 0v-.15a1.5 1.5 0 0 0-2.56-1.06l-.1.1a1.5 1.5 0 1 1-2.12-2.12l.1-.1A1.5 1.5 0 0 0 5.98 12.6h-.23a1.5 1.5 0 1 1 0-3h.15a1.5 1.5 0 0 0 1.06-2.56l-.1-.1a1.5 1.5 0 1 1 2.12-2.12l.1.1a1.5 1.5 0 0 0 2.56-1.06v-.32a1.5 1.5 0 1 1 3 0v.15a1.5 1.5 0 0 0 2.56 1.06l.1-.1a1.5 1.5 0 1 1 2.12 2.12l-.1.1A1.5 1.5 0 0 0 20.48 9h.27a1.5 1.5 0 1 1 0 3h-.29A1.5 1.5 0 0 0 19.4 15Z" /></svg>
                        <span class="mobile-sidebar-label">{{ __('Settings') }}</span>
                    </div>
                    <div class="mobile-sidebar-subnav ml-3 space-y-1 border-l border-slate-700 pl-3">
                        <a href="{{ route('settings.index', ['tab' => 'users']) }}" title="{{ __('User Settings') }}" class="mobile-sidebar-link block rounded-lg px-3 py-2 text-sm {{ request('tab', 'users') === 'users' ? 'border border-yellow-400/40 bg-yellow-400/10 font-semibold text-yellow-600 dark:text-yellow-300' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800/60 dark:hover:text-slate-100' }}"><svg class="mobile-sidebar-icon h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" /></svg><span class="mobile-sidebar-label">{{ __('User Settings') }}</span></a>
                        <a href="{{ route('settings.index', ['tab' => 'clients']) }}" title="{{ __('Clients List') }}" class="mobile-sidebar-link block rounded-lg px-3 py-2 text-sm {{ request('tab') === 'clients' ? 'border border-yellow-400/40 bg-yellow-400/10 font-semibold text-yellow-600 dark:text-yellow-300' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800/60 dark:hover:text-slate-100' }}"><svg class="mobile-sidebar-icon h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 20.25h4.25v-.75a4.5 4.5 0 0 0-7.12-3.66M16.5 20.25H3.25v-.75a6.25 6.25 0 0 1 12.5 0v.75Zm0-13.5a3.25 3.25 0 1 1-6.5 0 3.25 3.25 0 0 1 6.5 0Zm4.25 3.25a2.75 2.75 0 1 1-5.5 0 2.75 2.75 0 0 1 5.5 0Z" /></svg><span class="mobile-sidebar-label">{{ __('Clients List') }}</span></a>
                        <a href="{{ route('settings.index', ['tab' => 'tasks']) }}" title="{{ __('Tasks List') }}" class="mobile-sidebar-link block rounded-lg px-3 py-2 text-sm {{ request('tab') === 'tasks' ? 'border border-yellow-400/40 bg-yellow-400/10 font-semibold text-yellow-600 dark:text-yellow-300' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800/60 dark:hover:text-slate-100' }}"><svg class="mobile-sidebar-icon h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 12.75 2.25 2.25 5.25-5.25M4.5 6.75h15m-15 5.25h2.25m-2.25 5.25h2.25m-2.25 4.5h15" /></svg><span class="mobile-sidebar-label">{{ __('Tasks List') }}</span></a>
                        <a href="{{ route('settings.index', ['tab' => 'forms']) }}" title="{{ __('Forms List') }}" class="mobile-sidebar-link block rounded-lg px-3 py-2 text-sm {{ request('tab') === 'forms' ? 'border border-yellow-400/40 bg-yellow-400/10 font-semibold text-yellow-600 dark:text-yellow-300' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800/60 dark:hover:text-slate-100' }}"><svg class="mobile-sidebar-icon h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75h6l4.5 4.5v12h-12a1.5 1.5 0 0 1-1.5-1.5v-13.5a1.5 1.5 0 0 1 1.5-1.5Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 3.75v4.5H18m-9 4.5h6m-6 3h6" /></svg><span class="mobile-sidebar-label">{{ __('Forms List') }}</span></a>
                    </div>
                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" title="{{ __('Reports') }}">
                        <svg class="mobile-sidebar-icon h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5V13m5 6.5V8m5 11.5V4.5m5 15v-9" /></svg>
                        <span class="mobile-sidebar-label">{{ __('Reports') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')" title="{{ __('Expenses') }}">
                        <svg class="mobile-sidebar-icon h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 7.5A2.25 2.25 0 0 1 6.75 5.25h10.5A2.25 2.25 0 0 1 19.5 7.5v10.75a.5.5 0 0 1-.5.5H6.75A2.25 2.25 0 0 1 4.5 16.5v-9Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 8.25h15m-4 5.25h.01" /></svg>
                        <span class="mobile-sidebar-label">{{ __('Expenses') }}</span>
                    </x-nav-link>
                    @can('manage-users')
                        <x-nav-link :href="route('audit-logs.index')" :active="request()->routeIs('audit-logs.*')" title="{{ __('Audit Logs') }}">
                            <svg class="mobile-sidebar-icon h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5h-2A1.75 1.75 0 0 0 4.5 6.25v13A1.75 1.75 0 0 0 6.25 21h11.5a1.75 1.75 0 0 0 1.75-1.75v-13a1.75 1.75 0 0 0-1.75-1.75h-2M8.25 4.5A1.75 1.75 0 0 1 10 2.75h4a1.75 1.75 0 0 1 1.75 1.75m-7.5 7.25 2.25 2.25 4.75-4.75" /></svg>
                            <span class="mobile-sidebar-label">{{ __('Audit Logs') }}</span>
                        </x-nav-link>
                    @endcan
            </div>
        </div>

        <div class="mobile-sidebar-footer mt-auto border-t border-gray-100 p-4">
            <div class="flex items-center gap-2">
                <div class="mobile-sidebar-user min-w-0 flex-1 truncate px-1 text-sm font-medium text-slate-800 dark:text-slate-200">{{ Auth::user()->name }}</div>

                <button type="button" data-theme-toggle title="{{ __('Toggle theme') }}" aria-label="{{ __('Toggle theme') }}" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-slate-400 hover:bg-slate-800 hover:text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg data-theme-icon class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path class="dark:hidden" stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.5m0 13V21m9-9h-2.5M5.5 12H3m15.5 6.5-1.8-1.8M8.3 8.3 6.5 6.5m0 11 1.8-1.8m7.4-7.4 1.8-1.8M12 7.5A4.5 4.5 0 1 1 7.5 12 4.5 4.5 0 0 1 12 7.5Z" />
                        <path class="hidden dark:block" stroke-linecap="round" stroke-linejoin="round" d="M21 12.8A8.8 8.8 0 0 1 11.2 3a9 9 0 1 0 9.8 9.8Z" />
                    </svg>
                </button>

                <a href="{{ route('profile.edit') }}" title="{{ __('Profile') }}" aria-label="{{ __('Profile') }}" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-slate-400 hover:bg-slate-800 hover:text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                    </svg>
                </a>

                    <button type="button" x-on:click="$dispatch('open-modal', 'logout-confirm')" title="{{ __('Log Out') }}" aria-label="{{ __('Log Out') }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-slate-400 hover:bg-slate-800 hover:text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 12h9m0 0-3-3m3 3-3 3" />
                        </svg>
                    </button>
            </div>
        </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
    </div>

    <div class="landscape-mobile-header flex h-16 items-center justify-between border-b border-gray-200 bg-white px-4 lg:hidden">
        <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-3">
            <x-application-logo class="block h-9 w-9 shrink-0 object-contain" />
            <span class="truncate text-sm font-semibold tracking-tight text-slate-900 dark:text-slate-100">{{ config('app.name', 'PPCC Booking') }}</span>
        </a>
        <div class="flex items-center gap-2">
            <button type="button" data-theme-toggle class="rounded-md p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-100" aria-label="{{ __('Toggle theme') }}">
                <svg data-theme-icon class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path class="dark:hidden" stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.5m0 13V21m9-9h-2.5M5.5 12H3m15.5 6.5-1.8-1.8M8.3 8.3 6.5 6.5m0 11 1.8-1.8m7.4-7.4 1.8-1.8M12 7.5A4.5 4.5 0 1 1 7.5 12 4.5 4.5 0 0 1 12 7.5Z" />
                    <path class="hidden dark:block" stroke-linecap="round" stroke-linejoin="round" d="M21 12.8A8.8 8.8 0 0 1 11.2 3a9 9 0 1 0 9.8 9.8Z" />
                </svg>
            </button>
            <button @click="open = ! open" type="button" class="rounded-md p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-100" aria-label="{{ __('Toggle navigation') }}" aria-controls="mobile-navigation-menu" :aria-expanded="open.toString()">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    <div id="mobile-navigation-menu" :class="{'block': open, 'hidden': ! open}" class="landscape-mobile-menu absolute inset-x-0 top-full z-50 max-h-[calc(100dvh-4rem)] overflow-y-auto hidden border-b border-gray-200 bg-white p-4 shadow-xl lg:hidden">
        <div class="pt-2 pb-3 space-y-1" x-data="{ settingsOpen: true }">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <div class="flex w-full items-center justify-between px-4 py-2 text-start text-base font-medium text-slate-700 dark:text-slate-300">
                <span>{{ __('Bookings') }}</span>
                <svg class="h-4 w-4 rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75 0.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
            </div>
            <div class="ml-4 space-y-1 border-l border-gray-200 pl-2">
                <x-responsive-nav-link :href="route('bookings.index', ['tab' => 'entry'])">{{ __('Task Entry') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('bookings.index', ['tab' => 'monitoring'])">{{ __('Task Monitoring') }}</x-responsive-nav-link>
            </div>

            <button type="button" disabled class="flex w-full items-center justify-between px-4 py-2 text-start text-base font-medium text-slate-700 dark:text-slate-300">
                <span>{{ __('Settings') }}</span>
                <svg class="h-4 w-4 transition-transform" :class="settingsOpen ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
            </button>
            <div x-show="settingsOpen" class="ml-4 space-y-1 border-l border-gray-200 pl-2">
                <x-responsive-nav-link :href="route('settings.index', ['tab' => 'users'])">{{ __('User Settings') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('settings.index', ['tab' => 'clients'])">{{ __('Clients List') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('settings.index', ['tab' => 'tasks'])">{{ __('Tasks List') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('settings.index', ['tab' => 'forms'])">{{ __('Forms List') }}</x-responsive-nav-link>
            </div>
            <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                {{ __('Reports') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')">
                {{ __('Expenses') }}
            </x-responsive-nav-link>
            @can('manage-users')
                <x-responsive-nav-link :href="route('audit-logs.index')" :active="request()->routeIs('audit-logs.*')">
                    {{ __('Audit Logs') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-slate-100">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <button type="button" x-on:click="$dispatch('open-modal', 'logout-confirm')" class="flex w-full items-center px-4 py-2 text-start text-base font-medium text-slate-300 hover:bg-slate-800 hover:text-slate-100">
                    {{ __('Log Out') }}
                </button>
            </div>
        </div>
    </div>

    <x-modal name="logout-confirm" maxWidth="sm" focusable>
        <form method="POST" action="{{ route('logout') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ __('Confirm logout') }}</h2>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ __('Are you sure you want to log out of your account?') }}</p>

            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close-modal', 'logout-confirm')" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700">
                    {{ __('Cancel') }}
                </button>
                <x-primary-button>{{ __('Log Out') }}</x-primary-button>
            </div>
        </form>
    </x-modal>
</nav>
