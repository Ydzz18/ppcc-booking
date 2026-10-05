<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ __('Expenses') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <section class="border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="space-y-6 p-5 sm:p-6">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Expense Tracker') }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Track expenses recorded on task monitoring entries.') }}</p>
                        </div>
                        <a href="{{ route('expenses.print', request()->query()) }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            {{ __('Print Report') }}
                        </a>
                    </div>

                    <form method="GET" action="{{ route('expenses.index') }}" class="grid gap-4 rounded-md border border-gray-200 p-4 sm:grid-cols-2 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_minmax(0,1.5fr)_auto] lg:items-end">
                        <div>
                            <x-input-label for="expense_from" :value="__('From')" />
                            <x-text-input id="expense_from" name="from" type="date" class="mt-1 block w-full" :value="$from" />
                        </div>
                        <div>
                            <x-input-label for="expense_to" :value="__('To')" />
                            <x-text-input id="expense_to" name="to" type="date" class="mt-1 block w-full" :value="$to" />
                        </div>
                        <div>
                            <x-input-label for="expense_search" :value="__('Search')" />
                            <x-text-input id="expense_search" name="search" type="search" class="mt-1 block w-full" :value="$search" placeholder="{{ __('Client, task, or expense item') }}" />
                        </div>
                        <button type="submit" class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2">
                            {{ __('Generate Report') }}
                        </button>
                    </form>

                    <div class="grid gap-4 border-y border-gray-200 py-4 sm:grid-cols-3">
                        <div>
                            <p class="text-xs font-semibold uppercase text-gray-500">{{ __('Total Expenses') }}</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">PHP {{ number_format($totalExpenses, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase text-gray-500">{{ __('Expense Items') }}</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ number_format($expenseCount) }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase text-gray-500">{{ __('Tasks') }}</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ number_format($taskCount) }}</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-md border border-gray-200">
                        <table class="min-w-[760px] w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">{{ __('Date Booked') }}</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">{{ __('Task ID') }}</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">{{ __('Client') }}</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">{{ __('Task') }}</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">{{ __('Expense item') }}</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-gray-500">{{ __('Amount (PHP)') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($entries as $entry)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-700">{{ $entry['date'] ? \Illuminate\Support\Carbon::parse($entry['date'])->format('M d, Y') : '—' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-900">{{ $entry['task_id'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $entry['client'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $entry['task'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $entry['item'] }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-right text-sm font-medium tabular-nums text-gray-900">{{ number_format($entry['amount'], 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500">{{ __('No expenses found for these filters.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if ($entries->isNotEmpty())
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <th colspan="5" class="px-4 py-3 text-right text-sm font-semibold text-gray-700">{{ __('Filtered Total') }}</th>
                                        <th class="px-4 py-3 text-right text-sm font-semibold tabular-nums text-gray-900">PHP {{ number_format($totalExpenses, 2) }}</th>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>

                    <div>{{ $entries->links() }}</div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>