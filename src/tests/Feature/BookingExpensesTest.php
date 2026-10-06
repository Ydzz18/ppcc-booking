<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ExpenseCatalogItem;
use App\Models\FormItem;
use App\Models\Task;
use App\Models\TaskMonitoring;
use App\Models\TaskMonitoringFormNote;
use App\Models\User;
use Database\Seeders\ExpenseCatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingExpensesTest extends TestCase
{
    use RefreshDatabase;

    public function test_forms_remain_document_requirements_separate_from_expense_catalog(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('forms.store'), [
                'form_names' => ['Permit Form'],
            ])
            ->assertRedirect(route('settings.index', ['tab' => 'forms', 'forms_page' => 1]));

        $this->assertDatabaseHas('forms', [
            'form_name' => 'Permit Form',
        ]);

        $form = FormItem::query()->firstOrFail();
        $this->actingAs($user)
            ->patch(route('forms.update', $form), [
                'form_name' => 'Permit Document',
            ])
            ->assertRedirect(route('settings.index'));

        $this->assertDatabaseHas('forms', [
            'form_name' => 'Permit Document',
        ]);

        $this->actingAs($user)
            ->get(route('expense-catalog.index'))
            ->assertOk()
            ->assertSee('Expenses List')
            ->assertSee('Notarial Fee-SPA')
            ->assertSee('Others:3___________')
            ->assertSee('aria-label="Add Expense"', false)
            ->assertSee('aria-label="Edit"', false)
            ->assertSee('aria-label="Delete"', false)
            ->assertSee(route('expense-catalog.destroy', ExpenseCatalogItem::query()->firstOrFail()), false);

        $this->actingAs($user)
            ->get(route('bookings.index'))
            ->assertOk()
            ->assertSee(route('expense-catalog.index'), false);
    }

    public function test_expense_catalog_seed_is_ordered_idempotent_and_preserves_defaults(): void
    {
        $item = ExpenseCatalogItem::query()->where('name', 'Permits')->firstOrFail();
        $item->update(['default_amount' => 75.25]);

        $this->seed(ExpenseCatalogSeeder::class);
        $this->seed(ExpenseCatalogSeeder::class);

        $this->assertSame([
            'Notarial Fee-SPA',
            'Notarial Fee-Sworn',
            'Loose DST',
            'Doc Stamp Tax',
            'SI Printing',
            'DR Printing',
            'Permits',
            'Cedula',
            'Certification Fee',
            'Penalties',
            'Registration Fee',
            'Processing Fee',
            'Others:1___________',
            'Others:2___________',
            'Others:3___________',
        ], ExpenseCatalogItem::query()->orderBy('sort_order')->pluck('name')->all());
        $this->assertSame(15, ExpenseCatalogItem::query()->count());
        $this->assertSame('75.25', $item->fresh()->default_amount);
    }

    public function test_expense_catalog_items_can_be_created_and_updated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('expense-catalog.store'), [
                'name' => 'Courier',
                'default_amount' => '12.50',
            ])
            ->assertRedirect(route('expense-catalog.index'));

        $catalogItem = ExpenseCatalogItem::query()->where('name', 'Courier')->firstOrFail();
        $this->assertSame('12.50', $catalogItem->default_amount);

        $this->actingAs($user)
            ->patch(route('expense-catalog.update', $catalogItem), [
                'name' => 'Courier Fee',
                'default_amount' => '15.75',
            ])
            ->assertRedirect(route('expense-catalog.index'));

        $this->assertDatabaseHas('expense_catalog', [
            'id' => $catalogItem->id,
            'name' => 'Courier Fee',
            'default_amount' => '15.75',
        ]);
    }

    public function test_expense_catalog_items_can_be_deleted_without_changing_saved_booking_snapshots(): void
    {
        [$user, $client, $task] = $this->createBookingFixture();
        $catalogItem = ExpenseCatalogItem::query()->where('name', 'Permits')->firstOrFail();
        $monitoring = TaskMonitoring::create([
            'date_task_received' => '2026-09-30',
            'client_id' => $client->id,
            'task_id' => $task->id,
            'assigned_responsible_person_id' => $client->id,
            'expenses_breakdown' => [[
                'catalog_id' => $catalogItem->id,
                'catalog_name' => $catalogItem->name,
                'expense_amount' => 125.50,
            ]],
            'submission_status' => 'pending',
        ]);

        $this->actingAs($user)
            ->delete(route('expense-catalog.destroy', $catalogItem))
            ->assertRedirect(route('expense-catalog.index'))
            ->assertSessionHas('status', 'expense-catalog-deleted');

        $this->assertDatabaseMissing('expense_catalog', ['id' => $catalogItem->id]);
        $this->assertSame([[
            'catalog_id' => $catalogItem->id,
            'catalog_name' => 'Permits',
            'expense_amount' => 125.5,
        ]], $monitoring->fresh()->expenses_breakdown);

        $this->actingAs($user)
            ->get(route('expense-catalog.index'))
            ->assertOk()
            ->assertSee('Expense catalog item deleted.')
            ->assertDontSee('Permits');
    }

    public function test_catalog_seeding_does_not_recreate_renamed_default_items(): void
    {
        $item = ExpenseCatalogItem::query()->where('name', 'Cedula')->firstOrFail();
        $item->update(['name' => 'Municipal Certification', 'default_amount' => 4.50]);

        $this->seed(ExpenseCatalogSeeder::class);
        $this->seed(ExpenseCatalogSeeder::class);

        $this->assertSame(15, ExpenseCatalogItem::query()->count());
        $this->assertDatabaseHas('expense_catalog', [
            'id' => $item->id,
            'name' => 'Municipal Certification',
            'default_amount' => '4.50',
        ]);
        $this->assertDatabaseMissing('expense_catalog', ['name' => 'Cedula']);
    }

    public function test_task_entry_keeps_required_documents_separate_from_catalog_expenses(): void
    {
        [$user, $client, $task, $form] = $this->createBookingFixture();
        $uncheckedForm = FormItem::create(['form_name' => 'Unselected Form']);
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
        $this->assertSame([], $monitoring->expenses_breakdown);

        $this->actingAs($user)
            ->get(route('bookings.index', ['tab' => 'monitoring']))
            ->assertOk()
            ->assertSee('Required Forms and Documents')
            ->assertSee('task-monitoring-form-status-row')
            ->assertSee('No expenses recorded.')
            ->assertDontSee('Expenses Breakdown')
            ->assertDontSee('task-monitoring-label">Expenses');

        $printResponse = $this->actingAs($user)
            ->get(route('bookings.print', $monitoring))
            ->assertOk()
            ->assertSee('Permit Form')
            ->assertDontSee('Unselected Form')
            ->assertSee(route('bookings.print.expenses.update', $monitoring), false)
            ->assertSee('Edit Expenses')
            ->assertSee('Amount (PHP)')
            ->assertSee('Expenses')
            ->assertSee('Notarial Fee-SPA')
            ->assertSee('class="expenses"', false)
            ->assertSee('class="required-forms"', false)
            ->assertSee('No expenses recorded.');

        preg_match('/<table class="required-forms">.*?<\/table>/s', $printResponse->getContent(), $requiredFormsTable);
        $this->assertNotEmpty($requiredFormsTable);
        $this->assertStringNotContainsString('Expenses', $requiredFormsTable[0]);
        $this->assertStringNotContainsString('PHP', $requiredFormsTable[0]);

        $this->actingAs($user)
            ->patch(route('bookings.update', $monitoring), [
                'date_task_received' => '2026-09-30',
                'client_name' => $client->id,
                'type_of_task' => $task->id,
                'assigned_responsible_person' => $client->id,
                'required_forms_documents' => [$form->id],
            ])
            ->assertSessionHasNoErrors();

        $this->assertSame([], $monitoring->fresh()->expenses_breakdown);
    }

    public function test_print_expenses_can_be_updated_without_changing_catalog_defaults(): void
    {
        [$user, $client, $task, $form] = $this->createBookingFixture();
        $expense = ExpenseCatalogItem::query()->where('name', 'Permits')->firstOrFail();
        $expense->update(['default_amount' => 125.50]);
        $monitoring = TaskMonitoring::create([
            'date_task_received' => '2026-09-30',
            'client_id' => $client->id,
            'task_id' => $task->id,
            'task_ids' => [$task->id],
            'assigned_responsible_person_id' => $client->id,
            'required_forms_documents' => [$form->id],
            'expenses_breakdown' => [[
                'catalog_id' => $expense->id,
                'catalog_name' => $expense->name,
                'expense_amount' => 125.5,
            ]],
            'submission_status' => 'pending',
        ]);

        $this->actingAs($user)
            ->patch(route('bookings.print.expenses.update', $monitoring), [
                'expenses' => [$expense->id => '87.65'],
            ])
            ->assertRedirect(route('bookings.print', $monitoring))
            ->assertSessionHas('status', 'expenses-updated');

        $this->assertSame(87.65, $monitoring->fresh()->expenses_breakdown[0]['expense_amount']);
        $this->assertSame('125.50', $expense->fresh()->default_amount);

        $this->actingAs($user)
            ->patch(route('bookings.print.expenses.update', $monitoring), [
                'expenses' => [$expense->id => '99.00', $expense->id + 999 => '1.00'],
            ])
            ->assertSessionHasErrors('expenses');

        $this->assertSame(87.65, $monitoring->fresh()->expenses_breakdown[0]['expense_amount']);
    }

    public function test_multiple_task_types_combine_shared_document_quantities(): void
    {
        [$user, $client, $task, $form] = $this->createBookingFixture();
        $secondTask = Task::create([
            'agency' => 'Another Agency',
            'task_name' => 'Second Task',
            'required_forms_documents' => [$form->id],
        ]);
        $task->update(['required_forms_documents' => [$form->id]]);

        $this->actingAs($user)
            ->postJson(route('bookings.store'), [
                'date_task_received' => '2026-10-01',
                'client_name' => $client->id,
                'type_of_task' => [$task->id, $secondTask->id],
                'required_forms_documents' => [$form->id],
                'required_forms_quantities' => [$form->id => 2],
            ])
            ->assertCreated();

        $monitoring = TaskMonitoring::query()->firstOrFail();
        $this->assertSame([$task->id, $secondTask->id], $monitoring->task_ids);
        $this->assertSame([$form->id => 2], $monitoring->required_forms_quantities);

        $this->actingAs($user)
            ->get(route('bookings.index', ['tab' => 'monitoring']))
            ->assertOk()
            ->assertSee('Sample Task, Second Task')
            ->assertSee('Permit Form x 2');

        $this->actingAs($user)
            ->get(route('bookings.print', $monitoring))
            ->assertOk()
            ->assertSee('Sample Task, Second Task')
            ->assertSee('Permit Form')
            ->assertSee('2')
            ->assertSee('Amount (PHP)')
            ->assertSee('Expenses')
            ->assertSee('No expenses recorded.')
            ->assertDontSee('Permit Form</td><td>PHP');
    }

    public function test_print_expenses_can_be_added_removed_and_edited_as_catalog_snapshots(): void
    {
        [$user, $client, $task, $form] = $this->createBookingFixture();
        $expense = ExpenseCatalogItem::query()->where('name', 'Permits')->firstOrFail();
        $expense->update(['default_amount' => 125.50]);
        $newExpense = ExpenseCatalogItem::query()->where('name', 'Cedula')->firstOrFail();
        $newExpense->update(['default_amount' => 33.25]);
        $monitoring = TaskMonitoring::create([
            'date_task_received' => '2026-09-30',
            'client_id' => $client->id,
            'task_id' => $task->id,
            'task_ids' => [$task->id],
            'assigned_responsible_person_id' => $client->id,
            'required_forms_documents' => [$form->id],
            'expenses_breakdown' => [[
                'catalog_id' => $expense->id,
                'catalog_name' => 'Permits',
                'expense_amount' => 125.5,
            ]],
            'submission_status' => 'pending',
        ]);

        $this->actingAs($user)
            ->get(route('bookings.print', $monitoring))
            ->assertOk()
            ->assertSee('data-default-amount="33.25"', false)
            ->assertSee('data-save-expenses-pdf', false)
            ->assertSee('Cancel');

        $this->actingAs($user)
            ->patch(route('bookings.print.expenses.update', $monitoring), [
                'expenses' => [$expense->id => '87.65', $newExpense->id => '33.25'],
                'download_pdf' => '1',
            ])
            ->assertRedirect(route('bookings.pdf', $monitoring));

        $this->assertSame([
            ['catalog_id' => $expense->id, 'catalog_name' => 'Permits', 'expense_amount' => 87.65],
            ['catalog_id' => $newExpense->id, 'catalog_name' => 'Cedula', 'expense_amount' => 33.25],
        ], $monitoring->fresh()->expenses_breakdown);

        $expense->update(['name' => 'Permit Charges', 'default_amount' => 999]);
        $this->actingAs($user)
            ->get(route('bookings.print', $monitoring))
            ->assertOk()
            ->assertSee('Permits')
            ->assertSee('PHP 87.65')
            ->assertDontSee('Permit Charges');

        $this->actingAs($user)
            ->patch(route('bookings.update', $monitoring), [
                'date_task_received' => '2026-09-30',
                'client_name' => $client->id,
                'type_of_task' => $task->id,
                'assigned_responsible_person' => $client->id,
                'required_forms_documents' => [$form->id],
            ])
            ->assertSessionHasNoErrors();

        $this->assertSame(87.65, $monitoring->fresh()->expenses_breakdown[0]['expense_amount']);
        $this->assertSame('Permits', $monitoring->fresh()->expenses_breakdown[0]['catalog_name']);

        $this->actingAs($user)
            ->patch(route('bookings.print.expenses.update', $monitoring), [
                'expenses' => [$expense->id => '87.65'],
            ])
            ->assertRedirect(route('bookings.print', $monitoring));
        $this->assertCount(1, $monitoring->fresh()->expenses_breakdown);
        $this->assertSame($expense->id, $monitoring->fresh()->expenses_breakdown[0]['catalog_id']);

        $this->actingAs($user)
            ->patch(route('bookings.print.expenses.update', $monitoring), [
                'expenses' => [$expense->id => '99.00', $expense->id + 999 => '1.00'],
            ])
            ->assertSessionHasErrors('expenses');

        $this->assertSame(87.65, $monitoring->fresh()->expenses_breakdown[0]['expense_amount']);

        $this->actingAs($user)
            ->patch(route('bookings.print.expenses.update', $monitoring), [
                'expenses' => [$expense->id => 'not-an-amount'],
            ])
            ->assertSessionHasErrors('expenses.'.$expense->id);

        $this->actingAs($user)
            ->patch(route('bookings.print.expenses.update', $monitoring), [])
            ->assertRedirect(route('bookings.print', $monitoring));

        $this->assertSame([], $monitoring->fresh()->expenses_breakdown);
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
        $secondForm = FormItem::create(['form_name' => 'Clearance Form']);
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

    public function test_task_monitoring_edit_keeps_forms_as_checklist_requirements_only(): void
    {
        [$user, $client, $task, $form] = $this->createBookingFixture();
        $monitoring = TaskMonitoring::create([
            'date_task_received' => '2026-09-30',
            'client_id' => $client->id,
            'task_id' => $task->id,
            'task_ids' => [$task->id],
            'assigned_responsible_person_id' => $client->id,
            'required_forms_documents' => [$form->id],
            'submission_status' => 'pending',
        ]);

        $this->actingAs($user)
            ->get(route('bookings.edit', $monitoring))
            ->assertOk()
            ->assertSee('Required Forms and Documents')
            ->assertDontSee('selectedExpenseIds')
            ->assertDontSee('expense_amount');
    }

    public function test_settings_render_contact_person_and_keep_form_management_separate(): void
    {
        $fixture = $this->createBookingFixture();
        $user = $fixture[0];
        $form = $fixture[3];

        $this->actingAs($user)
            ->get(route('settings.index', ['tab' => 'clients']))
            ->assertOk()
            ->assertSee('Contact Person')
            ->assertSee('aria-label="View client details"', false)
            ->assertSee('client-details-', false)
            ->assertSee('data-mobile-id-column="0"', false)
            ->assertDontSee('Business Registration');

        $this->actingAs($user)
            ->get(route('settings.index', ['tab' => 'forms']))
            ->assertOk()
            ->assertSee('Form names')
            ->assertSee('edit-form-'.$form->id, false)
            ->assertSee(route('forms.update', $form), false)
            ->assertSee('Update the form or document name used by task checklists.')
            ->assertDontSee(route('forms.edit', $form), false)
            ->assertDontSee('form_expenses[]')
            ->assertDontSee('name="expense_amount"');
    }

    public function test_expense_tracker_generates_a_filtered_printable_report(): void
    {
        [$user, $client, $task, $form] = $this->createBookingFixture();
        $expense = ExpenseCatalogItem::query()->where('name', 'Permits')->firstOrFail();
        TaskMonitoring::create([
            'date_task_received' => '2026-09-29',
            'client_id' => $client->id,
            'task_id' => $task->id,
            'assigned_responsible_person_id' => $client->id,
            'required_forms_documents' => [$form->id],
            'expenses_breakdown' => [[
                'catalog_id' => $expense->id,
                'catalog_name' => $expense->name,
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
                'catalog_id' => $expense->id,
                'catalog_name' => $expense->name,
                'expense_amount' => 60.00,
            ]],
            'submission_status' => 'pending',
        ]);
        TaskMonitoring::create([
            'date_task_received' => '2026-09-29',
            'client_id' => $client->id,
            'task_id' => $task->id,
            'assigned_responsible_person_id' => $client->id,
            'required_forms_documents' => [$form->id],
            'expenses_breakdown' => [[
                'form_id' => $form->id,
                'form_name' => 'Permit Form',
                'expense_amount' => 88.88,
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
            ->assertDontSee('88.88')
            ->assertDontSee('60.00');

        $this->actingAs($user)
            ->get(route('expenses.print', $filters))
            ->assertOk()
            ->assertSee('Expenses Report')
            ->assertSee('42.75')
            ->assertDontSee('60.00');

    }

    public function test_booking_and_expense_pdfs_render_catalog_expense_snapshots(): void
    {
        if (! extension_loaded('gd')) {
            $this->markTestSkipped('The GD extension is required to render DomPDF output.');
        }

        [$user, $client, $task] = $this->createBookingFixture();
        $expense = ExpenseCatalogItem::query()->where('name', 'Permits')->firstOrFail();
        $monitoring = TaskMonitoring::create([
            'date_task_received' => '2026-09-30',
            'client_id' => $client->id,
            'task_id' => $task->id,
            'assigned_responsible_person_id' => $client->id,
            'expenses_breakdown' => [[
                'catalog_id' => $expense->id,
                'catalog_name' => $expense->name,
                'expense_amount' => 42.75,
            ]],
            'submission_status' => 'pending',
        ]);

        $this->actingAs($user)
            ->get(route('bookings.pdf', $monitoring))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');

        $this->actingAs($user)
            ->get(route('expenses.pdf', ['search' => 'Permits']))
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
        ]);

        return [$user, $client, $task, $form];
    }
}