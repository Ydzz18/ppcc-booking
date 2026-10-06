<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
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
<<<<<<< HEAD
            .paper { position: relative; background: #fff; border: 1px solid #e5e7eb; padding: 40px; }
            .print-watermark { position: fixed; top: 50%; left: 50%; z-index: 0; width: 420px; height: 420px; margin: -210px 0 0 -210px; opacity: .08; pointer-events: none; }
            .print-content { position: relative; z-index: 1; }
=======
            .paper { background: #fff; border: 1px solid #e5e7eb; padding: 40px; }
>>>>>>> cc7605a1efaea1247a2e66aae0df46dc30feaed1
            .document-header { border-bottom: 2px solid #111827; margin-bottom: 28px; padding-bottom: 18px; }
            .document-header h1 { font-size: 26px; margin: 0 0 8px; }
            .document-header p { color: #6b7280; font-size: 13px; margin: 0; }
            .document-header .document-subheader { color: #111827; font-size: 14px; font-weight: 600; margin-bottom: 4px; }
            .section { margin-top: 28px; }
            .section h2 { border-bottom: 1px solid #d1d5db; font-size: 15px; margin: 0 0 14px; padding-bottom: 8px; text-transform: uppercase; letter-spacing: .04em; }
            .booking-info-heading { align-items: baseline; border-bottom: 1px solid #d1d5db; display: flex; gap: 16px; justify-content: space-between; margin-bottom: 14px; padding-bottom: 8px; }
            .booking-info-heading h2 { border: 0; margin: 0; min-width: 0; padding: 0; }
            .booking-info-heading h2:last-child { flex: 1; overflow-wrap: anywhere; text-align: right; }
            .details { border-collapse: collapse; table-layout: fixed; width: 100%; }
            .details td { border: 0; font-size: 14px; padding: 0 14px 16px 0; text-align: left; vertical-align: top; width: 50%; }
            .detail dt { color: #6b7280; font-size: 11px; font-weight: 700; margin-bottom: 4px; text-transform: uppercase; }
            .detail dd { font-size: 14px; margin: 0; white-space: pre-wrap; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid #d1d5db; font-size: 13px; padding: 10px; text-align: left; vertical-align: top; }
            th { background: #f9fafb; font-size: 11px; text-transform: uppercase; }
            .status { font-weight: 700; text-transform: capitalize; }
            .empty { color: #6b7280; font-size: 13px; }
            .print-edit-controls { display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
            .print-edit-controls button { border: 1px solid #1d4ed8; border-radius: 6px; background: #1d4ed8; color: #fff; cursor: pointer; font-size: 13px; font-weight: 600; padding: 8px 12px; }
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> cc7605a1efaea1247a2e66aae0df46dc30feaed1
            .print-edit-controls button:focus-visible, .expense-picker summary:focus-visible, .expense-options input:focus-visible { outline: 2px solid #1d4ed8; outline-offset: 2px; }
            .expense-picker { margin: 0 0 12px; }
            .expense-picker summary { cursor: pointer; display: inline-block; font-size: 13px; font-weight: 600; padding: 8px 0; }
            .expense-options { border: 1px solid #d1d5db; border-radius: 6px; display: grid; gap: 8px; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); margin: 4px 0 0; max-height: 220px; min-width: 0; overflow-y: auto; padding: 12px; }
            .expense-options label { align-items: flex-start; display: flex; gap: 8px; font-size: 13px; }
            .expense-options input { flex: 0 0 auto; margin-top: 2px; }
<<<<<<< HEAD
>>>>>>> 518d7ea95a1541f4f357009b0848c9673b28e59b
=======
>>>>>>> cc7605a1efaea1247a2e66aae0df46dc30feaed1
            .expense-edit-input input { width: 130px; border: 1px solid #9ca3af; border-radius: 4px; padding: 6px 8px; text-align: right; }
            .expense-error { color: #b91c1c; font-size: 12px; margin: 4px 0; }
            .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0; }
            .pdf-document .print-page { max-width: none; padding: 0; }
            .pdf-document .paper { border: 0; padding: 0; }
            .pdf-document { background: #fff; }
            .pdf-document .section { margin-top: 24px; }
            .pdf-document .section h2 { margin-bottom: 12px; padding-bottom: 6px; }
            .pdf-document .booking-info-heading { margin-bottom: 12px; padding-bottom: 6px; }
            .pdf-document .details td { padding-bottom: 12px; }
            .pdf-document .required-forms th,
            .pdf-document .required-forms td,
            .pdf-document .expenses th,
            .pdf-document .expenses td { line-height: 1.2; padding: 7px 8px; }
            @media (max-width: 640px) {
                .print-page { padding: 16px; }
                .paper { padding: 24px 18px; }
                .details { grid-template-columns: 1fr; }
                .booking-info-heading { align-items: flex-start; flex-direction: column; gap: 6px; }
                .booking-info-heading h2:last-child { text-align: left; }
                .expense-edit-input input { max-width: 100%; width: 110px; }
                .expense-options { grid-template-columns: 1fr; }
            }
            @media print {
                body { background: #fff; }
                .print-page { max-width: none; padding: 0; }
<<<<<<< HEAD
<<<<<<< HEAD
                .print-toolbar, .print-edit-controls, .expense-edit-input, .expense-error { display: none !important; }
                .expense-print-value { display: inline !important; }
                .expense-edit-input[hidden] { display: none !important; }
=======
                .print-toolbar, .print-edit-controls, .expense-picker, .expense-edit-input, .expense-error, .expense-edit-name { display: none !important; }
                .expense-print-value { display: inline !important; }
>>>>>>> 518d7ea95a1541f4f357009b0848c9673b28e59b
=======
                .print-toolbar, .print-edit-controls, .expense-picker, .expense-edit-input, .expense-error, .expense-edit-name { display: none !important; }
                .expense-print-value { display: inline !important; }
                .expense-edit-input[hidden] { display: none !important; }
>>>>>>> cc7605a1efaea1247a2e66aae0df46dc30feaed1
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
                        <a href="{{ $downloadUrl }}" class="pdf-button" @if ($saveExpensesBeforePdf ?? false) data-save-expenses-pdf @endif download>{{ __('Save PDF') }}</a>
                    </div>
                </div>
            @endunless
            <article class="paper">
<<<<<<< HEAD
                <img class="print-watermark" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('watermark.png'))) }}" alt="" aria-hidden="true">
                <div class="print-content">
                    @yield('content')
                </div>
=======
                @yield('content')
>>>>>>> cc7605a1efaea1247a2e66aae0df46dc30feaed1
            </article>
        </main>
        <script>
            document.querySelectorAll('[data-expenses-form]').forEach((form) => {
                const editButton = form.querySelector('[data-edit-expenses]');
                const saveButton = form.querySelector('[data-save-expenses]');
                const cancelButton = form.querySelector('[data-cancel-expenses]');
                const inputs = [...form.querySelectorAll('[data-expense-input]')];
<<<<<<< HEAD
<<<<<<< HEAD
                const total = form.querySelector('[data-expense-total]');

                const updateTotal = () => {
                    const sum = inputs.reduce((amount, input) => amount + Number(input.value || 0), 0);
                    total.textContent = `PHP ${sum.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
=======
=======
>>>>>>> cc7605a1efaea1247a2e66aae0df46dc30feaed1
                const rows = [...form.querySelectorAll('[data-expense-row]')];
                const toggles = [...form.querySelectorAll('[data-expense-toggle]')];
                const picker = form.querySelector('[data-expense-picker]');
                const emptyRow = form.querySelector('[data-expense-empty]');
                const total = form.querySelector('[data-expense-total]');
                const pdfButton = document.querySelector('[data-save-expenses-pdf]');

                const updateTotal = () => {
                    const sum = inputs.reduce((amount, input) => amount + (input.disabled ? 0 : Number(input.value || 0)), 0);
                    total.textContent = `PHP ${sum.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    rows.forEach((row) => {
                        const input = row.querySelector('[data-expense-input]');
                        const value = row.querySelector('[data-expense-print-amount]');
                        value.textContent = `PHP ${Number(input.value || 0).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    });
                };
                const updateSelection = (toggle) => {
                    const row = form.querySelector(`#expense-row-${toggle.value}`);
                    const input = row.querySelector('[data-expense-input]');
                    const selected = toggle.checked;
                    row.hidden = !selected;
                    input.disabled = !selected;
                    if (selected && input.value === '') input.value = toggle.dataset.defaultAmount;
                    if (emptyRow) emptyRow.hidden = rows.some((candidate) => !candidate.hidden);
                    updateTotal();
<<<<<<< HEAD
>>>>>>> 518d7ea95a1541f4f357009b0848c9673b28e59b
=======
>>>>>>> cc7605a1efaea1247a2e66aae0df46dc30feaed1
                };
                const setEditing = (editing) => {
                    editButton.hidden = editing;
                    saveButton.hidden = !editing;
                    cancelButton.hidden = !editing;
<<<<<<< HEAD
<<<<<<< HEAD
                    form.querySelectorAll('.expense-print-value').forEach((value) => { value.hidden = editing; });
                    form.querySelectorAll('.expense-edit-input').forEach((field) => { field.hidden = !editing; });
                };

                editButton.addEventListener('click', () => setEditing(true));
                cancelButton.addEventListener('click', () => {
                    inputs.forEach((input) => { input.value = input.dataset.originalValue; });
=======
=======
>>>>>>> cc7605a1efaea1247a2e66aae0df46dc30feaed1
                    picker.hidden = !editing;
                    picker.open = editing;
                    form.querySelectorAll('.expense-print-value').forEach((value) => { value.hidden = editing; });
                    form.querySelectorAll('.expense-edit-input').forEach((field) => { field.hidden = !editing; });
                    form.querySelectorAll('.expense-edit-name').forEach((value) => { value.hidden = !editing; });
                };

                editButton.addEventListener('click', () => setEditing(true));
                pdfButton?.addEventListener('click', (event) => {
                    event.preventDefault();

                    let downloadInput = form.querySelector('[name="download_pdf"]');
                    if (!downloadInput) {
                        downloadInput = document.createElement('input');
                        downloadInput.type = 'hidden';
                        downloadInput.name = 'download_pdf';
                        form.append(downloadInput);
                    }
                    downloadInput.value = '1';
                    form.requestSubmit(saveButton);
                });
                cancelButton.addEventListener('click', () => {
                    inputs.forEach((input) => { input.value = input.dataset.originalValue; });
                    toggles.forEach((toggle) => {
                        toggle.checked = toggle.dataset.originalChecked === 'true';
                        updateSelection(toggle);
                    });
<<<<<<< HEAD
>>>>>>> 518d7ea95a1541f4f357009b0848c9673b28e59b
=======
>>>>>>> cc7605a1efaea1247a2e66aae0df46dc30feaed1
                    updateTotal();
                    setEditing(false);
                });
                inputs.forEach((input) => input.addEventListener('input', updateTotal));
<<<<<<< HEAD
<<<<<<< HEAD
=======
                toggles.forEach((toggle) => toggle.addEventListener('change', () => updateSelection(toggle)));
                toggles.forEach(updateSelection);
>>>>>>> 518d7ea95a1541f4f357009b0848c9673b28e59b
=======
                toggles.forEach((toggle) => toggle.addEventListener('change', () => updateSelection(toggle)));
                toggles.forEach(updateSelection);
>>>>>>> cc7605a1efaea1247a2e66aae0df46dc30feaed1

                if (form.hasAttribute('data-start-editing')) setEditing(true);
            });
        </script>
    </body>
</html>