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
                    <p class="mt-2 text-sm text-gray-500">{{ __('Choose a record type and date range, then export it for Excel.') }}</p>
                </div>
                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">{{ count($rows) }} {{ __('records') }}</span>
            </div>

            <form method="GET" action="{{ route('reports.index') }}" class="mt-6 grid gap-4 md:grid-cols-[minmax(0,1fr)_180px_180px_auto] md:items-end">
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
                <a href="{{ route('reports.export', array_filter(['type' => $reportType, 'from' => $from, 'to' => $to])) }}" class="inline-flex items-center gap-2 rounded-md bg-emerald-700 px-4 py-2.5 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:ring-offset-2">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2" />
                    </svg>
                    {{ __('Export CSV') }}
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
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
