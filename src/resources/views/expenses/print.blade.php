@extends('layouts.print', [
    'title' => $title,
    'backUrl' => $backUrl,
    'downloadUrl' => $downloadUrl,
])

@section('content')
    <header class="document-header">
        <h1>{{ $title }}</h1>
        <p>{{ config('app.name', 'PPCC Booking') }} · {{ now()->format('F d, Y') }}</p>
    </header>

    <section class="section">
        <h2>{{ __('Report Filters') }}</h2>
        <p>{{ __('Date range') }}: {{ $from ?: __('All dates') }} – {{ $to ?: __('All dates') }}</p>
        @if ($search !== '')
            <p>{{ __('Search') }}: {{ $search }}</p>
        @endif
        <p>{{ __('Tasks') }}: {{ number_format($taskCount) }} · {{ __('Expense items') }}: {{ number_format($expenseCount) }} · {{ __('Total expenses') }}: PHP {{ number_format($totalExpenses, 2) }}</p>
    </section>

    <section class="section">
        <h2>{{ __('Expense Details') }}</h2>
        @if ($entries->isEmpty())
            <p class="empty">{{ __('No expenses found for these filters.') }}</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>{{ __('Date Booked') }}</th>
                        <th>{{ __('Task ID') }}</th>
                        <th>{{ __('Client') }}</th>
                        <th>{{ __('Task') }}</th>
                        <th>{{ __('Form or Document') }}</th>
                        <th>{{ __('Amount (PHP)') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entries as $entry)
                        <tr>
                            <td>{{ $entry['date'] ? \Illuminate\Support\Carbon::parse($entry['date'])->format('M d, Y') : '—' }}</td>
                            <td>{{ $entry['task_id'] }}</td>
                            <td>{{ $entry['client'] }}</td>
                            <td>{{ $entry['task'] }}</td>
                            <td>{{ $entry['form'] }}</td>
                            <td>{{ number_format($entry['amount'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5">{{ __('Total Expenses') }}</th>
                        <th>PHP {{ number_format($totalExpenses, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        @endif
    </section>
@endsection