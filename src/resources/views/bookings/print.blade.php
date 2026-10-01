@extends('layouts.print', [
    'title' => __('Booking Details'),
    'backUrl' => route('bookings.index', ['tab' => 'monitoring']),
    'downloadUrl' => route('bookings.pdf', $monitoring),
])

@section('content')
    @php
        $requiredFormsCompleted = $requiredForms->isNotEmpty() && $requiredForms->every(fn ($form) => $form['status'] === 'completed');
        $bookingStatus = $requiredFormsCompleted || strtolower((string) ($monitoring->submission_status ?? 'pending')) === 'completed' ? __('Completed') : __('Pending');
        $taskAgeDays = $monitoring->taskAgeInDays();
        $bookingDetails = [
            [__('Booking ID'), $monitoring->id],
            [__('Status'), $bookingStatus],
            [__('Date Task Received'), $monitoring->date_task_received?->format('F d, Y') ?? '—'],
            [__('Task Age'), $taskAgeDays === null ? '—' : $taskAgeDays.' '.($taskAgeDays === 1 ? __('day') : __('days'))],
            [__('Client Name'), $monitoring->client?->client_name ?? '—'],
            [__('Type of Task'), $monitoring->task?->task_name ?? '—'],
            [__('Client Name'), $monitoring->assignedResponsiblePerson?->contact_person ?? '—'],
            [__('Submission Status'), ucfirst((string) ($monitoring->submission_status ?? 'pending'))],
            [__('Date of Submission'), $monitoring->date_of_submission?->format('F d, Y') ?? '—'],
            [__('Receiving Officer'), $monitoring->receiving_officer ?? '—'],
            [__('Acknowledgement Receipt / Reference'), $monitoring->acknowledgement_receipt_reference_number ?? '—'],
        ];
    @endphp

    <header class="document-header">
        <h1>{{ __('Booking Details') }}</h1>
        <p>{{ config('app.name', 'PPCC Booking') }}</p>
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
                    <tr><th>{{ __('Form / Document') }}</th><th>{{ __('Status') }}</th><th>{{ __('Notes / Remarks') }}</th><th>{{ __('Note Date') }}</th><th>{{ __('Amount (PHP)') }}</th></tr>
                </thead>
                <tbody>
                    @foreach ($requiredForms as $form)
                        <tr>
                            <td>{{ $form['name'] }}</td>
                            <td class="status">{{ $form['status'] === 'completed' ? __('Completed') : __('Pending') }}</td>
                            <td>{{ $form['note'] ?: '—' }}</td>
                            <td>{{ $form['note_date']?->format('F d, Y') ?? '—' }}</td>
                            <td>{{ number_format($form['expense_amount'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">{{ __('Total Expenses') }}</th>
                        <th>PHP {{ number_format((float) $requiredForms->sum('expense_amount'), 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        @endif
    </section>

    @if ($monitoring->submission_notes)
        <section class="section">
            <h2>{{ __('Submission Notes') }}</h2>
            <p class="detail dd">{{ $monitoring->submission_notes }}</p>
        </section>
    @endif
@endsection