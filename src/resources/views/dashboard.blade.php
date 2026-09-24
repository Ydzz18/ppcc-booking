<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">{{ __('Workspace') }}</p>
                <h2 class="mt-1 text-xl font-semibold tracking-tight text-gray-900">{{ __('Dashboard') }}</h2>
            </div>
            <a href="{{ route('bookings.index', ['tab' => 'entry']) }}" class="inline-flex items-center gap-2 rounded-md bg-gray-900 px-4 py-2.5 text-xs font-semibold uppercase tracking-widest text-white shadow-sm transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                <span class="text-base leading-none">+</span>
                {{ __('New Booking') }}
            </a>
        </div>
    </x-slot>

    <div class="space-y-8 px-4 py-8 sm:px-6 lg:px-8">
        <section aria-labelledby="core-sections-title">
            <div class="mb-4 flex items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">{{ __('Core sections') }}</p>
                    <h3 id="core-sections-title" class="mt-1 text-lg font-semibold text-gray-900">{{ __('Booking operations') }}</h3>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">{{ __('Total bookings') }}</p>
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-gray-900">{{ $bookingTotal }}</p>
                    <a href="{{ route('bookings.index') }}" class="mt-4 inline-flex text-sm font-medium text-indigo-700 hover:text-indigo-900">{{ __('View bookings') }} &rarr;</a>
                </div>
                <div class="rounded-lg border border-amber-200 bg-amber-50 p-5 shadow-sm">
                    <p class="text-sm text-amber-800">{{ __('Pending') }}</p>
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-amber-950">{{ $pendingBookings }}</p>
                    <a href="{{ route('bookings.index', ['tab' => 'monitoring']) }}" class="mt-4 inline-flex text-sm font-medium text-amber-800 hover:text-amber-950">{{ __('Review queue') }} &rarr;</a>
                </div>
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
                    <p class="text-sm text-emerald-800">{{ __('Completed') }}</p>
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-emerald-950">{{ $completedBookings }}</p>
                    <p class="mt-4 text-sm text-emerald-800">{{ __('Completed workflows') }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">{{ __('Client profiles') }}</p>
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-gray-900">{{ $clients->count() }}</p>
                    <a href="{{ route('settings.index', ['tab' => 'clients']) }}" class="mt-4 inline-flex text-sm font-medium text-indigo-700 hover:text-indigo-900">{{ __('Manage clients') }} &rarr;</a>
                </div>
            </div>
        </section>

        <section aria-labelledby="quick-stats-title">
            <div class="mb-4">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">{{ __('Dashboard widgets') }}</p>
                <h3 id="quick-stats-title" class="mt-1 text-lg font-semibold text-gray-900">{{ __('At a glance') }}</h3>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">{{ __('Bookings today') }}</p>
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-gray-900">{{ $bookingsToday }}</p>
                    <p class="mt-2 text-xs text-gray-500">{{ __('Received today') }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">{{ __('This week') }}</p>
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-gray-900">{{ $bookingsThisWeek }}</p>
                    <p class="mt-2 text-xs text-gray-500">{{ __('Bookings received') }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">{{ __('Completion rate') }}</p>
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-gray-900">{{ $completionRate }}%</p>
                    <p class="mt-2 text-xs text-gray-500">{{ __('Of all bookings') }}</p>
                </div>
                <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-5">
                    <p class="text-sm text-gray-500">{{ __('Occupancy') }}</p>
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-gray-400">—</p>
                    <p class="mt-2 text-xs text-gray-500">{{ __('Capacity tracking not configured') }}</p>
                </div>
            </div>
        </section>

        <section aria-labelledby="calendar-title" class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">{{ __('Core sections') }}</p>
                    <h3 id="calendar-title" class="mt-1 text-lg font-semibold text-gray-900">{{ __('Booking calendar') }}</h3>
                </div>
                <div class="flex items-center rounded-md border border-gray-200 p-1 text-xs font-semibold">
                    @foreach (['day' => 'Daily', 'week' => 'Weekly', 'month' => 'Monthly'] as $view => $label)
                        <a href="{{ route('dashboard', ['calendar_view' => $view]) }}" class="rounded px-3 py-1.5 {{ $calendarView === $view ? 'bg-gray-900 text-white' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900' }}">{{ __($label) }}</a>
                    @endforeach
                </div>
            </div>

            @if ($calendarView === 'month')
                <div class="mt-6 grid grid-cols-7 gap-px overflow-hidden rounded-md border border-gray-200 bg-gray-200">
                    @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $weekday)
                        <div class="bg-gray-50 px-2 py-2 text-center text-xs font-semibold uppercase tracking-wide text-gray-400">{{ __($weekday) }}</div>
                    @endforeach
                    @foreach ($calendarDays as $day)
                        <div class="min-h-24 bg-white p-2 {{ $day['date']->isToday() ? 'ring-2 ring-inset ring-indigo-500' : '' }}">
                            <div class="flex items-center justify-between gap-1">
                                <span class="text-xs font-medium {{ $day['date']->isToday() ? 'text-indigo-700' : 'text-gray-500' }}">{{ $day['date']->format('j') }}</span>
                                @if ($day['count'] > 0)
                                    <span class="rounded-full bg-indigo-100 px-1.5 py-0.5 text-[10px] font-semibold text-indigo-700">{{ $day['count'] }}</span>
                                @endif
                            </div>
                            @if ($day['count'] > 0)
                                <a href="{{ route('bookings.index', ['tab' => 'monitoring']) }}" class="mt-3 block truncate rounded bg-indigo-50 px-1.5 py-1 text-[10px] font-medium text-indigo-800">{{ $day['count'] }} {{ __('booking(s)') }}</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="mt-6 grid gap-3 {{ $calendarView === 'week' ? 'sm:grid-cols-7' : 'max-w-sm grid-cols-1' }}">
                    @foreach ($calendarDays as $day)
                        <a href="{{ route('bookings.index', ['tab' => 'monitoring']) }}" class="rounded-md border {{ $day['date']->isToday() ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200 bg-gray-50' }} p-4 transition hover:border-gray-400">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $day['date']->format('D, M j') }}</p>
                            <p class="mt-3 text-2xl font-semibold text-gray-900">{{ $day['count'] }}</p>
                            <p class="mt-1 text-xs text-gray-500">{{ __('booking(s)') }}</p>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        <section aria-labelledby="client-management-title" class="grid gap-6 lg:grid-cols-[minmax(0,1.35fr)_minmax(280px,0.65fr)]">
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">{{ __('Client management') }}</p>
                        <h3 id="client-management-title" class="mt-1 text-lg font-semibold text-gray-900">{{ __('Client Profiles') }}</h3>
                    </div>
                    <a href="{{ route('settings.index', ['tab' => 'clients']) }}" class="text-sm font-medium text-indigo-700 hover:text-indigo-900">{{ __('Open directory') }} &rarr;</a>
                </div>

                <form method="GET" action="{{ route('dashboard') }}" class="mt-5 grid gap-3 sm:grid-cols-[minmax(0,1fr)_160px_auto]">
                    <label class="sr-only" for="client_search">{{ __('Search clients') }}</label>
                    <input id="client_search" name="client_search" value="{{ $search }}" type="search" placeholder="{{ __('Search name, business, or address') }}" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    <label class="sr-only" for="client_filter">{{ __('Filter clients') }}</label>
                    <select id="client_filter" name="client_filter" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900">
                        <option value="all" @selected($clientFilter === 'all')>{{ __('All clients') }}</option>
                        <option value="recent" @selected($clientFilter === 'recent')>{{ __('Added in 30 days') }}</option>
                        <option value="oldest" @selected($clientFilter === 'oldest')>{{ __('Oldest first') }}</option>
                    </select>
                    <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">{{ __('Search') }}</button>
                </form>

                <div class="mt-5 divide-y divide-gray-100 border-y border-gray-100">
                    @forelse ($clients as $client)
                        <div class="flex items-center justify-between gap-4 py-4">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-gray-900">{{ $client->business_name ?: $client->client_name }}</p>
                                <p class="mt-1 truncate text-sm text-gray-500">{{ $client->client_name }} · {{ $client->address }}</p>
                            </div>
                            <a href="{{ route('clients.edit', $client) }}" class="shrink-0 text-sm font-medium text-gray-600 hover:text-gray-900">{{ __('View') }}</a>
                        </div>
                    @empty
                        <p class="py-6 text-sm text-gray-500">{{ __('No matching client profiles.') }}</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">{{ __('Operational tools') }}</p>
                        <h3 class="mt-1 text-lg font-semibold text-gray-900">{{ __('Notifications') }}</h3>
                    </div>
                    <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-800">{{ $notifications->count() }}</span>
                </div>
                <div class="mt-5 space-y-4">
                    @forelse ($notifications as $notification)
                        <a href="{{ route('bookings.edit', $notification) }}" class="block border-l-2 border-amber-400 pl-3 hover:border-gray-900">
                            <p class="text-sm font-medium text-gray-900">{{ $notification->task?->task_name ?? __('Booking') }}</p>
                            <p class="mt-1 text-xs text-gray-500">{{ $notification->client?->client_name ?? __('Unknown client') }} · {{ ucfirst($notification->submission_status ?: 'pending') }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-gray-500">{{ __('No pending notifications.') }}</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section aria-labelledby="insights-title" class="grid gap-6 lg:grid-cols-[minmax(0,1.4fr)_minmax(280px,0.6fr)]">
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">{{ __('Analytical insights') }}</p>
                        <h3 id="insights-title" class="mt-1 text-lg font-semibold text-gray-900">{{ __('Booking trends') }}</h3>
                    </div>
                    <a href="{{ route('reports.index', ['type' => 'bookings']) }}" class="text-sm font-medium text-indigo-700 hover:text-indigo-900">{{ __('Reports') }} &rarr;</a>
                </div>
                <div class="mt-8 flex h-40 items-end gap-3 sm:gap-6">
                    @php($trendMax = max(1, $trend->max('total')))
                    @foreach ($trend as $month)
                        <div class="flex min-w-0 flex-1 flex-col items-center gap-2">
                            <span class="text-xs font-medium text-gray-500">{{ $month['total'] }}</span>
                            <div class="flex h-24 w-full items-end rounded-sm bg-gray-100">
                                <div class="w-full rounded-sm bg-gray-900 transition" style="height: {{ max(8, ($month['total'] / $trendMax) * 100) }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $month['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">{{ __('Operational tools') }}</p>
                    <h3 class="mt-1 text-lg font-semibold text-gray-900">{{ __('Staff assignments') }}</h3>
                </div>
                <div class="mt-5 space-y-4">
                    @forelse ($staff as $member)
                        <div class="flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-gray-900">{{ $member->name }}</p>
                                <p class="text-xs capitalize text-gray-500">{{ $member->role }}</p>
                            </div>
                            <span class="shrink-0 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700">{{ $staffWorkload[$member->id] ?? 0 }} {{ __('open') }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">{{ __('No active staff members.') }}</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section aria-labelledby="charts-title" class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">{{ __('Graphs and charts') }}</p>
                        <h3 id="charts-title" class="mt-1 text-lg font-semibold text-gray-900">{{ __('Booking distribution') }}</h3>
                    </div>
                    <span class="text-xs text-gray-500">{{ $bookingTotal }} {{ __('total') }}</span>
                </div>
                @php($distributionMax = max(1, $bookingDistribution->max('value')))
                <div class="mt-7 space-y-5">
                    @foreach ($bookingDistribution as $distribution)
                        <div>
                            <div class="mb-2 flex items-center justify-between gap-3 text-sm">
                                <span class="font-medium text-gray-700">{{ __($distribution['label']) }}</span>
                                <span class="font-semibold text-gray-900">{{ $distribution['value'] }}</span>
                            </div>
                            <div class="h-3 overflow-hidden rounded-full bg-gray-100">
                                <div class="h-full rounded-full {{ $distribution['color'] }}" style="width: {{ max(4, ($distribution['value'] / $distributionMax) * 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 shadow-sm">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">{{ __('Graphs and charts') }}</p>
                        <h3 class="mt-1 text-lg font-semibold text-gray-900">{{ __('Revenue trends') }}</h3>
                    </div>
                    <a href="{{ route('reports.index', ['type' => 'bookings']) }}" class="text-sm font-medium text-indigo-700 hover:text-indigo-900">{{ __('Reports') }} &rarr;</a>
                </div>
                <div class="mt-7 flex h-28 items-center justify-center rounded-md border border-dashed border-gray-300 bg-white px-6 text-center">
                    <div>
                        <p class="text-sm font-medium text-gray-700">{{ __('Revenue data is not tracked yet.') }}</p>
                        <p class="mt-1 text-xs leading-5 text-gray-500">{{ __('Add pricing or revenue fields to enable this chart.') }}</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
