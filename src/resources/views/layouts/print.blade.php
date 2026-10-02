<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }} - {{ config('app.name', 'PPCC Booking') }}</title>
        <style>
            :root { color-scheme: light; font-family: Arial, sans-serif; }
            * { box-sizing: border-box; }
            @page { margin: 14mm; }
            body { margin: 0; background: #f3f4f6; color: #111827; }
            .print-page { max-width: 1100px; margin: 0 auto; padding: 24px; }
            .print-toolbar { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 24px; }
            .print-actions { display: flex; align-items: center; gap: 8px; }
            .print-toolbar a, .print-toolbar button { border: 1px solid #d1d5db; border-radius: 6px; background: #fff; color: #1f2937; cursor: pointer; font-size: 14px; font-weight: 600; padding: 10px 16px; text-decoration: none; }
            .print-toolbar .print-button { border-color: #1d4ed8; background: #1d4ed8; color: #fff; }
            .print-toolbar .pdf-button { border-color: #047857; background: #047857; color: #fff; }
            .paper { background: #fff; border: 1px solid #e5e7eb; padding: 40px; }
            .document-header { border-bottom: 2px solid #111827; margin-bottom: 28px; padding-bottom: 18px; }
            .document-header h1 { font-size: 26px; margin: 0 0 8px; }
            .document-header p { color: #6b7280; font-size: 13px; margin: 0; }
            .document-header .document-subheader { color: #111827; font-size: 14px; font-weight: 600; margin-bottom: 4px; }
            .section { margin-top: 28px; }
            .section h2 { border-bottom: 1px solid #d1d5db; font-size: 15px; margin: 0 0 14px; padding-bottom: 8px; text-transform: uppercase; letter-spacing: .04em; }
<<<<<<< HEAD
=======
            .booking-info-heading { align-items: baseline; border-bottom: 1px solid #d1d5db; display: flex; gap: 16px; justify-content: space-between; margin-bottom: 14px; padding-bottom: 8px; }
            .booking-info-heading h2 { border: 0; margin: 0; min-width: 0; padding: 0; }
            .booking-info-heading h2:last-child { flex: 1; overflow-wrap: anywhere; text-align: right; }
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
            .details { border-collapse: collapse; table-layout: fixed; width: 100%; }
            .details td { border: 0; font-size: 14px; padding: 0 14px 16px 0; text-align: left; vertical-align: top; width: 50%; }
            .detail dt { color: #6b7280; font-size: 11px; font-weight: 700; margin-bottom: 4px; text-transform: uppercase; }
            .detail dd { font-size: 14px; margin: 0; white-space: pre-wrap; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid #d1d5db; font-size: 13px; padding: 10px; text-align: left; vertical-align: top; }
            th { background: #f9fafb; font-size: 11px; text-transform: uppercase; }
            .status { font-weight: 700; text-transform: capitalize; }
            .empty { color: #6b7280; font-size: 13px; }
            .pdf-document .print-page { max-width: none; padding: 0; }
            .pdf-document .paper { border: 0; padding: 0; }
            .pdf-document { background: #fff; }
            .pdf-document .section { margin-top: 24px; }
            .pdf-document .section h2 { margin-bottom: 12px; padding-bottom: 6px; }
<<<<<<< HEAD
=======
            .pdf-document .booking-info-heading { margin-bottom: 12px; padding-bottom: 6px; }
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
            .pdf-document .details td { padding-bottom: 12px; }
            .pdf-document .required-forms th,
            .pdf-document .required-forms td { line-height: 1.2; padding: 7px 8px; }
            @media (max-width: 640px) {
                .print-page { padding: 16px; }
                .paper { padding: 24px 18px; }
                .details { grid-template-columns: 1fr; }
                .booking-info-heading { align-items: flex-start; flex-direction: column; gap: 6px; }
                .booking-info-heading h2:last-child { text-align: left; }
            }
            @media print {
                body { background: #fff; }
                .print-page { max-width: none; padding: 0; }
                .print-toolbar { display: none; }
                .paper { border: 0; padding: 0; }
                .section, tr { break-inside: avoid; }
            }
        </style>
    </head>
    <body class="{{ ($isPdf ?? false) ? 'pdf-document' : '' }}">
        <main class="print-page">
            @unless ($isPdf ?? false)
                <div class="print-toolbar">
                    <a href="{{ $backUrl }}">{{ __('Back') }}</a>
                    <div class="print-actions">
                        <button type="button" class="print-button" onclick="window.print()">{{ __('Print') }}</button>
                        <a href="{{ $downloadUrl }}" class="pdf-button" download>{{ __('Save PDF') }}</a>
                    </div>
                </div>
            @endunless
            <article class="paper">
                @yield('content')
            </article>
        </main>
    </body>
</html>