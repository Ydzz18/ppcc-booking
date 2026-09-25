<?php

namespace App\Http\Controllers;

use App\Models\Task;
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
            'task_name' => ['required', 'string', 'max:255'],
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
     * Show a print-ready preview of the specified task.
     */
    public function print(Task $task): View
    {
        return view('tasks.print', [
            'task' => $task,
        ]);
    }

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
            'task_name' => ['required', 'string', 'max:255'],
        ]);

        $task->update($validated);

        return Redirect::route('settings.index')->with('status', 'task-updated');
    }
}
