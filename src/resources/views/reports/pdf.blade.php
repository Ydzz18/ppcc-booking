<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>{{ $title }}</title>
        <style>
            @page { margin: 30px 28px; }
            * { box-sizing: border-box; }
            body { color: #172033; font-family: DejaVu Sans, sans-serif; font-size: 10px; }
            .masthead { border-bottom: 3px solid #0f766e; margin-bottom: 18px; padding-bottom: 12px; }
            .brand { color: #0f766e; font-size: 10px; font-weight: bold; letter-spacing: 1.6px; text-transform: uppercase; }
            h1 { color: #172033; font-size: 22px; margin: 5px 0 4px; }
            .subtitle { color: #64748b; font-size: 10px; margin: 0; }
            .summary { border-collapse: separate; border-spacing: 0; margin-bottom: 20px; width: 100%; }
            .summary td { background: #f0fdfa; border: 0; border-right: 1px solid #ccfbf1; padding: 10px 12px; width: 33.33%; }
            .summary td:last-child { border-right: 0; }
            .summary-label { color: #64748b; display: block; font-size: 8px; font-weight: bold; letter-spacing: .7px; text-transform: uppercase; }
            .summary-value { color: #115e59; display: block; font-size: 12px; font-weight: bold; margin-top: 4px; }
            table { border-collapse: collapse; width: 100%; }
            .report-table { border: 1px solid #cbd5e1; }
            th, td { border-bottom: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; padding: 8px 9px; text-align: left; vertical-align: top; }
            th:last-child, td:last-child { border-right: 0; }
            th { background: #1e3a4a; color: #fff; font-size: 8px; letter-spacing: .4px; text-transform: uppercase; }
            td { color: #334155; font-size: 9.5px; }
            tbody tr:nth-child(even) td { background: #f8fafc; }
            tbody tr:last-child td { border-bottom: 0; }
            thead { display: table-header-group; }
            tr { page-break-inside: avoid; }
            .empty { border: 1px solid #cbd5e1; color: #64748b; padding: 18px; }
            .footer { border-top: 1px solid #cbd5e1; color: #94a3b8; font-size: 8px; margin-top: 18px; padding-top: 8px; }
        </style>
    </head>
    <body>
        <header class="masthead">
            <div class="brand">{{ config('app.name', 'PPCC Booking') }}</div>
            <h1>{{ $title }}</h1>
            <p class="subtitle">{{ __('Official report document') }}</p>
        </header>

        <table class="summary">
            <tr>
                <td>
                    <span class="summary-label">{{ __('Records') }}</span>
                    <span class="summary-value">{{ count($rows) }}</span>
                </td>
                <td>
                    <span class="summary-label">{{ __('Date range') }}</span>
                    <span class="summary-value">{{ $from ?: '—' }} - {{ $to ?: '—' }}</span>
                </td>
                <td>
                    <span class="summary-label">{{ __('Generated') }}</span>
                    <span class="summary-value">{{ now()->format('M d, Y h:i A') }}</span>
                </td>
            </tr>
        </table>

        @if (count($rows))
            <table class="report-table">
                <thead>
                    <tr>
                        @foreach ($headers as $header)
                            <th>{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $row)
                        <tr>
                            @foreach ($row as $value)
                                <td>{{ $value ?: '—' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">{{ __('No records match the selected filters.') }}</p>
        @endif

        <div class="footer">{{ __('Prepared for internal business use') }}</div>
    </body>
</html>