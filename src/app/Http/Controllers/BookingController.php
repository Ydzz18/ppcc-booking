<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FormItem;
use App\Models\Task;
use App\Models\TaskMonitoring;
use App\Models\TaskMonitoringFormNote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Show booking form.
     */
    public function index(): View
    {
        $clients = Client::query()
            ->select(['id', 'client_name'])
            ->orderBy('client_name')
            ->get();

        $contactPersons = Client::query()
            ->select(['id', 'contact_person'])
            ->whereNotNull('contact_person')
            ->where('contact_person', '!=', '')
            ->orderBy('contact_person')
            ->get();

        $tasks = Task::query()
            ->select(['id', 'agency', 'task_name', 'required_forms_documents'])
            ->orderBy('task_name')
            ->get();

        $forms = FormItem::query()
            ->select(['id', 'form_name', 'expense_amount'])
            ->orderBy('form_name')
            ->get();

        // Paginate with eager loading to reduce N+1
        $monitorings = TaskMonitoring::query()
            ->with([
                'client:id,client_name',
                'task:id,task_name',
                'assignedResponsiblePerson:id,contact_person',
                'formNotes:task_monitoring_id,form_id,note_status',
            ])
            ->latest('created_at')
            ->paginate(10, ['*'], 'monitorings_page');

        $formNamesById = $forms->pluck('form_name', 'id');

        // Build lookup maps from eager-loaded relations
        $formStatusesByMonitoringAndForm = [];
        foreach ($monitorings as $monitoring) {
            foreach ($monitoring->formNotes as $note) {
                $formStatusesByMonitoringAndForm[$monitoring->id.'-'.$note->form_id] = strtolower((string) $note->note_status);
            }
        }

<<<<<<< HEAD
        $formExpensesById = $forms->pluck('expense_amount', 'id');

        return view('bookings', compact('clients', 'contactPersons', 'tasks', 'forms', 'monitorings', 'formNamesById', 'formExpensesById', 'formStatusesByMonitoringAndForm'));
=======
        $taskNamesById = $tasks->pluck('task_name', 'id');

        return view('bookings', compact('clients', 'contactPersons', 'tasks', 'forms', 'monitorings', 'formNamesById', 'formStatusesByMonitoringAndForm', 'taskNamesById'));
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
    }

    /**
     * Store a newly created monitoring task entry.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $taskIds = array_values(array_unique(array_map('intval', (array) $request->input('type_of_task', []))));
        $request->merge(['type_of_task' => $taskIds]);

        $validated = $request->validate([
            'date_task_received' => ['required', 'date'],
            'client_name' => ['required', 'integer', 'exists:clients,id'],
            'type_of_task' => ['required', 'array', 'min:1'],
            'type_of_task.*' => ['integer', 'distinct', 'exists:tasks,id'],
            'required_forms_documents' => ['nullable', 'array'],
            'required_forms_documents.*' => ['integer', 'exists:forms,id'],
<<<<<<< HEAD
            'task_expenses' => ['nullable', 'array'],
            'task_expenses.*' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
=======
            'required_forms_quantities' => ['nullable', 'array'],
            'required_forms_quantities.*' => ['required', 'integer', 'min:1'],
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
        ]);

        $requiredFormIds = collect($validated['required_forms_documents'] ?? [])->map(fn ($id) => (int) $id)->unique()->values()->all();
        $requiredFormQuantities = collect($requiredFormIds)->mapWithKeys(fn (int $formId) => [
            $formId => max(1, (int) ($validated['required_forms_quantities'][$formId] ?? 1)),
        ])->all();

        TaskMonitoring::create([
            'date_task_received' => $validated['date_task_received'],
            'client_id' => $validated['client_name'],
            'task_id' => $validated['type_of_task'][0],
            'task_ids' => $validated['type_of_task'],
            'assigned_responsible_person_id' => $validated['client_name'],
<<<<<<< HEAD
            'required_forms_documents' => $validated['required_forms_documents'] ?? [],
            'expenses_breakdown' => $this->expenseBreakdown(
                $validated['required_forms_documents'] ?? [],
                [],
                $validated['task_expenses'] ?? []
=======
            'required_forms_documents' => $requiredFormIds,
            'required_forms_quantities' => $requiredFormQuantities,
            'expenses_breakdown' => $this->expenseBreakdown(
                $requiredFormIds,
                [],
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
            ),
            'submission_status' => 'pending',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => __('Task created successfully.'),
            ], 201);
        }

        return Redirect::route('bookings.index')->with('status', 'task-created');
    }

    /**
     * Show the form for editing the specified monitoring entry.
     */
    public function edit(Request $request, TaskMonitoring $monitoring): View
    {
        $clients = Client::query()
            ->select(['id', 'client_name'])
            ->orderBy('client_name')
            ->get();

        $tasks = Task::query()
            ->select(['id', 'task_name'])
            ->orderBy('task_name')
            ->get();

        $contactPersons = Client::query()
            ->select(['id', 'contact_person'])
            ->whereNotNull('contact_person')
            ->where('contact_person', '!=', '')
            ->orderBy('contact_person')
            ->get();

        $forms = FormItem::query()
            ->select(['id', 'form_name', 'expense_amount'])
            ->orderBy('form_name')
            ->get();

        $notesByForm = TaskMonitoringFormNote::query()
            ->where('task_monitoring_id', $monitoring->id)
            ->get()
            ->keyBy('form_id')
            ->map(fn (TaskMonitoringFormNote $note) => [
                'notes_remarks' => $note->notes_remarks,
                'note_date' => $note->note_date ? Carbon::parse($note->note_date)->format('Y-m-d') : null,
                'note_status' => $note->note_status,
            ]);

        $showSubmissionForm = $request->boolean('show_submission_form')
            || ! empty($monitoring->date_of_submission)
            || ! empty($monitoring->receiving_officer)
            || ! empty($monitoring->acknowledgement_receipt_reference_number);

        return view('task-monitorings.edit', compact('monitoring', 'clients', 'tasks', 'contactPersons', 'forms', 'notesByForm', 'showSubmissionForm'));
    }

    /**
     * Show a print-ready preview of the specified booking.
     */
    public function print(TaskMonitoring $monitoring): View
    {
        $requiredForms = $this->requiredFormsForPrint($monitoring);
        $taskNames = $this->taskNamesForMonitoring($monitoring);

        return view('bookings.print', compact('monitoring', 'requiredForms', 'taskNames'));
    }

    /**
     * Download a PDF of the specified booking.
     */
    public function downloadPdf(TaskMonitoring $monitoring)
    {
        $requiredForms = $this->requiredFormsForPrint($monitoring);
        $taskNames = $this->taskNamesForMonitoring($monitoring);

        return Pdf::loadView('bookings.print', compact('monitoring', 'requiredForms', 'taskNames') + ['isPdf' => true])
            ->download('booking-'.$monitoring->id.'.pdf');
    }

    /**
     * Load the booking data shared by the preview and PDF responses.
     */
    private function requiredFormsForPrint(TaskMonitoring $monitoring)
    {
        $monitoring->load(['client', 'task', 'assignedResponsiblePerson']);

        $requiredFormIds = collect($monitoring->required_forms_documents ?? [])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();
        $formsById = FormItem::query()
            ->whereIn('id', $requiredFormIds)
            ->get()
            ->keyBy('id');
        $notesByForm = TaskMonitoringFormNote::query()
            ->where('task_monitoring_id', $monitoring->id)
            ->get()
            ->keyBy('form_id');
<<<<<<< HEAD
        $expensesByFormId = collect($monitoring->expenses_breakdown ?? [])
=======
        $expensesByForm = collect($monitoring->expenses_breakdown ?? [])
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
            ->keyBy(fn (array $expense) => (int) ($expense['form_id'] ?? 0));

        return $requiredFormIds->map(fn (int $formId) => [
            'name' => $formsById->get($formId)?->form_name ?? __('Unknown form'),
            'status' => strtolower(trim((string) ($notesByForm->get($formId)?->note_status ?? 'pending'))),
            'note' => $notesByForm->get($formId)?->notes_remarks,
            'note_date' => $notesByForm->get($formId)?->note_date,
<<<<<<< HEAD
            'expense_amount' => (float) ($expensesByFormId->get($formId)['expense_amount'] ?? $formsById->get($formId)?->expense_amount ?? 0),
=======
            'quantity' => max(1, (int) ($monitoring->required_forms_quantities[$formId] ?? 1)),
            'expense_amount' => (float) ($expensesByForm->get($formId)['expense_amount'] ?? $formsById->get($formId)?->expense_amount ?? 0),
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
        ]);
    }

    private function taskNamesForMonitoring(TaskMonitoring $monitoring): string
    {
        $taskIds = collect($monitoring->task_ids ?: [$monitoring->task_id])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        $taskNames = Task::query()->whereIn('id', $taskIds)->orderBy('task_name')->pluck('task_name');

        return $taskNames->isNotEmpty() ? $taskNames->implode(', ') : '—';
    }

    /**
     * Update the specified monitoring entry.
     */
    public function update(Request $request, TaskMonitoring $monitoring): RedirectResponse
    {
        $taskIds = array_values(array_unique(array_map('intval', (array) $request->input('type_of_task', []))));
        $request->merge(['type_of_task' => $taskIds]);

        $validated = $request->validate([
            'date_task_received' => ['required', 'date'],
            'client_name' => ['required', 'integer', 'exists:clients,id'],
            'type_of_task' => ['required', 'array', 'min:1'],
            'type_of_task.*' => ['integer', 'distinct', 'exists:tasks,id'],
            'assigned_responsible_person' => ['required', 'integer', 'exists:clients,id'],
            'required_forms_documents' => ['nullable', 'array'],
            'required_forms_documents.*' => ['integer', 'exists:forms,id'],
            'required_forms_quantities' => ['nullable', 'array'],
            'required_forms_quantities.*' => ['required', 'integer', 'min:1'],
            'date_of_submission' => ['nullable', 'date'],
            'receiving_officer' => ['nullable', 'string', 'max:255'],
            'acknowledgement_receipt_reference_number' => ['nullable', 'string', 'max:255'],
            'submission_decision' => ['nullable', 'string', 'in:pending,declined,accepted'],
            'submission_notes' => ['nullable', 'string'],
            'submission_notes_input' => ['nullable', 'string'],
            'existing_submission_notes' => ['nullable', 'string'],
        ]);

        $existingSubmissionNotes = trim((string) ($validated['existing_submission_notes'] ?? ($validated['submission_notes'] ?? $monitoring->submission_notes ?? '')));
        $newSubmissionNote = trim((string) ($validated['submission_notes_input'] ?? ''));

        $combinedSubmissionNotes = $existingSubmissionNotes;

        if ($newSubmissionNote !== '') {
            $combinedSubmissionNotes = $existingSubmissionNotes === ''
                ? $newSubmissionNote
                : $existingSubmissionNotes."\n".$newSubmissionNote;
        }

<<<<<<< HEAD
        $requiredFormIds = $validated['required_forms_documents'] ?? [];
=======
        $requiredFormIds = collect($validated['required_forms_documents'] ?? [])->map(fn ($id) => (int) $id)->unique()->values()->all();
        $requiredFormQuantities = collect($requiredFormIds)->mapWithKeys(fn (int $formId) => [
            $formId => max(1, (int) ($validated['required_forms_quantities'][$formId] ?? $monitoring->required_forms_quantities[$formId] ?? 1)),
        ])->all();
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
        $expensesBreakdown = $this->expenseBreakdown($requiredFormIds, $monitoring->expenses_breakdown ?? []);

        $monitoring->update([
            'date_task_received' => $validated['date_task_received'],
            'client_id' => $validated['client_name'],
            'task_id' => $validated['type_of_task'][0],
            'task_ids' => $validated['type_of_task'],
            'assigned_responsible_person_id' => $validated['assigned_responsible_person'],
            'required_forms_documents' => $requiredFormIds,
<<<<<<< HEAD
=======
            'required_forms_quantities' => $requiredFormQuantities,
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
            'expenses_breakdown' => $expensesBreakdown,
            'date_of_submission' => $validated['date_of_submission'] ?? null,
            'receiving_officer' => $validated['receiving_officer'] ?? null,
            'acknowledgement_receipt_reference_number' => $validated['acknowledgement_receipt_reference_number'] ?? null,
            'submission_decision' => $validated['submission_decision'] ?? null,
            'submission_notes' => $combinedSubmissionNotes !== '' ? $combinedSubmissionNotes : null,
            'submission_status' => ($validated['submission_decision'] ?? null) === 'accepted' ? 'completed' : 'pending',
        ]);

        return Redirect::route('bookings.edit', ['monitoring' => $monitoring, 'show_submission_form' => 1])
            ->withFragment('submission-action')
            ->with('status', 'task-updated');
    }

    /**
     * Remove the specified task monitoring entry.
     */
    public function destroy(TaskMonitoring $monitoring): RedirectResponse
    {
        $monitoring->delete();

        return Redirect::route('bookings.index', ['tab' => 'monitoring'])
            ->with('status', 'task-deleted');
    }

    /**
     * Save notes/remarks for a required form under a monitoring entry.
     */
    public function saveFormNote(Request $request, TaskMonitoring $monitoring): RedirectResponse
    {
        $validated = $request->validate([
            'form_id' => ['required', 'integer', 'exists:forms,id'],
            'notes_remarks_input' => ['nullable', 'string'],
            'existing_notes_remarks' => ['nullable', 'string'],
            'note_date' => ['nullable', 'date'],
            'note_status' => ['required', 'string', 'in:completed,pending'],
        ]);

        $existingRemarks = trim((string) ($validated['existing_notes_remarks'] ?? ''));
        $newRemark = trim((string) ($validated['notes_remarks_input'] ?? ''));

        $combinedRemarks = $existingRemarks;

        if ($newRemark !== '') {
            $combinedRemarks = $existingRemarks === ''
                ? $newRemark
                : $existingRemarks."\n".$newRemark;
        }

        TaskMonitoringFormNote::updateOrCreate(
            [
                'task_monitoring_id' => $monitoring->id,
                'form_id' => $validated['form_id'],
            ],
            [
                'notes_remarks' => $combinedRemarks !== '' ? $combinedRemarks : null,
                'note_date' => $validated['note_date'] ?? null,
                'note_status' => $validated['note_status'],
            ]
        );

        return Redirect::route('bookings.edit', $monitoring)->with('status', 'form-note-saved');
    }

    /** @param array<int, int|string> $formIds
     *  @return array<int, array{form_id: int, form_name: string, expense_amount: float}>
     */
