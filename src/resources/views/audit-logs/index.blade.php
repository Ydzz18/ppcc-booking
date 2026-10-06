<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">{{ __('Administration') }}</p>
            <h2 class="mt-1 text-xl font-semibold text-gray-900">{{ __('Audit Logs') }}</h2>
        </div>
    </x-slot>

    <div class="space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <section class="mobile-filter-toolbar rounded-lg border border-gray-200 bg-white p-5 shadow-sm" aria-labelledby="audit-filter-title">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h1 id="audit-filter-title" class="text-lg font-semibold text-gray-900">{{ __('Activity history') }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ __('Review recorded account and data changes.') }}</p>
                </div>
                <span class="text-sm text-gray-500">{{ $logs->total() }} {{ __('events') }}</span>
            </div>

            <form method="GET" action="{{ route('audit-logs.index') }}" class="mt-5 grid gap-3 sm:grid-cols-[minmax(0,1fr)_220px_auto] sm:items-end">
                <div>
                    <label for="audit-search" class="block text-sm font-medium text-gray-700">{{ __('Search') }}</label>
                    <input id="audit-search" name="search" type="search" value="{{ $search }}" placeholder="{{ __('Actor, action, record, route, or IP') }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900">
                </div>
                <div>
                    <label for="audit-event" class="block text-sm font-medium text-gray-700">{{ __('Event') }}</label>
                    <select id="audit-event" name="event" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900">
                        <option value="">{{ __('All events') }}</option>
                        @foreach ($events as $eventOption)
                            <option value="{{ $eventOption }}" @selected($event === $eventOption)>{{ str_replace('.', ' / ', $eventOption) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2.5 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">{{ __('Filter') }}</button>
                    <a href="{{ route('audit-logs.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 px-4 py-2.5 text-xs font-semibold uppercase tracking-widest text-gray-700 hover:bg-gray-50">{{ __('Clear') }}</a>
                </div>
            </form>
        </section>

        <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm" aria-label="{{ __('Audit log entries') }}">
            <div class="overflow-x-auto">
                <table class="mobile-record-table min-w-full divide-y divide-gray-200" data-mobile-title-column="2" data-mobile-summary-columns="0,1">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Date and time') }}</th>
                            <th scope="col" class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Actor') }}</th>
                            <th scope="col" class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Event') }}</th>
                            <th scope="col" class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Record') }}</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Changed fields') }}</th>
                            <th scope="col" class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Request') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($logs as $log)
                            <tr class="align-top hover:bg-gray-50">
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">{{ $log->created_at?->format('M j, Y g:i:s A') }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-700">{{ $log->actor_name ?? __('System / unknown') }}<span class="mt-1 block text-xs text-gray-400">{{ $log->actor_id ? '#'.$log->actor_id : '' }}</span></td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm font-medium text-gray-800">{{ str_replace('.', ' / ', $log->event) }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">{{ $log->subject_type ? class_basename($log->subject_type).' #'.$log->subject_id : '—' }}</td>
                                <td class="max-w-sm px-5 py-4 text-sm text-gray-600">{{ $log->changed_fields ? implode(', ', $log->changed_fields) : '—' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">{{ $log->route_name ?? '—' }}<span class="mt-1 block text-xs text-gray-400">{{ $log->ip_address }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center text-sm text-gray-500">{{ __('No audit events match your filters.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($logs->hasPages())
                <div class="border-t border-gray-200 px-5 py-4">{{ $logs->links() }}</div>
            @endif
        </section>
    </div>
</x-app-layout>