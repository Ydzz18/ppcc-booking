@extends('layouts.print', [
    'title' => __('Booking Details'),
    'backUrl' => route('bookings.index', ['tab' => 'monitoring']),
    'downloadUrl' => route('bookings.pdf', $monitoring),
])

@section('content')
    @php
        $requiredFormsCompleted = $requiredForms->isNotEmpty() && $requiredForms->every(fn ($form) => $form['status'] === 'completed');
        $bookingStatus = $requiredFormsCompleted || strtolower((string) ($monitoring->submission_status ?? 'pending')) === 'completed' ? __('Completed') : __('Pending');
    @endphp

    <header class="document-header">
        <h1>{{ __('Booking Details') }}</h1>
        <p>{{ config('app.name', 'PPCC Booking') }}</p>
    </header>

    <section class="section">
        <h2>{{ __('Booking Information') }}</h2>
        <dl class="details">
            <div class="detail"><dt>{{ __('Booking ID') }}</dt><dd>{{ $monitoring->id }}</dd></div>
            <div class="detail"><dt>{{ __('Status') }}</dt><dd class="status">{{ $bookingStatus }}</dd></div>
            <div class="detail"><dt>{{ __('Date Task Received') }}</dt><dd>{{ $monitoring->date_task_received?->format('F d, Y') ?? '—' }}</dd></div>
            <div class="detail"><dt>{{ __('Client Name') }}</dt><dd>{{ $monitoring->client?->client_name ?? '—' }}</dd></div>
            <div class="detail"><dt>{{ __('Type of Task') }}</dt><dd>{{ $monitoring->task?->task_name ?? '—' }}</dd></div>
            <div class="detail"><dt>{{ __('Assigned Responsible Person') }}</dt><dd>{{ $monitoring->assignedResponsiblePerson?->contact_person ?? '—' }}</dd></div>
            <div class="detail"><dt>{{ __('Submission Status') }}</dt><dd class="status">{{ ucfirst((string) ($monitoring->submission_status ?? 'pending')) }}</dd></div>
            <div class="detail"><dt>{{ __('Date of Submission') }}</dt><dd>{{ $monitoring->date_of_submission?->format('F d, Y') ?? '—' }}</dd></div>
            <div class="detail"><dt>{{ __('Receiving Officer') }}</dt><dd>{{ $monitoring->receiving_officer ?? '—' }}</dd></div>
            <div class="detail"><dt>{{ __('Acknowledgement Receipt / Reference') }}</dt><dd>{{ $monitoring->acknowledgement_receipt_reference_number ?? '—' }}</dd></div>
        </dl>
    </section>

    <section class="section">
        <h2>{{ __('Required Forms and Documents') }}</h2>
        @if ($requiredForms->isEmpty())
            <p class="empty">{{ __('No forms or documents required.') }}</p>
        @else
            <table>
                <thead>
                    <tr><th>{{ __('Form / Document') }}</th><th>{{ __('Status') }}</th><th>{{ __('Notes / Remarks') }}</th><th>{{ __('Note Date') }}</th></tr>
                </thead>
                <tbody>
                    @foreach ($requiredForms as $form)
                        <tr>
                            <td>{{ $form['name'] }}</td>
                            <td class="status">{{ $form['status'] === 'completed' ? __('Completed') : __('Pending') }}</td>
                            <td>{{ $form['note'] ?: '—' }}</td>
                            <td>{{ $form['note_date']?->format('F d, Y') ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
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