<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">{{ __('Workspace') }}</p>
            <h2 class="mt-1 text-xl font-semibold tracking-tight text-gray-900">{{ __('Reports') }}</h2>
        </div>
    </x-slot>

    <div class="space-y-8 px-4 py-8 sm:px-6 lg:px-8">
        <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm" aria-labelledby="report-builder-title">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">{{ __('Analytical insights') }}</p>
                    <h1 id="report-builder-title" class="mt-1 text-lg font-semibold text-gray-900">{{ __('Build a report') }}</h1>
                    <p class="mt-2 text-sm text-gray-500">{{ __('Choose a record type and date range, then export it as CSV or PDF.') }}</p>
                </div>
                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">{{ count($rows) }} {{ __('records') }}</span>
            </div>

            <form method="GET" action="{{ route('reports.index') }}" class="mobile-filter-toolbar mt-6 grid gap-4 md:grid-cols-[minmax(0,1fr)_180px_180px_auto] md:items-end">
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">{{ __('Report type') }}</label>
                    <select id="type" name="type" class="mt-2 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900">
                        <option value="clients" @selected($reportType === 'clients')>{{ __('Client records') }}</option>
                        <option value="tasks" @selected($reportType === 'tasks')>{{ __('Task records') }}</option>
                        <option value="bookings" @selected($reportType === 'bookings')>{{ __('Booking records') }}</option>
                        <option value="staff" @selected($reportType === 'staff')>{{ __('Staff assignments') }}</option>
                    </select>
                </div>
                <div>
                    <label for="from" class="block text-sm font-medium text-gray-700">{{ __('From') }}</label>
                    <input id="from" name="from" type="date" value="{{ $from }}" class="mt-2 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900">
                </div>
                <div>
                    <label for="to" class="block text-sm font-medium text-gray-700">{{ __('To') }}</label>
                    <input id="to" name="to" type="date" value="{{ $to }}" class="mt-2 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900">
                </div>
                <button type="submit" class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2.5 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">{{ __('Generate') }}</button>
            </form>
        </section>

        <section class="rounded-lg border border-gray-200 bg-white shadow-sm" aria-labelledby="preview-title">
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 px-6 py-5">
                <div>
                    <h2 id="preview-title" class="text-lg font-semibold text-gray-900">{{ __($title) }}</h2>
                    <p class="mt-1 text-sm text-gray-500">{{ __('Preview of the records that will be exported.') }}</p>
                </div>
                <div class="relative" x-data="{ actionsOpen: false }" @click.outside="actionsOpen = false" @keydown.escape.window="actionsOpen = false">
                    <button type="button" x-on:click="actionsOpen = !actionsOpen" :aria-expanded="actionsOpen.toString()" aria-haspopup="menu" aria-controls="report-actions-menu" class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                        {{ __('Actions') }}
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>

                    <div id="report-actions-menu" x-show="actionsOpen" x-cloak role="menu" aria-label="{{ __('Report actions') }}" class="absolute left-0 right-auto top-full z-30 mt-2 w-48 max-w-[calc(100vw-2rem)] overflow-hidden rounded-md border border-gray-200 bg-white py-1 shadow-lg ring-1 ring-black/5 sm:left-auto sm:right-0">
                        <a href="{{ route('reports.print', array_filter(['type' => $reportType, 'from' => $from, 'to' => $to])) }}" target="_blank" rel="noopener" role="menuitem" x-on:click="actionsOpen = false" class="block px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-50 focus:bg-gray-50 focus:outline-none">
                            {{ __('Print') }}
                        </a>
                        <div class="my-1 border-t border-gray-100"></div>
                        <a href="{{ route('reports.export', array_filter(['type' => $reportType, 'from' => $from, 'to' => $to])) }}" role="menuitem" x-on:click="actionsOpen = false" class="block px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-50 focus:bg-gray-50 focus:outline-none">
                            {{ __('Export CSV') }}
                        </a>
                        <a href="{{ route('reports.export.pdf', array_filter(['type' => $reportType, 'from' => $from, 'to' => $to])) }}" role="menuitem" x-on:click="actionsOpen = false" class="block px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-50 focus:bg-gray-50 focus:outline-none">
                            {{ __('Export PDF') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="mobile-record-table min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach ($headers as $header)
                                <th scope="col" class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($rows as $row)
                            <tr class="hover:bg-gray-50">
                                @foreach ($row as $value)
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">{{ $value ?: '—' }}</td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($headers) }}" class="px-6 py-10 text-center text-sm text-gray-500">{{ __('No records match the selected filters.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
