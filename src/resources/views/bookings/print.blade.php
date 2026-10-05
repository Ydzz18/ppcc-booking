@extends('layouts.print', [
    'title' => __('Booking ID').': '.$monitoring->id,
    'backUrl' => route('bookings.index', ['tab' => 'monitoring']),
    'downloadUrl' => route('bookings.pdf', $monitoring),
])

@section('content')
    @php
        $requiredFormsCompleted = $requiredForms->isNotEmpty() && $requiredForms->every(fn ($form) => $form['status'] === 'completed');
        $bookingStatus = $requiredFormsCompleted || strtolower((string) ($monitoring->submission_status ?? 'pending')) === 'completed' ? __('Completed') : __('Pending');
        $taskAgeDays = $monitoring->taskAgeInDays();
        $totalExpenses = $requiredForms->sum('expense_amount');
        $bookingDetails = [
            [__('Status'), $bookingStatus],
            [__('Task Age'), $taskAgeDays === null ? '—' : $taskAgeDays.' '.($taskAgeDays === 1 ? __('day') : __('days'))],
            [__('Submission Status'), ucfirst((string) ($monitoring->submission_status ?? 'pending'))],
        ];
    @endphp

    <header class="document-header">
        <h1>{{ __('Booking ID') }}: {{ $monitoring->id }}</h1>
        <p class="document-subheader">{{ __('Date Task Received') }}: {{ $monitoring->date_task_received?->format('F d, Y') ?? '—' }}</p>
    </header>

    <section class="section">
        <div class="booking-info-heading">
            <h2>{{ $monitoring->client?->client_name ?? '—' }}</h2>
            <h2>{{ __('Type of Task') }}: {{ $taskNames }}</h2>
        </div>
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
            @if ($isPdf ?? false)
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
        @endif
    </section>

    @if ($requiredForms->isNotEmpty())
        <section class="section expenses-section">
            <h2>{{ __('Expenses') }}</h2>
            @if ($isPdf ?? false)
                <table class="expenses">
                    <thead>
                        <tr><th>{{ __('Form / Document') }}</th><th>{{ __('Amount') }}</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($requiredForms as $form)
                            <tr>
                                <td>{{ $form['name'] }}</td>
                                <td>PHP {{ number_format($form['expense_amount'], 2) }}</td>
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
            @else
                <form method="POST" action="{{ route('bookings.print.expenses.update', $monitoring) }}" data-expenses-form @if ($errors->any()) data-start-editing @endif>
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

                    <table class="expenses">
                        <thead>
                            <tr><th>{{ __('Form / Document') }}</th><th>{{ __('Amount') }}</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($requiredForms as $form)
                                <tr>
                                    <td>{{ $form['name'] }}</td>
                                    <td>
                                        <span class="expense-print-value">PHP {{ number_format($form['expense_amount'], 2) }}</span>
                                        <label class="expense-edit-input" hidden>
                                            <span class="sr-only">{{ __('Expense for') }} {{ $form['name'] }}</span>
                                            <input data-expense-input data-original-value="{{ number_format($form['expense_amount'], 2, '.', '') }}" type="number" name="expenses[{{ $form['id'] }}]" min="0" step="0.01" required value="{{ old('expenses.'.$form['id'], number_format($form['expense_amount'], 2, '.', '')) }}">
                                        </label>
                                        @error('expenses.'.$form['id'])
                                            <p class="expense-error" role="alert">{{ $message }}</p>
                                        @enderror
                                    </td>
                                </tr>
                            @endforeach
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
    @endif

    @if ($monitoring->submission_notes)
        <section class="section">
            <h2>{{ __('Submission Notes') }}</h2>
            <p class="detail dd">{{ $monitoring->submission_notes }}</p>
        </section>
    @endif
@endsection