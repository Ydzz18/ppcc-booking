<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\FormItem;
use App\Models\Task;
use App\Models\TaskMonitoring;
use App\Models\TaskMonitoringFormNote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingExpensesTest extends TestCase
{
    use RefreshDatabase;

    public function test_forms_can_be_created_with_expenses(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('forms.store'), [
                'form_names' => ['Permit Form'],
                'form_expenses' => ['125.50'],
            ])
            ->assertRedirect(route('settings.index', ['tab' => 'forms', 'forms_page' => 1]));

        $this->assertDatabaseHas('forms', [
            'form_name' => 'Permit Form',
            'expense_amount' => '125.50',
        ]);

        $form = FormItem::query()->firstOrFail();
        $this->actingAs($user)
            ->patch(route('forms.update', $form), [
                'form_name' => 'Permit Form',
                'expense_amount' => '150.00',
            ])
            ->assertRedirect(route('settings.index'));

        $this->assertDatabaseHas('forms', [
            'form_name' => 'Permit Form',
            'expense_amount' => '150.00',
        ]);
    }

    public function test_task_entry_snapshots_and_displays_selected_form_expenses(): void
    {
        [$user, $client, $task, $form] = $this->createBookingFixture();
        $uncheckedForm = FormItem::create([
            'form_name' => 'Unselected Form',
            'expense_amount' => 60.00,
        ]);
        $task->update(['required_forms_documents' => [$form->id, $uncheckedForm->id]]);

        $this->actingAs($user)
            ->get(route('bookings.index'))
            ->assertOk()
            ->assertSee('Form or Requirement')
            ->assertSee('required_forms_documents[]')
            ->assertSee('selectedFormIds')
            ->assertDontSee('task_expenses[');

        $this->actingAs($user)
            ->postJson(route('bookings.store'), [
                'date_task_received' => '2026-09-30',
                'client_name' => $client->id,
                'type_of_task' => $task->id,
                'required_forms_documents' => [$form->id],
            ])
            ->assertCreated();

        $monitoring = TaskMonitoring::query()->firstOrFail();
        $this->assertSame([$form->id], $monitoring->required_forms_documents);
        $this->assertSame([
            [
                'form_id' => $form->id,
                'form_name' => 'Permit Form',
                'expense_amount' => 125.5,
            ],
        ], $monitoring->expenses_breakdown);
        $this->assertSame(125.5, (float) $form->fresh()->expense_amount);

        $this->actingAs($user)
            ->get(route('bookings.index', ['tab' => 'monitoring']))
            ->assertOk()
            ->assertSee('125.50')
            ->assertSee('PHP 125.50')
            ->assertSee('Required Forms and Documents')
            ->assertSee('task-monitoring-form-status-row')
            ->assertSee('PHP')
            ->assertDontSee('task-monitoring-expense-row')
            ->assertDontSee('task-monitoring-required-expense-row')
            ->assertDontSee('Expenses Breakdown')
            ->assertDontSee('task-monitoring-label">Expenses');

        $this->actingAs($user)
            ->get(route('bookings.print', $monitoring))
            ->assertOk()
            ->assertSee('Permit Form')
            ->assertDontSee('Unselected Form')
            ->assertSee('Amount (PHP)')
            ->assertSee('125.50')
            ->assertSee('PHP 125.50');

        $this->actingAs($user)
            ->get(route('bookings.pdf', $monitoring))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');

        $form->update(['expense_amount' => 999]);
        $this->actingAs($user)
            ->patch(route('bookings.update', $monitoring), [
                'date_task_received' => '2026-09-30',
                'client_name' => $client->id,
                'type_of_task' => $task->id,
                'assigned_responsible_person' => $client->id,
                'required_forms_documents' => [$form->id],
            ])
            ->assertSessionHasNoErrors();

        $this->assertSame(125.5, $monitoring->fresh()->expenses_breakdown[0]['expense_amount']);
    }

    public function test_client_contact_person_can_be_saved(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('clients.store'), [
                'client_name' => 'Contact Test Client',
                'business_name' => 'Contact Test Business',
                'contact_person' => 'Jordan Example',
                'address' => '1 Main Street',
                'residential_address' => '2 Main Street',
                'tin' => '123456789',
                'tel_phone_number' => '09123456789',
                'email_address' => 'client@example.com',
                'id_presented' => 'Passport',
                'fathers_name' => 'Parent One',
                'mothers_maiden_name' => 'Parent Two',
                'date_of_birth' => '1990-01-01',
                'place_of_birth' => 'Puerto Princesa',
                'civil_status' => 'Single',
                'religion' => 'None',
                'capitalization' => '100000',
            ])
            ->assertRedirect(route('settings.index', ['clients_page' => 1]));

        $this->assertDatabaseHas('clients', [
            'client_name' => 'Contact Test Client',
            'contact_person' => 'Jordan Example',
        ]);
    }

    public function test_task_entry_can_save_multiple_task_types(): void
    {
        [$user, $client, $task, $form] = $this->createBookingFixture();
        $task->update(['required_forms_documents' => [$form->id]]);
        $secondForm = FormItem::create([
            'form_name' => 'Clearance Form',
            'expense_amount' => 60.00,
        ]);
        $secondTask = Task::create([
            'agency' => 'Another Agency',
            'task_name' => 'Second Task',
            'required_forms_documents' => [$secondForm->id],
        ]);

        $this->actingAs($user)
            ->get(route('bookings.index'))
            ->assertOk()
            ->assertSee('type_of_task[]')
            ->assertSee('selectedTaskIds');

        $this->actingAs($user)
            ->postJson(route('bookings.store'), [
                'date_task_received' => '2026-10-01',
                'client_name' => $client->id,
                'type_of_task' => [$task->id, $secondTask->id],
                'required_forms_documents' => [$form->id, $secondForm->id],
                'task_expenses' => [
                    $form->id => '42.75',
                    $secondForm->id => '60.00',
                ],
            ])
            ->assertCreated();

        $monitoring = TaskMonitoring::query()->firstOrFail();
        $this->assertSame([$task->id, $secondTask->id], $monitoring->task_ids);
        $this->assertSame([$form->id, $secondForm->id], $monitoring->required_forms_documents);

        $this->actingAs($user)
            ->get(route('bookings.index', ['tab' => 'monitoring']))
            ->assertOk()
            ->assertSee('Sample Task, Second Task');

        $this->actingAs($user)
            ->get(route('bookings.print', $monitoring))
            ->assertOk()
            ->assertSee('Sample Task, Second Task');

        $this->actingAs($user)
            ->get(route('bookings.edit', $monitoring))
            ->assertOk()
            ->assertSee('Sample Task, Second Task');
    }

    public function test_task_monitoring_edit_shows_expense_checkboxes_and_total(): void
    {
        [$user, $client, $task, $form] = $this->createBookingFixture();
        $monitoring = TaskMonitoring::create([
            'date_task_received' => '2026-09-30',
            'client_id' => $client->id,
            'task_id' => $task->id,
            'task_ids' => [$task->id],
            'assigned_responsible_person_id' => $client->id,
            'required_forms_documents' => [$form->id],
            'expenses_breakdown' => [[
                'form_id' => $form->id,
                'form_name' => $form->form_name,
                'expense_amount' => 125.5,
            ]],
            'submission_status' => 'pending',
        ]);

        $this->actingAs($user)
            ->get(route('bookings.edit', $monitoring))
            ->assertOk()
            ->assertSee('Expenses')
            ->assertSee('Total Expenses')
            ->assertSee('selectedExpenseIds')
            ->assertSee('PHP 125.50');
    }

    public function test_settings_render_contact_person_and_form_expense_controls(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('settings.index', ['tab' => 'clients']))
            ->assertOk()
            ->assertSee('Contact Person')
            ->assertDontSee('Business Registration');

        $this->actingAs($user)
            ->get(route('settings.index', ['tab' => 'forms']))
            ->assertOk()
            ->assertSee('Forms and Expenses')
            ->assertSee('form_expenses[]')
            ->assertSee('Expense');
    }

    public function test_expense_tracker_generates_a_filtered_printable_report(): void
    {
        [$user, $client, $task, $form] = $this->createBookingFixture();
        TaskMonitoring::create([
            'date_task_received' => '2026-09-29',
            'client_id' => $client->id,
            'task_id' => $task->id,
            'assigned_responsible_person_id' => $client->id,
            'required_forms_documents' => [$form->id],
            'expenses_breakdown' => [[
                'form_id' => $form->id,
                'form_name' => $form->form_name,
                'expense_amount' => 42.75,
            ]],
            'submission_status' => 'pending',
        ]);
        TaskMonitoring::create([
            'date_task_received' => '2026-09-28',
            'client_id' => $client->id,
            'task_id' => $task->id,
            'assigned_responsible_person_id' => $client->id,
            'required_forms_documents' => [$form->id],
            'expenses_breakdown' => [[
                'form_id' => $form->id,
                'form_name' => $form->form_name,
                'expense_amount' => 60.00,
            ]],
            'submission_status' => 'pending',
        ]);

        $filters = [
            'from' => '2026-09-29',
            'to' => '2026-09-30',
            'search' => 'Permit',
        ];

        $this->actingAs($user)
            ->get(route('expenses.index', $filters))
            ->assertOk()
            ->assertSee('Expense Tracker')
            ->assertSee('42.75')
            ->assertSee('PHP 42.75')
            ->assertDontSee('60.00');

        $this->actingAs($user)
            ->get(route('expenses.print', $filters))
            ->assertOk()
            ->assertSee('Expenses Report')
            ->assertSee('42.75')
            ->assertDontSee('60.00');

        $this->actingAs($user)
            ->get(route('expenses.pdf', $filters))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_submission_notes_are_saved_without_an_added_timestamp(): void
    {
        [$user, $client, $task, $form] = $this->createBookingFixture();
        $monitoring = TaskMonitoring::create([
            'date_task_received' => '2026-09-30',
            'client_id' => $client->id,
            'task_id' => $task->id,
            'assigned_responsible_person_id' => $client->id,
            'required_forms_documents' => [$form->id],
            'submission_status' => 'pending',
        ]);

        $this->actingAs($user)
            ->patch(route('bookings.update', $monitoring), [
                'date_task_received' => '2026-09-30',
                'client_name' => $client->id,
                'type_of_task' => $task->id,
                'assigned_responsible_person' => $client->id,
                'required_forms_documents' => [$form->id],
                'submission_decision' => 'pending',
                'submission_notes_input' => 'Submission note text.',
            ])
            ->assertSessionHasNoErrors();

        $this->assertSame('Submission note text.', $monitoring->fresh()->submission_notes);
    }

    public function test_form_remarks_are_saved_without_an_added_timestamp(): void
    {
        [$user, $client, $task, $form] = $this->createBookingFixture();
        $monitoring = TaskMonitoring::create([
            'date_task_received' => '2026-09-30',
            'client_id' => $client->id,
            'task_id' => $task->id,
            'assigned_responsible_person_id' => $client->id,
            'required_forms_documents' => [$form->id],
            'submission_status' => 'pending',
        ]);

        $this->actingAs($user)
            ->post(route('bookings.form-note.save', $monitoring), [
                'form_id' => $form->id,
                'notes_remarks_input' => 'Please confirm receipt.',
                'note_status' => 'pending',
            ])
            ->assertSessionHasNoErrors();

        $this->assertSame('Please confirm receipt.', TaskMonitoringFormNote::query()->firstOrFail()->notes_remarks);
    }

    public function test_legacy_note_timestamps_are_hidden_from_displayed_text(): void
    {
        $note = new TaskMonitoringFormNote([
            'notes_remarks' => "[March 02, 2026 01:20 PM] First remark\nSecond remark",
        ]);
        $monitoring = new TaskMonitoring([
            'submission_notes' => '[March 02, 2026 01:20 PM] Submission note',
        ]);

        $this->assertSame("First remark\nSecond remark", $note->notes_remarks);
        $this->assertSame('Submission note', $monitoring->submission_notes);
    }

    /** @return array{User, Client, Task, FormItem} */
    private function createBookingFixture(): array
    {
        $user = User::factory()->create();
        $client = Client::create([
            'client_name' => 'Sample Client',
            'address' => '1 Main Street',
            'tin' => '123456789',
            'tel_phone_number' => '09123456789',
        ]);
        $task = Task::create([
            'agency' => 'Sample Agency',
            'task_name' => 'Sample Task',
            'required_forms_documents' => [],
        ]);
        $form = FormItem::create([
            'form_name' => 'Permit Form',
            'expense_amount' => 125.50,
        ]);

        return [$user, $client, $task, $form];
    }
}