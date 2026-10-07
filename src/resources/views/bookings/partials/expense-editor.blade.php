@php
    $savedCatalogExpenses = collect($savedExpenses ?? [])
        ->filter(fn ($expense) => is_array($expense) && isset($expense['catalog_id']))
        ->keyBy(fn ($expense) => (int) $expense['catalog_id']);
    $savedOtherExpenses = collect($savedExpenses ?? [])
        ->filter(fn ($expense) => is_array($expense) && array_key_exists('catalog_id', $expense) && $expense['catalog_id'] === null)
        ->map(fn ($expense) => [
            'name' => $expense['catalog_name'] ?? '',
            'amount' => number_format((float) ($expense['expense_amount'] ?? 0), 2, '.', ''),
        ])
        ->values()
        ->all();
    $expenseAmounts = collect(old('expenses', $savedCatalogExpenses->mapWithKeys(fn ($expense, $id) => [
        $id => number_format((float) $expense['expense_amount'], 2, '.', ''),
    ])->all()));
    $otherExpenseValues = collect(old('other_expenses', $savedOtherExpenses));
    $initialExpenseTotal = (float) $expenseAmounts->sum(fn ($amount) => (float) $amount)
        + (float) $otherExpenseValues->sum(fn ($expense) => (float) ($expense['amount'] ?? 0));
@endphp

