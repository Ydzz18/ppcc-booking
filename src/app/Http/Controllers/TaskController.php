<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskMonitoring;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Store a newly created task.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'agency' => ['required', 'string', 'max:255'],
            'task_name' => ['required', 'string', 'max:255'],
            'required_forms_documents' => ['nullable', 'array'],
            'required_forms_documents.*' => ['integer', 'exists:forms,id'],
        ]);

        Task::create($validated);

        return Redirect::route('settings.index', ['tab' => 'tasks', 'tasks_page' => 1])->with('status', 'task-created');
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task): View
    {
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
    /**
     * Download a PDF of the specified task.
     */
    public function downloadPdf(Task $task)
    {
        return Pdf::loadView('tasks.print', [
            'task' => $task,
            'isPdf' => true,
        ])->download('task-'.$task->id.'.pdf');
    }

    /**
     * Update the specified task.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'agency' => ['required', 'string', 'max:255'],
            'task_name' => ['required', 'string', 'max:255'],
            'required_forms_documents' => ['nullable', 'array'],
            'required_forms_documents.*' => ['integer', 'exists:forms,id'],
        ]);

        $task->update($validated);

        return Redirect::route('settings.index')->with('status', 'task-updated');
    }

    /**
     * Remove the specified task when it is not used by monitoring records.
     */
    public function destroy(Task $task): RedirectResponse
    {
        if (TaskMonitoring::query()->where('task_id', $task->id)->exists()) {
            return Redirect::route('settings.index', ['tab' => 'tasks'])
                ->with('error', 'task-in-use');
        }

        $task->delete();

        return Redirect::route('settings.index', ['tab' => 'tasks'])
            ->with('status', 'task-deleted');
    }
}
