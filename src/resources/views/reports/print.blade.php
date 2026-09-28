@extends('layouts.print', [
    'title' => __($title),
    'backUrl' => route('reports.index', array_filter(['type' => $reportType, 'from' => $from, 'to' => $to])),
    'downloadUrl' => route('reports.export.pdf', array_filter(['type' => $reportType, 'from' => $from, 'to' => $to])),
])

@section('content')
    <header class="document-header">
        <h1>{{ __($title) }}</h1>
        <p>{{ config('app.name', 'PPCC Booking') }}</p>
    </header>

    @if ($from || $to)
        <p class="report-range">
            {{ __('Date range') }}:
            {{ $from ?: __('Beginning') }} - {{ $to ?: __('Present') }}
        </p>
    @endif

    <section class="section">
        @if (empty($rows))
            <p class="empty">{{ __('No records found.') }}</p>
        @else
            <table>
                <thead>
                    <tr>
                        @foreach ($headers as $header)
                            <th>{{ __($header) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $row)
                        <tr>
                            @foreach ($row as $value)
                                <td>{{ $value ?? '—' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>
@endsection