<<<<<<< HEAD
    private function expenseBreakdown(array $formIds, array $existingBreakdown = [], array $expenseOverrides = []): array
=======
    private function expenseBreakdown(array $formIds, array $existingBreakdown = []): array
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
    {
        $existingByFormId = collect($existingBreakdown)
            ->filter(fn ($expense) => isset($expense['form_id']))
            ->keyBy(fn ($expense) => (int) $expense['form_id']);
        $newFormIds = collect($formIds)
            ->map(fn ($formId) => (int) $formId)
            ->reject(fn (int $formId) => $existingByFormId->has($formId));
        $formsById = FormItem::query()
            ->whereIn('id', $newFormIds)
            ->get(['id', 'form_name', 'expense_amount'])
            ->keyBy('id');

        return collect($formIds)
            ->map(fn ($formId) => $existingByFormId->get((int) $formId) ?? $formsById->get((int) $formId))
            ->filter()
            ->map(fn ($form) => is_array($form) ? $form : [
                'form_id' => (int) $form->id,
                'form_name' => $form->form_name,
<<<<<<< HEAD
                'expense_amount' => (float) ($expenseOverrides[$form->id] ?? $form->expense_amount),
=======
                'expense_amount' => (float) $form->expense_amount,
>>>>>>> 1a7868b8dbad2a38810a6b76f4e019c747f9568d
            ])
            ->values()
            ->all();
    }
}
