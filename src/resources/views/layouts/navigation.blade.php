<nav x-data="{ open: false }" class="shrink-0 md:sticky md:top-0 md:h-screen md:self-start md:overflow-hidden">
    <!-- Primary Navigation Menu -->
    <div class="relative hidden h-full min-h-screen w-64 flex-col border-r border-gray-200 bg-white md:flex">
        <div class="flex h-20 items-center border-b border-gray-100 px-6">
            <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-3">
                <x-application-logo class="block h-9 w-9 shrink-0 object-contain" />
                <span class="truncate text-sm font-semibold tracking-tight text-gray-800">{{ config('app.name', 'PPCC Booking') }}</span>
            </a>
        </div>

        <div class="flex-1 space-y-2 p-4" x-data="{ bookingsOpen: @js(request()->routeIs('bookings.*')), settingsOpen: @js(request()->routeIs('settings.*')) }">
            <p class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-gray-400">{{ __('Workspace') }}</p>
            <div class="space-y-1">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                        {{ __('Reports') }}
                    </x-nav-link>
                    <button type="button" x-on:click="bookingsOpen = !bookingsOpen" class="flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('bookings.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <span>{{ __('Bookings') }}</span>
                        <svg class="h-4 w-4 transition-transform" :class="bookingsOpen ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="bookingsOpen" class="ml-3 space-y-1 border-l border-gray-200 pl-3">
                        <a href="{{ route('bookings.index', ['tab' => 'entry']) }}" class="block rounded-md px-3 py-2 text-sm {{ request('tab') !== 'monitoring' ? 'font-semibold text-indigo-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Task Entry') }}</a>
                        <a href="{{ route('bookings.index', ['tab' => 'monitoring']) }}" class="block rounded-md px-3 py-2 text-sm {{ request('tab') === 'monitoring' ? 'font-semibold text-indigo-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Task Monitoring') }}</a>
                    </div>
                    <button type="button" x-on:click="settingsOpen = !settingsOpen" class="flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('settings.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <span>{{ __('Settings') }}</span>
                        <svg class="h-4 w-4 transition-transform" :class="settingsOpen ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="settingsOpen" class="ml-3 space-y-1 border-l border-gray-200 pl-3">
                        <a href="{{ route('settings.index', ['tab' => 'users']) }}" class="block rounded-md px-3 py-2 text-sm {{ request('tab', 'users') === 'users' ? 'font-semibold text-indigo-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('User Settings') }}</a>
                        <a href="{{ route('settings.index', ['tab' => 'clients']) }}" class="block rounded-md px-3 py-2 text-sm {{ request('tab') === 'clients' ? 'font-semibold text-indigo-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Clients List') }}</a>
                        <a href="{{ route('settings.index', ['tab' => 'tasks']) }}" class="block rounded-md px-3 py-2 text-sm {{ request('tab') === 'tasks' ? 'font-semibold text-indigo-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Tasks List') }}</a>
                        <a href="{{ route('settings.index', ['tab' => 'forms']) }}" class="block rounded-md px-3 py-2 text-sm {{ request('tab') === 'forms' ? 'font-semibold text-indigo-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">{{ __('Forms List') }}</a>
                    </div>
            </div>
        </div>

        <div class="mt-auto border-t border-gray-100 p-4">
            <div class="flex items-center gap-2">
                <div class="min-w-0 flex-1 truncate px-1 text-sm font-medium text-gray-700">{{ Auth::user()->name }}</div>

                <a href="{{ route('profile.edit') }}" title="{{ __('Profile') }}" aria-label="{{ __('Profile') }}" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                    </svg>
                </a>

                    <button type="button" x-on:click="$dispatch('open-modal', 'logout-confirm')" title="{{ __('Log Out') }}" aria-label="{{ __('Log Out') }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
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

    <div class="flex h-16 items-center justify-between border-b border-gray-200 bg-white px-4 md:hidden">
        <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-3">
            <x-application-logo class="block h-9 w-9 shrink-0 object-contain" />
            <span class="truncate text-sm font-semibold tracking-tight text-gray-800">{{ config('app.name', 'PPCC Booking') }}</span>
        </a>
        <button @click="open = ! open" type="button" class="rounded-md p-2 text-gray-500 hover:bg-gray-100" aria-label="{{ __('Toggle navigation') }}">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-b border-gray-200 bg-white p-4 md:hidden">
        <div class="pt-2 pb-3 space-y-1" x-data="{ bookingsOpen: @js(request()->routeIs('bookings.*')), settingsOpen: @js(request()->routeIs('settings.*')) }">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <button type="button" @click="bookingsOpen = !bookingsOpen" class="flex w-full items-center justify-between px-4 py-2 text-start text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                <span>{{ __('Bookings') }}</span>
                <svg class="h-4 w-4 transition-transform" :class="bookingsOpen ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
            </button>
            <div x-show="bookingsOpen" class="ml-4 space-y-1 border-l border-gray-200 pl-2">
                <x-responsive-nav-link :href="route('bookings.index', ['tab' => 'entry'])">{{ __('Task Entry') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('bookings.index', ['tab' => 'monitoring'])">{{ __('Task Monitoring') }}</x-responsive-nav-link>
            </div>

            <button type="button" @click="settingsOpen = !settingsOpen" class="flex w-full items-center justify-between px-4 py-2 text-start text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                <span>{{ __('Settings') }}</span>
                <svg class="h-4 w-4 transition-transform" :class="settingsOpen ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
            </button>
            <div x-show="settingsOpen" class="ml-4 space-y-1 border-l border-gray-200 pl-2">
                <x-responsive-nav-link :href="route('settings.index', ['tab' => 'users'])">{{ __('User Settings') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('settings.index', ['tab' => 'clients'])">{{ __('Clients List') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('settings.index', ['tab' => 'tasks'])">{{ __('Tasks List') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('settings.index', ['tab' => 'forms'])">{{ __('Forms List') }}</x-responsive-nav-link>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <button type="button" x-on:click="$dispatch('open-modal', 'logout-confirm')" class="flex w-full items-center px-4 py-2 text-start text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                    {{ __('Log Out') }}
                </button>
            </div>
        </div>
    </div>

    <x-modal name="logout-confirm" maxWidth="sm" focusable>
        <form method="POST" action="{{ route('logout') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-semibold text-gray-900">{{ __('Confirm logout') }}</h2>
            <p class="mt-2 text-sm text-gray-600">{{ __('Are you sure you want to log out of your account?') }}</p>

            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close-modal', 'logout-confirm')" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    {{ __('Cancel') }}
                </button>
                <x-primary-button>{{ __('Log Out') }}</x-primary-button>
            </div>
        </form>
    </x-modal>
</nav>
