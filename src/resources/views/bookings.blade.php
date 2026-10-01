<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6" x-data="{ activeMenu: '{{ request('tab') === 'monitoring' ? 'monitoring' : 'entry' }}', taskCreatedModalOpen: @js(session('status') === 'task-created') }">
                    @if (session('status') === 'task-created')
                        <div x-show="taskCreatedModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4" role="dialog" aria-modal="true" aria-labelledby="task-created-title">
                            <div class="w-full max-w-sm rounded-lg bg-white p-6 text-center shadow-xl">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-green-600" aria-hidden="true">
                                    <svg class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.704 5.29a1 1 0 010 1.42l-7.2 7.2a1 1 0 01-1.414 0l-3.2-3.2a1 1 0 011.414-1.42l2.493 2.494 6.493-6.494a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 id="task-created-title" class="mt-4 text-lg font-semibold text-gray-900">{{ __('Task created successfully') }}</h3>
                                <p class="mt-2 text-sm text-gray-600">{{ __('Your task has been added to Task Monitoring.') }}</p>
                                <a href="{{ route('bookings.index', ['tab' => 'monitoring']) }}" class="mt-6 inline-flex w-full items-center justify-center rounded-md bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    {{ __('Continue') }}
                                </a>
                            </div>
                        </div>
                    @endif
                    <div>

                    @if (session('status') === 'task-updated')
                        <p class="text-sm text-green-600">{{ __('Task entry updated successfully.') }}</p>
                    @endif

                    @if (session('status') === 'task-deleted')
                        <p class="text-sm text-green-600">{{ __('Task entry deleted successfully.') }}</p>
                    @endif

                    <div id="job-task-entry-section" class="max-w-7xl mx-auto" x-show="activeMenu === 'entry'">
                        <div class="border border-gray-200 rounded-lg p-6" x-data="{ taskOptions: @js($tasks->map(fn ($task) => ['id' => $task->id, 'agency' => $task->agency, 'task_name' => $task->task_name, 'required_forms_documents' => $task->required_forms_documents ?? []])->values()), formExpenseOptions: @js($forms->map(fn ($form) => ['id' => (string) $form->id, 'name' => $form->form_name, 'expense' => (float) $form->expense_amount])->values()), taskExpenses: @js($forms->mapWithKeys(fn ($form) => [(string) $form->id => (float) old('task_expenses.'.$form->id, $form->expense_amount)])->all()), selectedAgency: '', selectedTaskId: @js((string) old('type_of_task', '')), selectedTaskRequiredForms: [], additionalFormsOpen: false, totalSelectedExpenses() { return this.formExpenseOptions.filter(form => this.selectedTaskRequiredForms.includes(form.id)).reduce((total, form) => total + Number(this.taskExpenses[form.id] ?? form.expense ?? 0), 0); }, selectAgency() { this.selectedTaskId = ''; this.selectedTaskRequiredForms = []; this.additionalFormsOpen = false; }, selectTask(event) { const task = this.taskOptions.find(task => String(task.id) === String(event.target.value)); this.selectedAgency = task?.agency || this.selectedAgency; this.selectedTaskId = event.target.value; this.selectedTaskRequiredForms = (task?.required_forms_documents || []).map(String); this.additionalFormsOpen = false; } }" x-init="const initialTask = taskOptions.find(task => String(task.id) === selectedTaskId); if (initialTask) { selectedAgency = initialTask.agency; selectedTaskRequiredForms = (initialTask.required_forms_documents || []).map(String); }">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Task Entry') }}</h3>
                                <x-primary-button form="task-entry-form">{{ __('Create Task') }}</x-primary-button>
                            </div>

                        <form id="task-entry-form" method="POST" action="{{ route('bookings.store') }}" data-monitoring-refresh-url="{{ route('bookings.index', ['tab' => 'monitoring']) }}" class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-4" data-confirm="Are you sure you want to create this task?" data-async-monitoring-entry>
                            @csrf
                            <div id="task-entry-feedback" class="hidden md:col-span-4 rounded-md px-4 py-3 text-sm" role="status" aria-live="polite"></div>

                            <div class="md:col-span-2 rounded-md border border-gray-200 p-4">
                                <x-input-label :value="__('Task Selection')" />
                                <div class="mt-2 grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <x-input-label for="task_agency" :value="__('Agency')" />
                                        <select id="task_agency" x-model="selectedAgency" x-on:change="selectAgency()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">{{ __('Select Agency') }}</option>
                                            @foreach ($tasks->pluck('agency')->filter()->unique()->sort()->values() as $agency)
                                                <option value="{{ $agency }}">{{ $agency }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="type_of_task" :value="__('Type of Task')" />
                                        <select id="type_of_task" name="type_of_task" x-on:change="selectTask($event)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">{{ __('Select Task') }}</option>
                                            <template x-for="task in taskOptions.filter(task => selectedAgency === '' || task.agency === selectedAgency)" :key="task.id">
                                                <option x-bind:value="task.id" x-bind:selected="String(task.id) === selectedTaskId" x-text="task.task_name"></option>
                                            </template>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('type_of_task')" />
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">{{ __('Choose an agency to filter task types, then select a task to load its required forms and documents.') }}</p>
                            </div>

                            <div>
                                <x-input-label for="date_task_received" :value="__('Date Task Received')" />
                                <x-text-input id="date_task_received" name="date_task_received" type="date" class="mt-1 block w-full" :value="old('date_task_received', now()->toDateString())" />
                                <x-input-error class="mt-2" :messages="$errors->get('date_task_received')" />
                            </div>

                            <div>
                                <x-input-label for="client_name" :value="__('Client Name')" />
                                <select id="client_name" name="client_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">{{ __('Select Client') }}</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" @selected((string) old('client_name') === (string) $client->id)>{{ $client->client_name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('client_name')" />
                            </div>

                            <div class="md:col-span-4">
                                <x-input-label for="required_forms_documents" :value="__('List of Required Forms and Documents')" />
                                <div id="required_forms_documents" class="mt-1 max-h-48 overflow-y-auto rounded-md border border-gray-300 p-3">
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between gap-4 px-3 text-xs font-semibold uppercase text-gray-500">
                                            <span>{{ __('Form or Requirement') }}</span>
                                            <span>{{ __('Expense') }}</span>
                                        </div>
                                        @foreach ($forms as $form)
                                            <div x-show="selectedTaskRequiredForms.includes('{{ $form->id }}')" x-cloak class="flex items-center justify-between gap-4 rounded-md border border-gray-200 px-3 py-2 text-sm text-gray-700">
                                                <input type="hidden" name="required_forms_documents[]" value="{{ $form->id }}" data-form-name="{{ $form->form_name }}" x-bind:disabled="!selectedTaskRequiredForms.includes('{{ $form->id }}')">
                                                <span class="min-w-0 break-words">{{ $form->form_name }}</span>
                                                <label class="flex shrink-0 items-center gap-2 font-medium">
                                                    <span class="text-xs text-gray-500">PHP</span>
                                                    <input type="number" name="task_expenses[{{ $form->id }}]" min="0" step="0.01" x-model.number="taskExpenses['{{ $form->id }}']" x-bind:disabled="!selectedTaskRequiredForms.includes('{{ $form->id }}')" class="w-28 rounded-md border-gray-300 py-1 text-right text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" aria-label="{{ __('Expense for') }} {{ $form->form_name }}">
                                                </label>
                                            </div>
                                        @endforeach
                                        <p x-show="selectedTaskRequiredForms.length === 0" x-cloak class="text-sm text-gray-500">{{ __('Select a task to view its required forms and documents.') }}</p>
                                    </div>
                                </div>
                                <button type="button" x-on:click="additionalFormsOpen = !additionalFormsOpen" x-bind:disabled="!selectedTaskId" class="mt-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50">
                                    {{ __('Add Additional Form') }}
                                </button>
                                <div x-show="additionalFormsOpen" x-cloak class="mt-3 rounded-md border border-gray-200 p-3">
                                    <p class="mb-2 text-sm font-medium text-gray-700">{{ __('Select additional forms and documents') }}</p>
                                    <div class="max-h-48 space-y-1 overflow-y-auto">
                                        @foreach ($forms as $form)
                                            <button type="button" x-show="!selectedTaskRequiredForms.includes('{{ $form->id }}')" x-on:click="selectedTaskRequiredForms.push('{{ $form->id }}')" class="block w-full rounded px-2 py-1.5 text-left text-sm text-gray-700 hover:bg-gray-100">
                                                {{ $form->form_name }}
                                            </button>
                                        @endforeach
                                    </div>
                                    <button type="button" x-on:click="additionalFormsOpen = false" class="mt-2 text-sm font-medium text-gray-600 hover:text-gray-900">{{ __('Done') }}</button>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('required_forms_documents')" />

                                <div class="mt-3 flex items-center justify-between gap-4 rounded-md border border-gray-200 px-4 py-3 text-sm font-semibold">
                                    <span>{{ __('Total Expenses') }}</span>
                                    <span x-text="'PHP ' + totalSelectedExpenses().toFixed(2)"></span>
                                </div>

                            </div>

                            </form>
                        </div>
                    </div>

                    <div id="job-task-monitoring-section" x-show="activeMenu === 'monitoring'">
                        <div id="job-task-monitoring" class="border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Task Monitoring') }}</h3>

                        <div class="mt-6 overflow-visible border border-gray-200 rounded-lg">
                            <div class="divide-y divide-gray-200">
                                @forelse ($monitorings as $monitoring)
                                    @php
                                        $requiredFormIds = collect($monitoring->required_forms_documents ?? [])->map(fn ($id) => (int) $id)->values();
                                        $allRequiredFormsCompleted = $requiredFormIds->isNotEmpty()
                                            && $requiredFormIds->every(fn ($formId) => strtolower(trim((string) ($formStatusesByMonitoringAndForm[$monitoring->id.'-'.$formId] ?? 'pending'))) === 'completed');
                                        $submissionStatus = strtolower((string) ($monitoring->submission_status ?? 'pending'));
                                        $bookingStatus = $allRequiredFormsCompleted || $submissionStatus === 'completed' ? 'completed' : 'pending';
                                        $taskAgeDays = $monitoring->taskAgeInDays();
                                        $monitoringExpenses = collect($monitoring->expenses_breakdown ?? []);
                                        if ($monitoringExpenses->isEmpty()) {
                                            $monitoringExpenses = $requiredFormIds->map(fn ($formId) => [
                                                'form_id' => (int) $formId,
                                                'form_name' => $formNamesById[$formId] ?? __('Unknown form'),
                                                'expense_amount' => (float) ($formExpensesById[$formId] ?? 0),
                                            ]);
                                        }
                                        $monitoringExpensesByFormId = $monitoringExpenses->keyBy('form_id');
                                        $totalExpenses = (float) $monitoringExpenses->sum('expense_amount');
                                    @endphp
                                    <div x-data="{ expanded: false }" class="bg-white">
                                        <div class="task-monitoring-summary-grid px-4 py-4">
                                            <div class="task-monitoring-actions">
                                                <a href="{{ route('bookings.edit', $monitoring) }}" aria-label="{{ __('Update') }}" title="{{ __('Update') }}" class="task-monitoring-action task-monitoring-action-update">{{ __('Update') }}</a>
                                                <a href="{{ route('bookings.print', $monitoring) }}" target="_blank" rel="noopener" aria-label="{{ __('Print') }}" title="{{ __('Print') }}" class="task-monitoring-action task-monitoring-action-icon task-monitoring-action-print">
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8V3h10v5M7 17H5a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-2M7 14h10v7H7z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 11h.01" />
                                                    </svg>
                                                </a>
                                                @if (Auth::user()->isAdmin())
                                                    <form method="POST" action="{{ route('bookings.destroy', $monitoring) }}" data-confirm="{{ __('Are you sure you want to delete this task monitoring entry?') }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" aria-label="{{ __('Delete') }}" title="{{ __('Delete') }}" class="task-monitoring-action task-monitoring-action-icon task-monitoring-action-delete">
                                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M10 11v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="task-monitoring-metric">
                                                <div class="task-monitoring-pair">
                                                    <span class="task-monitoring-label">{{ __('Task ID') }}</span>
                                                    <button type="button" x-on:click="expanded = !expanded" class="task-monitoring-value text-left text-indigo-700 hover:underline">{{ $monitoring->id }}</button>
                                                </div>
                                            </div>
                                            <div class="task-monitoring-metric">
                                                <div class="task-monitoring-pair">
                                                    <span class="task-monitoring-label">{{ __('Date Booked') }}</span>
                                                    <span class="task-monitoring-value">{{ $monitoring->date_task_received?->format('F d, Y') ?? '—' }}</span>
                                                </div>
                                            </div>
                                            <div class="task-monitoring-metric">
                                                <div class="task-monitoring-pair">
                                                    <span class="task-monitoring-label">{{ __('Client Name') }}</span>
                                                    <span class="task-monitoring-value">{{ $monitoring->client?->client_name ?? '—' }}</span>
                                                </div>
                                            </div>
                                            <div class="task-monitoring-metric">
                                                <div class="task-monitoring-pair">
                                                    <span class="task-monitoring-label">{{ __('Task') }}</span>
                                                    <span class="task-monitoring-value">{{ $monitoring->task?->task_name ?? '—' }}</span>
                                                </div>
                                            </div>
                                            <div class="task-monitoring-metric">
                                                <div class="task-monitoring-pair">
                                                    <span class="task-monitoring-label">{{ __('No. of Days') }}</span>
                                                    <span class="task-monitoring-value">{{ $taskAgeDays === null ? '—' : $taskAgeDays.' '.($taskAgeDays === 1 ? __('day') : __('days')) }}</span>
                                                </div>
                                            </div>
                                            <div class="task-monitoring-metric">
                                                <div class="task-monitoring-pair">
                                                    <span class="task-monitoring-label">{{ __('Status') }}</span>
                                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $bookingStatus === 'completed' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                                        {{ $bookingStatus === 'completed' ? __('Completed') : __('Pending') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <button type="button" x-on:click="expanded = !expanded" :aria-expanded="expanded.toString()" aria-label="{{ __('Toggle task details') }}" class="task-monitoring-toggle inline-flex h-8 w-8 items-center justify-center rounded-md border border-gray-300 bg-white text-gray-600 shadow-sm transition hover:border-gray-400 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                <svg class="h-4 w-4 transition-transform" :class="expanded ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div x-show="expanded" x-cloak class="border-t border-gray-200 bg-gray-50 px-4 py-4">
                                            <div class="grid gap-4 rounded-lg border border-gray-200 bg-white p-5 text-sm sm:grid-cols-2 lg:grid-cols-3">
                                                <div><p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Date Task Received') }}</p><p class="mt-1 text-gray-900">{{ $monitoring->date_task_received?->format('F d, Y') ?? '—' }}</p></div>
                                                <div><p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Client Name') }}</p><p class="mt-1 text-gray-900">{{ $monitoring->client?->client_name ?? '—' }}</p></div>
                                                <div><p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Type of Task') }}</p><p class="mt-1 text-gray-900">{{ $monitoring->task?->task_name ?? '—' }}</p></div>
                                                <div><p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Required Docs Status') }}</p><p class="mt-1 text-gray-900">{{ $allRequiredFormsCompleted ? __('Completed') : ($requiredFormIds->isEmpty() ? __('N/A') : __('Pending')) }}</p></div>
                                                <div><p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Submission Status') }}</p><p class="mt-1 text-gray-900">{{ ucfirst($submissionStatus) }}</p></div>
                                                <div><p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Release of Cert/Clearance') }}</p><p class="mt-1 text-gray-900">{{ '—' }}</p></div>
                                                <div class="sm:col-span-2 lg:col-span-3">
                                                    <div class="task-monitoring-required-expense-header text-xs font-medium uppercase tracking-wide text-gray-500">
                                                        <p>{{ __('Required Forms and Documents') }}</p>
                                                        <p title="{{ __('Expense amount in Philippine pesos') }}">{{ __('PHP') }}</p>
                                                    </div>
                                                    @if ($requiredFormIds->isEmpty())
                                                        <div class="task-monitoring-required-expense-row mt-2">
                                                            <p class="rounded-md border border-gray-200 px-3 py-2 text-gray-500">{{ '—' }}</p>
                                                            <p class="task-monitoring-expense-row rounded-md border border-gray-200 text-gray-500">{{ '—' }}</p>
                                                        </div>
                                                    @else
                                                        <div class="task-monitoring-required-expense-list mt-2">
                                                            @foreach ($requiredFormIds as $formId)
                                                                @php
                                                                    $formName = $formNamesById[$formId] ?? null;
                                                                    $formStatus = strtolower(trim((string) ($formStatusesByMonitoringAndForm[$monitoring->id.'-'.$formId] ?? 'pending')));
                                                                    $formCompleted = $formStatus === 'completed';
                                                                    $formExpense = (float) ($monitoringExpensesByFormId->get($formId)['expense_amount'] ?? 0);
                                                                @endphp

                                                                @if ($formName)
                                                                    <div class="task-monitoring-required-expense-row">
                                                                        <div class="task-monitoring-form-status-row rounded-md border px-3 py-2 {{ $formCompleted ? 'border-green-200 bg-green-50 dark:border-green-900 dark:bg-green-950/30' : 'border-red-200 bg-red-50 dark:border-red-900 dark:bg-red-950/40' }}">
                                                                            <span class="task-monitoring-form-expense-name required-form-name">{{ $formName }}</span>
                                                                            <span class="task-monitoring-form-expense-status text-xs font-semibold {{ $formCompleted ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300' }}">{{ $formCompleted ? __('Completed') : __('Not Completed') }}</span>
                                                                        </div>
                                                                        <div class="task-monitoring-expense-row rounded-md border border-gray-200 text-gray-800">
                                                                            <span class="task-monitoring-form-expense-amount font-medium" title="PHP {{ number_format($formExpense, 2) }}">{{ number_format($formExpense, 2) }}</span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                            <div class="task-monitoring-form-expense-total border-t border-gray-200 pt-2 font-semibold text-gray-900">
                                                                <span>{{ __('Total Expenses') }}</span>
                                                                <span class="task-monitoring-form-expense-amount" title="PHP {{ number_format($totalExpenses, 2) }}">{{ number_format($totalExpenses, 2) }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="sm:col-span-2 lg:col-span-3"><p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Submission Details') }}</p><p class="mt-1 text-gray-900">{{ $allRequiredFormsCompleted ? (($monitoring->date_of_submission?->format('F d, Y') ?? '—').' / '.($monitoring->receiving_officer ?? '—').' / '.($monitoring->acknowledgement_receipt_reference_number ?? '—')) : '—' }}</p></div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="px-6 py-4 text-sm text-gray-500 text-center">{{ __('No monitoring records found.') }}</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="hidden mt-6 overflow-x-auto border border-gray-200 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Task ID') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date Task Received') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Client Name') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Type of Task') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Assigned Responsible Person') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200 border-r-0">{{ __('List of Required Forms and Documents') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200 border-l-0">{{ __('Required Docs Status') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200 border-r-0">{{ __('Submission Details') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200 border-l-0">{{ __('Submission Status') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Release of Cert/Clearance') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($monitorings as $monitoring)
                                        <tr x-data="{ actionsOpen: false }">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $monitoring->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $monitoring->date_task_received?->format('F d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $monitoring->client?->client_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $monitoring->task?->task_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $monitoring->assignedResponsiblePerson?->contact_person }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900 border border-gray-200 border-r-0">
                                                @php
                                                    $requiredFormIds = collect($monitoring->required_forms_documents ?? [])->map(fn ($id) => (int) $id)->values();
                                                    $allRequiredFormsCompleted = $requiredFormIds->isNotEmpty()
                                                        && $requiredFormIds->every(fn ($formId) => strtolower(trim((string) ($formStatusesByMonitoringAndForm[$monitoring->id.'-'.$formId] ?? 'pending'))) === 'completed');
                                                @endphp

                                                @if ($requiredFormIds->isEmpty())
                                                    {{ '—' }}
                                                @else
                                                    <div class="space-y-1">
                                                        @foreach ($requiredFormIds as $formId)
                                                            @php
                                                                $formName = $formNamesById[$formId] ?? null;
                                                                $formStatus = strtolower(trim((string) ($formStatusesByMonitoringAndForm[$monitoring->id.'-'.$formId] ?? 'pending')));
                                                                $formStatusClass = $formStatus === 'completed'
                                                                    ? 'text-green-600 font-semibold'
                                                                    : 'text-red-600 font-semibold';
                                                            @endphp

                                                            @if ($formName)
                                                                <div class="{{ $formStatusClass }}">{{ $formName }}</div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-200 border-l-0">
                                                @if ($requiredFormIds->isEmpty())
                                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-700">{{ __('N/A') }}</span>
                                                @elseif ($allRequiredFormsCompleted)
                                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700">{{ __('Completed') }}</span>
                                                @else
                                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">{{ __('Pending') }}</span>
                                                @endif

                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 border border-gray-200 border-r-0">
                                                @if ($allRequiredFormsCompleted)
                                                    <div class="space-y-2">
                                                        <div>
                                                            <div class="text-xs font-medium text-gray-500">{{ __('Date of Submission') }}</div>
                                                            <div>{{ $monitoring->date_of_submission?->format('F d, Y') ?? '—' }}</div>
                                                        </div>
                                                        <div>
                                                            <div class="text-xs font-medium text-gray-500">{{ __('Recieving Officer') }}</div>
                                                            <div>{{ $monitoring->receiving_officer ?? '—' }}</div>
                                                        </div>
                                                        <div>
                                                            <div class="text-xs font-medium text-gray-500">{{ __('Acknowledgement Reciept/Reference Number') }}</div>
                                                            <div>{{ $monitoring->acknowledgement_receipt_reference_number ?? '—' }}</div>
                                                        </div>
                                                    </div>
                                                @else
                                                    {{ '—' }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-200 border-l-0">
                                                @php
                                                    $submissionStatus = strtolower((string) ($monitoring->submission_status ?? 'pending'));
                                                @endphp

                                                @if ($submissionStatus === 'completed')
                                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700">{{ __('Completed') }}</span>
                                                @elseif ($submissionStatus === 'pending')
                                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">{{ __('Pending') }}</span>
                                                @else
                                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-700">{{ ucfirst($submissionStatus) }}</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ '—' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="relative z-10" x-on:click.outside="actionsOpen = false" :class="actionsOpen ? 'z-50' : 'z-10'">
                                                    <button type="button" x-on:click="actionsOpen = !actionsOpen" :aria-expanded="actionsOpen.toString()" class="inline-flex min-h-9 w-32 items-center justify-between rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                                        {{ __('Actions') }}
                                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                                                    </button>
                                                    <div x-show="actionsOpen" x-cloak class="absolute right-0 z-50 mt-1 w-40 overflow-hidden rounded-md border border-gray-200 bg-white py-1 shadow-lg">
                                                        <a href="{{ route('bookings.print', $monitoring) }}" target="_blank" rel="noopener" x-on:click="actionsOpen = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('Print') }}</a>
                                                        @if ($allRequiredFormsCompleted)
                                                            <a href="{{ route('bookings.edit', ['monitoring' => $monitoring, 'show_submission_form' => 1]) }}" x-on:click="actionsOpen = false" class="block px-4 py-2 text-sm {{ $submissionStatus === 'completed' ? 'text-green-700 hover:bg-green-50' : 'text-blue-700 hover:bg-blue-50' }}">{{ $submissionStatus === 'completed' ? __('View Details') : __('Submission Process') }}</a>
                                                        @endif
                                                        @unless ($allRequiredFormsCompleted)
                                                            <a href="{{ route('bookings.edit', $monitoring) }}" x-on:click="actionsOpen = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('Update') }}</a>
                                                        @endunless
                                                        @if (Auth::user()->isAdmin())
                                                            <form method="POST" action="{{ route('bookings.destroy', $monitoring) }}" data-confirm="{{ __('Are you sure you want to delete this task monitoring entry?') }}">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50">{{ __('Delete') }}</button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="px-6 py-4 text-sm text-gray-500 text-center">{{ __('No monitoring records found.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                            <div class="mt-4">
                                {{ $monitorings->links() }}
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
