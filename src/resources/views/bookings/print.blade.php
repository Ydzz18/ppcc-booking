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
<<<<<<< HEAD
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
=======
        $totalExpenses = $requiredForms->sum('expense_amount');
        $bookingDetails = [
            [__('Status'), $bookingStatus],
            [__('Task Age'), $taskAgeDays === null ? '—' : $taskAgeDays.' '.($taskAgeDays === 1 ? __('day') : __('days'))],
            [__('Submission Status'), ucfirst((string) ($monitoring->submission_status ?? 'pending'))],
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
        ];
    @endphp

    <header class="document-header">
        <h1>{{ __('Booking ID') }}: {{ $monitoring->id }}</h1>
        <p class="document-subheader">{{ __('Date Task Received') }}: {{ $monitoring->date_task_received?->format('F d, Y') ?? '—' }}</p>
    </header>

    <section class="section">
<<<<<<< HEAD
        <h2>{{ __('Booking Information') }}</h2>
=======
        <div class="booking-info-heading">
            <h2>{{ $monitoring->client?->client_name ?? '—' }}</h2>
            <h2>{{ __('Type of Task') }}: {{ $taskNames }}</h2>
        </div>
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
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
<<<<<<< HEAD
                    <tr><th>{{ __('Form / Document') }}</th><th>{{ __('Status') }}</th><th>{{ __('Notes / Remarks') }}</th><th>{{ __('Note Date') }}</th><th>{{ __('Amount (PHP)') }}</th></tr>
=======
                    <tr><th>{{ __('Form / Document') }}</th><th>{{ __('Quantity') }}</th><th>{{ __('Status') }}</th><th>{{ __('Notes / Remarks') }}</th><th>{{ __('Note Date') }}</th><th>{{ __('Expenses') }}</th></tr>
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
                </thead>
                <tbody>
                    @foreach ($requiredForms as $form)
                        <tr>
                            <td>{{ $form['name'] }}</td>
                            <td>{{ $form['quantity'] }}</td>
                            <td class="status">{{ $form['status'] === 'completed' ? __('Completed') : __('Pending') }}</td>
                            <td>{{ $form['note'] ?: '—' }}</td>
                            <td>{{ $form['note_date']?->format('F d, Y') ?? '—' }}</td>
<<<<<<< HEAD
                            <td>{{ number_format($form['expense_amount'], 2) }}</td>
=======
                            <td>PHP {{ number_format($form['expense_amount'], 2) }}</td>
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
<<<<<<< HEAD
                        <th colspan="4">{{ __('Total Expenses') }}</th>
                        <th>PHP {{ number_format((float) $requiredForms->sum('expense_amount'), 2) }}</th>
=======
                        <th colspan="5">{{ __('Total Expenses') }}</th>
                        <th>PHP {{ number_format($totalExpenses, 2) }}</th>
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
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