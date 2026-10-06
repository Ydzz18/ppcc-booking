<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-3">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Settings') }}</p>
                <h2 class="mt-1 text-xl font-semibold leading-tight text-gray-800">{{ __('Expenses List') }}</h2>
            </div>
            <button type="button" x-data x-on:click="$dispatch('open-modal', 'add-expense-catalog-item')" aria-label="{{ __('Add Expense') }}" title="{{ __('Add Expense') }}" class="inline-flex h-10 w-10 items-center justify-center rounded-md bg-gray-800 text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                </svg>
            </button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <section class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="space-y-5 p-5 sm:p-6">
                    @if (session('status') === 'expense-catalog-created')
                        <p class="text-sm text-green-700" role="status">{{ __('Expense added to the catalog.') }}</p>
                    @elseif (session('status') === 'expense-catalog-updated')
                        <p class="text-sm text-green-700" role="status">{{ __('Expense catalog item updated.') }}</p>
                    @elseif (session('status') === 'expense-catalog-deleted')
                        <p class="text-sm text-green-700" role="status">{{ __('Expense catalog item deleted.') }}</p>
                    @endif

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Catalog defaults') }}</h3>
                        <p class="mt-1 max-w-3xl text-sm text-gray-600">{{ __('These options are separate from required forms and documents. Default amounts are copied into a booking when an expense is first selected; saved booking amounts remain unchanged when catalog defaults are edited.') }}</p>
                    </div>

                    <ol class="grid gap-3 sm:grid-cols-3" aria-label="{{ __('How expense items are used') }}">
                        <li class="flex items-start gap-3 rounded-md border border-indigo-100 bg-indigo-50/60 p-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-indigo-600 text-xs font-bold text-white">1</span>
                            <span>
                                <span class="block text-sm font-semibold text-gray-900">{{ __('Set defaults') }}</span>
                                <span class="mt-0.5 block text-xs text-gray-600">{{ __('Manage reusable items here.') }}</span>
                            </span>
                        </li>
                        <li class="flex items-start gap-3 rounded-md border border-sky-100 bg-sky-50/60 p-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-sky-600 text-xs font-bold text-white">2</span>
                            <span>
                                <span class="block text-sm font-semibold text-gray-900">{{ __('Choose for a booking') }}</span>
                                <span class="mt-0.5 block text-xs text-gray-600">{{ __('Select items in the booking print view.') }}</span>
                            </span>
                        </li>
                        <li class="flex items-start gap-3 rounded-md border border-emerald-100 bg-emerald-50/60 p-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white">3</span>
                            <span>
                                <span class="block text-sm font-semibold text-gray-900">{{ __('Track actual costs') }}</span>
                                <span class="mt-0.5 block text-xs text-gray-600">{{ __('Saved amounts feed the expense report.') }}</span>
                            </span>
                        </li>
                    </ol>

                    <div class="overflow-x-auto rounded-md border border-gray-200">
                        <table class="mobile-record-table min-w-[600px] w-full divide-y divide-gray-200" data-mobile-title-column="0" data-mobile-summary-columns="1">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Expense item') }}</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Default amount (PHP)') }}</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($items as $item)
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $item->name }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-right text-sm tabular-nums text-gray-700">{{ number_format((float) $item->default_amount, 2) }}</td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="flex justify-end gap-2">
                                                <button type="button" x-data x-on:click="$dispatch('open-modal', 'edit-expense-catalog-item-{{ $item->id }}')" aria-label="{{ __('Edit') }}" title="{{ __('Edit') }}" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 2.651 2.651M8 16l3.8-.8L20 7a1.875 1.875 0 0 0-2.65-2.65l-8.2 8.2L8 16Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 14.5V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h4.5" />
                                                    </svg>
                                                </button>
                                                <form method="POST" action="{{ route('expense-catalog.destroy', $item) }}" data-confirm="{{ __('Are you sure you want to delete this expense item? Existing booking expense snapshots will be kept.') }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" aria-label="{{ __('Delete') }}" title="{{ __('Delete') }}" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-red-200 bg-white text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M10 11v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-10 text-center text-sm text-gray-600">{{ __('No expense items have been added yet. Add an item to make it available in booking print previews.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <p class="text-xs text-gray-500">{{ __('Existing booking snapshots keep their saved name and amount, even after a catalog item is renamed or its default changes.') }}</p>
                </div>
            </section>
        </div>
    </div>

    <x-modal name="add-expense-catalog-item" :show="$errors->hasAny(['name', 'default_amount']) && !old('editing_expense_catalog_id')" maxWidth="md" focusable>
        <form method="POST" action="{{ route('expense-catalog.store') }}" class="space-y-6 p-6">
            @csrf
            <div class="flex items-start justify-between gap-4 border-b border-gray-200 pb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Add Expense Item') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('Create a reusable catalog option and its starting amount.') }}</p>
                </div>
                <button type="button" x-on:click="$dispatch('close-modal', 'add-expense-catalog-item')" aria-label="{{ __('Close') }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-2xl leading-none text-gray-400 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">&times;</button>
            </div>
            <div>
                <x-input-label for="new_expense_name" :value="__('Expense name')" />
                <x-text-input id="new_expense_name" name="name" class="mt-1 block w-full" :value="old('name')" required maxlength="255" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <div>
                <x-input-label for="new_expense_amount" :value="__('Default amount (PHP)')" />
                <x-text-input id="new_expense_amount" name="default_amount" type="number" min="0" max="99999999.99" step="0.01" class="mt-1 block w-full" :value="old('default_amount', '0.00')" required />
                <x-input-error class="mt-2" :messages="$errors->get('default_amount')" />
            </div>
            <div class="flex justify-end gap-3 border-t border-gray-200 pt-4">
                <button type="button" x-on:click="$dispatch('close-modal', 'add-expense-catalog-item')" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 hover:bg-gray-50">{{ __('Cancel') }}</button>
                <x-primary-button>{{ __('Save Expense') }}</x-primary-button>
            </div>
        </form>
    </x-modal>

    @foreach ($items as $item)
        <x-modal name="edit-expense-catalog-item-{{ $item->id }}" :show="$errors->hasAny(['name', 'default_amount']) && (string) old('editing_expense_catalog_id') === (string) $item->id" maxWidth="md" focusable>
            <form method="POST" action="{{ route('expense-catalog.update', $item) }}" class="space-y-6 p-6">
                @csrf
                @method('PATCH')
                <input type="hidden" name="editing_expense_catalog_id" value="{{ $item->id }}">
                <div class="flex items-start justify-between gap-4 border-b border-gray-200 pb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Edit Expense Item') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Changes apply to future selections only.') }}</p>
                    </div>
                    <button type="button" x-on:click="$dispatch('close-modal', 'edit-expense-catalog-item-{{ $item->id }}')" aria-label="{{ __('Close') }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-2xl leading-none text-gray-400 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">&times;</button>
                </div>
                <div>
                    <x-input-label for="expense_name_{{ $item->id }}" :value="__('Expense name')" />
                    <x-text-input id="expense_name_{{ $item->id }}" name="name" class="mt-1 block w-full" :value="old('editing_expense_catalog_id') == $item->id ? old('name') : $item->name" required maxlength="255" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-input-label for="expense_amount_{{ $item->id }}" :value="__('Default amount (PHP)')" />
                    <x-text-input id="expense_amount_{{ $item->id }}" name="default_amount" type="number" min="0" max="99999999.99" step="0.01" class="mt-1 block w-full" :value="old('editing_expense_catalog_id') == $item->id ? old('default_amount') : $item->default_amount" required />
                    <x-input-error class="mt-2" :messages="$errors->get('default_amount')" />
                </div>
                <div class="flex justify-end gap-3 border-t border-gray-200 pt-4">
                    <button type="button" x-on:click="$dispatch('close-modal', 'edit-expense-catalog-item-{{ $item->id }}')" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 hover:bg-gray-50">{{ __('Cancel') }}</button>
                    <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
                </div>
            </form>
        </x-modal>
    @endforeach
</x-app-layout>
