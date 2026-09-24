<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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

                    <div id="job-task-entry-section" class="max-w-7xl mx-auto" x-show="activeMenu === 'entry'">
                        <div class="border border-gray-200 rounded-lg p-6" x-data="{ selectedForms: [], initializeSelectedForms() { const checked = this.$root.querySelectorAll(`input[name='required_forms_documents[]']:checked`); this.selectedForms = Array.from(checked).map((item) => ({ value: item.value, text: item.dataset.formName })); }, toggleForm(event) { const value = event.target.value; const text = event.target.dataset.formName; if (event.target.checked) { if (!this.selectedForms.find((item) => item.value === value)) { this.selectedForms.push({ value, text }); } return; } this.selectedForms = this.selectedForms.filter((item) => item.value !== value); }, removeSelectedForm(value) { const checkbox = this.$root.querySelector(`input[name='required_forms_documents[]'][value='${value}']`); if (checkbox) { checkbox.checked = false; } this.selectedForms = this.selectedForms.filter((item) => item.value !== value); } }" x-init="initializeSelectedForms()">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Task Monitoring Form') }}</h3>

                        <form method="POST" action="{{ route('bookings.store') }}" class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-3" data-confirm="Are you sure you want to create this task?">
                            @csrf

                            <div>
                                <x-input-label for="date_task_received" :value="__('Date Task Received')" />
                                <x-text-input id="date_task_received" name="date_task_received" type="date" class="mt-1 block w-full" :value="old('date_task_received')" />
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

                            <div>
                                <x-input-label for="type_of_task" :value="__('Type of Task')" />
                                <select id="type_of_task" name="type_of_task" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">{{ __('Select Task') }}</option>
                                    @foreach ($tasks as $task)
                                        <option value="{{ $task->id }}" @selected((string) old('type_of_task') === (string) $task->id)>{{ $task->task_name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('type_of_task')" />
                            </div>

                            <div class="md:col-span-3">
                                <x-input-label for="required_forms_documents" :value="__('List of Required Forms and Documents')" />
                                <div id="required_forms_documents" class="mt-1 max-h-48 overflow-y-auto rounded-md border border-gray-300 p-3">
                                    <div class="space-y-2">
                                        @foreach ($forms as $form)
                                            <label class="flex items-center gap-2 text-sm text-gray-700">
                                                <input type="checkbox" name="required_forms_documents[]" value="{{ $form->id }}" data-form-name="{{ $form->form_name }}" @checked(in_array((string) $form->id, array_map('strval', old('required_forms_documents', [])), true)) x-on:change="toggleForm($event)" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                <span>{{ $form->form_name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('required_forms_documents')" />

                                <div class="mt-3 space-y-1" x-show="selectedForms.length > 0">
                                    <p class="text-sm font-medium text-gray-700">{{ __('Selected Forms:') }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="form in selectedForms" :key="form.value">
                                            <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                                                <span x-text="form.text"></span>
                                                <button type="button" x-on:click="removeSelectedForm(form.value)" class="text-gray-500 hover:text-gray-700">&times;</button>
                                            </span>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-3">
                                <x-primary-button>{{ __('Create Task') }}</x-primary-button>
                            </div>
                            </form>
                        </div>
                    </div>

                    <div id="job-task-monitoring-section" x-show="activeMenu === 'monitoring'">
                        <div id="job-task-monitoring" class="border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Task Monitoring') }}</h3>

                        <div class="mt-6 overflow-hidden border border-gray-200 rounded-lg">
                            <div class="divide-y divide-gray-200">
                                @forelse ($monitorings as $monitoring)
                                    @php
                                        $requiredFormIds = collect($monitoring->required_forms_documents ?? [])->map(fn ($id) => (int) $id)->values();
                                        $allRequiredFormsCompleted = $requiredFormIds->isNotEmpty()
                                            && $requiredFormIds->every(fn ($formId) => strtolower(trim((string) ($formStatusesByMonitoringAndForm[$monitoring->id.'-'.$formId] ?? 'pending'))) === 'completed');
                                        $submissionStatus = strtolower((string) ($monitoring->submission_status ?? 'pending'));
                                        $bookingStatus = $allRequiredFormsCompleted || $submissionStatus === 'completed' ? 'completed' : 'pending';
                                    @endphp
                                    <div x-data="{ expanded: false }" class="bg-white">
                                        <div class="grid items-center gap-4 px-4 py-4 sm:grid-cols-[120px_minmax(0,1fr)_minmax(0,1fr)_minmax(0,1fr)_120px_2rem]">
                                            <div class="order-first flex flex-wrap gap-2 sm:col-start-1">
                                                @if ($allRequiredFormsCompleted)
                                                    <a href="{{ route('bookings.edit', ['monitoring' => $monitoring, 'show_submission_form' => 1]) }}" class="inline-flex items-center rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-500">{{ $submissionStatus === 'completed' ? __('View Details') : __('Submission Process') }}</a>
                                                @endif
                                                @unless ($allRequiredFormsCompleted)
                                                    <a href="{{ route('bookings.edit', $monitoring) }}" class="inline-flex items-center rounded-md bg-gray-800 px-3 py-1.5 text-xs font-semibold text-white hover:bg-gray-700">{{ __('Update') }}</a>
                                                @endunless
                                            </div>
                                            <div>
                                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Task ID') }}</p>
                                                <button type="button" x-on:click="expanded = !expanded" class="mt-1 text-sm font-semibold text-indigo-700 hover:underline">{{ $monitoring->id }}</button>
                                            </div>
                                            <div>
                                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Type of Task') }}</p>
                                                <button type="button" x-on:click="expanded = !expanded" class="mt-1 text-left text-sm font-semibold text-gray-900 hover:text-indigo-700 hover:underline">{{ $monitoring->task?->task_name ?? '—' }}</button>
                                            </div>
                                            <div>
                                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Assigned Responsible Person') }}</p>
                                                <button type="button" x-on:click="expanded = !expanded" class="mt-1 text-left text-sm font-semibold text-gray-900 hover:text-indigo-700 hover:underline">{{ $monitoring->assignedResponsiblePerson?->contact_person ?? '—' }}</button>
                                            </div>
                                            <div>
                                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Status') }}</p>
                                                <span class="mt-1 inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $bookingStatus === 'completed' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                                    {{ $bookingStatus === 'completed' ? __('Completed') : __('Pending') }}
                                                </span>
                                            </div>
                                            <button type="button" x-on:click="expanded = !expanded" :aria-expanded="expanded.toString()" aria-label="{{ __('Toggle task details') }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-gray-300 bg-white text-gray-600 shadow-sm transition hover:border-gray-400 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:justify-self-end">
                                                <svg class="h-4 w-4 transition-transform" :class="expanded ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75 0 01-1.08 0l-4.25-4.5a.75 0 01.02-1.06z" clip-rule="evenodd" />
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
                                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Required Forms and Documents') }}</p>
                                                    @if ($requiredFormIds->isEmpty())
                                                        <p class="mt-2 rounded-md border border-gray-200 px-3 py-2 text-gray-500">{{ '—' }}</p>
                                                    @else
                                                        <div class="mt-2 space-y-2">
                                                            @foreach ($requiredFormIds as $formId)
                                                                @php
                                                                    $formName = $formNamesById[$formId] ?? null;
                                                                    $formStatus = strtolower(trim((string) ($formStatusesByMonitoringAndForm[$monitoring->id.'-'.$formId] ?? 'pending')));
                                                                    $formCompleted = $formStatus === 'completed';
                                                                @endphp

                                                                @if ($formName)
                                                                    <div class="flex items-center justify-between gap-3 rounded-md border px-3 py-2 {{ $formCompleted ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
                                                                        <span class="text-gray-900">{{ $formName }}</span>
                                                                        <span class="shrink-0 text-xs font-semibold {{ $formCompleted ? 'text-green-700' : 'text-red-700' }}">{{ $formCompleted ? __('Completed') : __('Not Completed') }}</span>
                                                                    </div>
                                                                @endif
                                                            @endforeach
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
                                        <tr>
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

                                                @if (!empty($latestFormNoteUpdatedAtByMonitoring[$monitoring->id] ?? null))
                                                    <div class="mt-1 text-xs text-gray-500">
                                                        <div>{{ __('Last updated:') }}</div>
                                                        <div>{{ $latestFormNoteUpdatedAtByMonitoring[$monitoring->id] }}</div>
                                                    </div>
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
                                                <div class="flex flex-col items-start gap-2">
                                                    @if ($allRequiredFormsCompleted)
                                                        <a href="{{ route('bookings.edit', ['monitoring' => $monitoring, 'show_submission_form' => 1]) }}" class="inline-flex items-center rounded-md px-3 py-1.5 text-xs font-semibold text-white focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $submissionStatus === 'completed' ? 'bg-green-600 hover:bg-green-500 focus:ring-green-500' : 'bg-blue-600 hover:bg-blue-500 focus:ring-blue-500' }}">
                                                            {{ $submissionStatus === 'completed' ? __('View Details') : __('Submission Process') }}
                                                        </a>
                                                    @endif

                                                    @unless ($allRequiredFormsCompleted)
                                                        <a href="{{ route('bookings.edit', $monitoring) }}" class="inline-flex items-center rounded-md bg-gray-800 px-3 py-1.5 text-xs font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                            {{ __('Update') }}
                                                        </a>
                                                    @endunless
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
