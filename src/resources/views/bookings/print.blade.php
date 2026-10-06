@extends('layouts.print', [
    'title' => __('Booking ID').': '.$monitoring->id,
    'backUrl' => route('bookings.index', ['tab' => 'monitoring']),
    'downloadUrl' => route('bookings.pdf', $monitoring),
    'saveExpensesBeforePdf' => true,
])

@section('content')
    @php
        $requiredFormsCompleted = $requiredForms->isNotEmpty() && $requiredForms->every(fn ($form) => $form['status'] === 'completed');
        $bookingStatus = $requiredFormsCompleted || strtolower((string) ($monitoring->submission_status ?? 'pending')) === 'completed' ? __('Completed') : __('Pending');
        $taskAgeDays = $monitoring->taskAgeInDays();
        $totalExpenses = $expenses->sum('expense_amount');
        $savedExpenseAmounts = $expenses->where('is_other', false)->mapWithKeys(fn ($expense) => [(string) $expense['id'] => number_format($expense['expense_amount'], 2, '.', '')])->all();
        $expenseAmounts = collect(old('expenses', $savedExpenseAmounts));
        $selectedExpenseIds = $expenseAmounts->keys()->map(fn ($id) => (string) $id)->all();
        $savedExpensesById = $expenses->where('is_other', false)->keyBy('id');
        $savedOtherExpenses = $expenses->where('is_other', true)->values();
        $otherExpenseValues = collect(old('other_expenses', $savedOtherExpenses->map(fn ($expense) => [
            'name' => $expense['name'],
            'amount' => number_format($expense['expense_amount'], 2, '.', ''),
        ])->all()));
        $bookingDetails = [
            [__('Booking ID'), $monitoring->id],
            [__('Status'), $bookingStatus],
            [__('Date Task Received'), $monitoring->date_task_received?->format('F d, Y') ?? '—'],
            [__('Task Age'), $taskAgeDays === null ? '—' : $taskAgeDays.' '.($taskAgeDays === 1 ? __('day') : __('days'))],
            [__('Client Name'), $monitoring->client?->client_name ?? '—'],
            [__('Type of Task'), $taskNames],
            [__('Assigned Responsible Person'), $monitoring->assignedResponsiblePerson?->contact_person ?? '—'],
            [__('Submission Status'), ucfirst((string) ($monitoring->submission_status ?? 'pending'))],
            [__('Date of Submission'), $monitoring->date_of_submission?->format('F d, Y') ?? '—'],
            [__('Receiving Officer'), $monitoring->receiving_officer ?? '—'],
            [__('Acknowledgement Receipt / Reference'), $monitoring->acknowledgement_receipt_reference_number ?? '—'],
        ];
    @endphp

    <header class="document-header">
        <h1>{{ __('Booking ID') }}: {{ $monitoring->id }}</h1>
        <p class="document-subheader">{{ __('Date Task Received') }}: {{ $monitoring->date_task_received?->format('F d, Y') ?? '—' }}</p>
    </header>

    <section class="section">
        <h2>{{ __('Booking Information') }}</h2>
        <table class="details">
            <tbody>
                @foreach (array_chunk($bookingDetails, 2) as $detailsRow)
                    <tr>
                        @foreach ($detailsRow as [$label, $value])
                            <td>
                                <dl class="detail">
                                    <dt>{{ $label }}</dt>
                                    <dd @class(['status' => in_array($label, [__('Status'), __('Submission Status')], true)])>{{ $value ?: '—' }}</dd>
                                </dl>
                            </td>
                        @endforeach
                        @if (count($detailsRow) === 1)
                            <td></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <section class="section">
        <h2>{{ __('Required Forms and Documents') }}</h2>
        @if ($requiredForms->isEmpty())
            <p class="empty">{{ __('No forms or documents required.') }}</p>
        @else
            <table class="required-forms">
                <thead>
                    <tr><th>{{ __('Form / Document') }}</th><th>{{ __('Quantity') }}</th><th>{{ __('Status') }}</th><th>{{ __('Notes / Remarks') }}</th><th>{{ __('Note Date') }}</th></tr>
                </thead>
                <tbody>
                    @foreach ($requiredForms as $form)
                        <tr>
                            <td>{{ $form['name'] }}</td>
                            <td>{{ $form['quantity'] }}</td>
                            <td class="status">{{ $form['status'] === 'completed' ? __('Completed') : __('Pending') }}</td>
                            <td>{{ $form['note'] ?: '—' }}</td>
                            <td>{{ $form['note_date']?->format('F d, Y') ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>

    <section class="section">
        <h2>{{ __('Expenses') }}</h2>
        @if (($isPdf ?? false))
            @if ($expenses->isEmpty())
                <p class="empty">{{ __('No expenses recorded.') }}</p>
            @else
                <table class="expenses">
                    <thead>
                        <tr><th>{{ __('Expense item') }}</th><th>{{ __('Amount (PHP)') }}</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr>
                                <td>{{ $expense['name'] }}</td>
                                <td>PHP {{ number_format($expense['expense_amount'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total Expenses') }}</th>
                            <th>PHP {{ number_format($totalExpenses, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            @endif
        @else
            <form method="POST" action="{{ route('bookings.print.expenses.update', $monitoring) }}" data-expenses-form @if ($errors->has('expenses') || $errors->has('other_expenses') || old('expenses') !== null || old('other_expenses') !== null) data-start-editing @endif>
                @csrf
                @method('PATCH')
                <div class="print-edit-controls">
                    @if (session('status') === 'expenses-updated')
                        <p role="status">{{ __('Expenses updated successfully.') }}</p>
                    @endif
                    <button type="button" data-edit-expenses>{{ __('Edit Expenses') }}</button>
                    <button type="submit" data-save-expenses hidden>{{ __('Save Expenses') }}</button>
                    <button type="button" data-cancel-expenses hidden>{{ __('Cancel') }}</button>
                </div>
                @error('expenses')
                    <p class="expense-error" role="alert">{{ $message }}</p>
                @enderror
                @error('other_expenses')
                    <p class="expense-error" role="alert">{{ $message }}</p>
                @enderror

                <details class="expense-picker" data-expense-picker hidden>
                    <summary>{{ __('Choose catalog expenses') }}</summary>
                    <fieldset class="expense-options">
                        <legend class="sr-only">{{ __('Select expenses to include in this booking') }}</legend>
                        @forelse ($expenseCatalog as $item)
                            @php
                                $savedExpense = $savedExpensesById->get($item->id);
                                $snapshotName = $savedExpense['name'] ?? $item->name;
                            @endphp
                            <label>
                                <input type="checkbox"
                                    data-expense-toggle
                                    value="{{ $item->id }}"
                                    data-default-amount="{{ number_format((float) $item->default_amount, 2, '.', '') }}"
                                    data-original-checked="{{ $savedExpense ? 'true' : 'false' }}"
                                    @checked(in_array((string) $item->id, $selectedExpenseIds, true))
                                    aria-controls="expense-row-{{ $item->id }}">
                                <span>{{ $snapshotName }}</span>
                            </label>
                        @empty
                            <p class="empty">{{ __('No catalog expenses are available. Add them from Settings → Expenses List.') }}</p>
                        @endforelse
                    </fieldset>
                    <button type="button" data-add-other-expense>{{ __('Add Other') }}</button>
                </details>

                <table class="expenses">
                    <thead>
                        <tr><th>{{ __('Expense item') }}</th><th>{{ __('Amount (PHP)') }}</th></tr>
                    </thead>
                    <tbody data-expense-rows>
                        @foreach ($expenseCatalog as $item)
                            @php
                                $savedExpense = $savedExpensesById->get($item->id);
                                $selected = in_array((string) $item->id, $selectedExpenseIds, true);
                                $amount = old('expenses.'.$item->id, $savedExpense['expense_amount'] ?? number_format((float) $item->default_amount, 2, '.', ''));
                            @endphp
                            <tr id="expense-row-{{ $item->id }}" data-expense-row data-expense-id="{{ $item->id }}" @if (!$selected) hidden @endif>
                                <td>
                                    <span class="expense-print-value">{{ $savedExpense['name'] ?? $item->name }}</span>
                                    <span class="expense-edit-name" hidden>{{ $savedExpense['name'] ?? $item->name }}</span>
                                </td>
                                <td>
                                    <span class="expense-print-value" data-expense-print-amount>PHP {{ number_format((float) ($savedExpense['expense_amount'] ?? $amount), 2) }}</span>
                                    <label class="expense-edit-input" hidden>
                                        <span class="sr-only">{{ __('Amount for') }} {{ $savedExpense['name'] ?? $item->name }}</span>
                                        <input data-expense-input
                                            data-original-value="{{ $savedExpense['expense_amount'] ?? '' }}"
                                            type="number"
                                            name="expenses[{{ $item->id }}]"
                                            min="0"
                                            max="99999999.99"
                                            step="0.01"
                                            required
                                            value="{{ $amount }}"
                                            @disabled(!$selected)>
                                    </label>
                                    @error('expenses.'.$item->id)
                                        <p class="expense-error" role="alert">{{ $message }}</p>
                                    @enderror
                                </td>
                            </tr>
                        @endforeach
                        @foreach ($otherExpenseValues as $index => $otherExpense)
                            <tr data-expense-row data-other-expense-row>
                                <td>
                                    <span class="expense-print-value" data-expense-print-name>{{ $otherExpense['name'] ?? '' }}</span>
                                    <label class="expense-edit-name" hidden>{{ __('Other') }}:
                                        <input data-other-expense-name type="text" name="other_expenses[{{ $index }}][name]" data-original-name="{{ $savedOtherExpenses->get($index)['name'] ?? '' }}" maxlength="255" required placeholder="{{ __('Others:') }}" value="{{ $otherExpense['name'] ?? '' }}">
                                    </label>
                                    @if ($errors->has('other_expenses.'.$index.'.name'))
                                        <p class="expense-error" role="alert">{{ $errors->first('other_expenses.'.$index.'.name') }}</p>
                                    @endif
                                </td>
                                <td>
                                    <span class="expense-print-value" data-expense-print-amount>PHP {{ number_format((float) ($otherExpense['amount'] ?? 0), 2) }}</span>
                                    <label class="expense-edit-input" hidden>
                                        <span class="sr-only">{{ __('Amount for') }} {{ $otherExpense['name'] ?? __('Other') }}</span>
                                        <input data-expense-input
                                            data-original-value="{{ $savedOtherExpenses->get($index)['expense_amount'] ?? '' }}"
                                            type="number"
                                            name="other_expenses[{{ $index }}][amount]"
                                            min="0"
                                            max="99999999.99"
                                            step="0.01"
                                            required
                                            value="{{ $otherExpense['amount'] ?? '' }}">
                                    </label>
                                    @if ($errors->has('other_expenses.'.$index.'.amount'))
                                        <p class="expense-error" role="alert">{{ $errors->first('other_expenses.'.$index.'.amount') }}</p>
                                    @endif
                                    <button type="button" data-remove-other-expense class="expense-edit-name" hidden>{{ __('Remove') }}</button>
                                </td>
                            </tr>
                        @endforeach
                        <tr data-expense-empty @if ($expenses->isNotEmpty() || old('expenses') !== null || old('other_expenses') !== null) hidden @endif>
                            <td colspan="2" class="empty">{{ __('No expenses recorded. Choose Edit Expenses to add catalog items.') }}</td>
                        </tr>
                        <template data-other-expense-template>
                            <tr data-expense-row data-other-expense-row data-new-other-expense>
                                <td>
                                    <span class="expense-print-value" data-expense-print-name hidden></span>
                                    <label class="expense-edit-name">{{ __('Other') }}:
                                        <input data-other-expense-name type="text" maxlength="255" required placeholder="{{ __('Others:') }}">
                                    </label>
                                </td>
                                <td>
                                    <span class="expense-print-value" data-expense-print-amount hidden></span>
                                    <label class="expense-edit-input">
                                        <span class="sr-only">{{ __('Amount for Other') }}</span>
                                        <input data-expense-input type="number" min="0" max="99999999.99" step="0.01" required>
                                    </label>
                                    <button type="button" data-remove-other-expense class="expense-edit-name">{{ __('Remove') }}</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total Expenses') }}</th>
                            <th><span data-expense-total>PHP {{ number_format($totalExpenses, 2) }}</span></th>
                        </tr>
                    </tfoot>
                </table>
            </form>
        @endif
    </section>

    @if ($monitoring->submission_notes)
        <section class="section">
            <h2>{{ __('Submission Notes') }}</h2>
            <p class="detail dd">{{ $monitoring->submission_notes }}</p>
        </section>
    @endif
@endsection