<section class="rounded-xl border border-gray-200 p-3 sm:p-5 {{ $expenseEditorGridSpan ?? '' }}" aria-labelledby="{{ $expenseEditorId }}-heading" data-booking-expense-editor>
    <div class="mb-3">
        <h4 id="{{ $expenseEditorId }}-heading" class="text-sm font-semibold text-gray-900">{{ __('Expenses') }}</h4>
        <p class="mt-1 text-xs text-gray-500">{{ __('Choose catalog items, enter amounts, or add a custom expense.') }}</p>
    </div>

    @error('expenses')
        <p class="mb-3 text-sm text-red-600" role="alert">{{ $message }}</p>
    @enderror
    @error('other_expenses')
        <p class="mb-3 text-sm text-red-600" role="alert">{{ $message }}</p>
    @enderror

    <fieldset @disabled(($expenseEditorDisabled ?? false) && ! $errors->any()) @if ($expenseEditorDisabled ?? false) x-bind:disabled="!isBookingFieldsEditable" @endif class="space-y-3">
        <legend class="sr-only">{{ __('Select expense items') }}</legend>
        <input type="hidden" name="expense_editor_submitted" value="1">
        <div class="grid gap-2 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($expenseCatalog as $item)
                @php
                    $savedExpense = $savedCatalogExpenses->get($item->id);
                    $selected = $expenseAmounts->has((string) $item->id) || $expenseAmounts->has($item->id);
                    $amount = old('expenses.'.$item->id, $savedExpense['expense_amount'] ?? number_format((float) $item->default_amount, 2, '.', ''));
                @endphp
                <div class="grid grid-cols-[minmax(0,1fr)_6rem] items-center gap-2 rounded-lg border border-gray-200 bg-white p-2.5">
                    <label for="{{ $expenseEditorId }}-expense-{{ $item->id }}" class="flex min-w-0 cursor-pointer items-start gap-2 text-sm text-gray-700">
                        <input id="{{ $expenseEditorId }}-expense-{{ $item->id }}"
                            type="checkbox"
                            data-expense-catalog-toggle
                            value="{{ $item->id }}"
                            data-default-amount="{{ number_format((float) $item->default_amount, 2, '.', '') }}"
                            @checked($selected)
                            aria-controls="{{ $expenseEditorId }}-amount-{{ $item->id }}"
                            class="mt-0.5 shrink-0 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="break-words">{{ $savedExpense['catalog_name'] ?? $item->name }}</span>
                    </label>
                    <label class="sr-only" for="{{ $expenseEditorId }}-amount-{{ $item->id }}">{{ __('Amount for') }} {{ $savedExpense['catalog_name'] ?? $item->name }}</label>
                    <input id="{{ $expenseEditorId }}-amount-{{ $item->id }}"
                        type="number"
                        name="expenses[{{ $item->id }}]"
                        data-expense-amount
                        min="0"
                        max="99999999.99"
                        step="0.01"
                        value="{{ $amount }}"
                        @disabled(! $selected)
                        @required($selected)
                        class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @if ($errors->has('expenses.'.$item->id))
                        <p class="col-span-full text-xs text-red-600" role="alert">{{ $errors->first('expenses.'.$item->id) }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="space-y-2" data-other-expense-rows>
            @foreach ($otherExpenseValues as $index => $otherExpense)
                <div class="grid grid-cols-1 items-center gap-2 rounded-lg border border-gray-200 bg-white p-2.5 sm:grid-cols-[minmax(0,1fr)_6rem_auto]" data-other-expense-row>
                    <label class="flex min-w-0 items-center gap-2 text-sm text-gray-700">
                        <span class="shrink-0 font-medium">{{ __('Other') }}:</span>
                        <input type="text"
                            name="other_expenses[{{ $index }}][name]"
                            value="{{ $otherExpense['name'] ?? '' }}"
                            maxlength="255"
                            required
                            placeholder="{{ __('Others:') }}"
                            aria-label="{{ __('Other expense name') }}"
                            data-other-expense-name
                            class="min-w-0 flex-1 rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </label>
                    <div>
                        <label class="sr-only" for="{{ $expenseEditorId }}-other-amount-{{ $index }}">{{ __('Amount for') }} {{ $otherExpense['name'] ?? __('Other') }}</label>
                        <input type="number"
                            id="{{ $expenseEditorId }}-other-amount-{{ $index }}"
                            name="other_expenses[{{ $index }}][amount]"
                            value="{{ $otherExpense['amount'] ?? '' }}"
                            min="0"
                            max="99999999.99"
                            step="0.01"
                            required
                            data-expense-amount
                            class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <button type="button" data-remove-other-expense class="rounded-md border border-gray-300 px-2.5 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50">{{ __('Remove') }}</button>
                    @if ($errors->has('other_expenses.'.$index.'.name'))
                        <p class="col-span-full text-xs text-red-600" role="alert">{{ $errors->first('other_expenses.'.$index.'.name') }}</p>
                    @endif
                    @if ($errors->has('other_expenses.'.$index.'.amount'))
                        <p class="col-span-full text-xs text-red-600" role="alert">{{ $errors->first('other_expenses.'.$index.'.amount') }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <button type="button" data-add-other-expense class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-xs font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            {{ __('Add Other') }}
        </button>
    </fieldset>

    <template data-other-expense-template>
        <div class="grid grid-cols-1 items-center gap-2 rounded-lg border border-gray-200 bg-white p-2.5 sm:grid-cols-[minmax(0,1fr)_6rem_auto]" data-other-expense-row>
            <label class="flex min-w-0 items-center gap-2 text-sm text-gray-700">
                <span class="shrink-0 font-medium">{{ __('Other') }}:</span>
                <input type="text" maxlength="255" required placeholder="{{ __('Others:') }}" aria-label="{{ __('Other expense name') }}" data-other-expense-name class="min-w-0 flex-1 rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </label>
            <div>
                <label class="sr-only" for="{{ $expenseEditorId }}-other-amount-new">{{ __('Amount for Other') }}</label>
                <input type="number" min="0" max="99999999.99" step="0.01" required data-expense-amount class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <button type="button" data-remove-other-expense class="rounded-md border border-gray-300 px-2.5 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50">{{ __('Remove') }}</button>
        </div>
    </template>

    <p class="mt-3 text-sm font-semibold text-gray-900">{{ __('Total Expenses') }}: PHP <span data-expense-total>{{ number_format($initialExpenseTotal, 2) }}</span></p>
</section>
