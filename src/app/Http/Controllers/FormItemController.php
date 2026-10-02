<?php

namespace App\Http\Controllers;

use App\Models\FormItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FormItemController extends Controller
{
    /**
     * Store a newly created form item.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'form_names' => array_map('trim', (array) $request->input('form_names', [])),
            'form_expenses' => array_map('trim', (array) $request->input('form_expenses', [])),
        ]);

        $validated = $request->validate([
            'form_names' => ['required', 'array', 'min:1'],
            'form_names.*' => [
                'required',
                'string',
                'max:255',
                'distinct:ignore_case',
                Rule::unique('forms', 'form_name'),
            ],
            'form_expenses' => ['required', 'array', 'size:'.count($request->input('form_names', []))],
            'form_expenses.*' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
        ]);

        foreach ($validated['form_names'] as $index => $formName) {
            FormItem::create([
                'form_name' => trim($formName),
                'expense_amount' => $validated['form_expenses'][$index],
            ]);
        }

        return Redirect::route('settings.index', ['tab' => 'forms', 'forms_page' => 1])->with('status', 'form-created');
    }

    /**
     * Show the form for editing the specified form item.
     */
    public function edit(FormItem $formItem): View
    {
        return view('forms.edit', [
            'formItem' => $formItem,
        ]);
    }

    /**
     * Update the specified form item.
     */
    public function update(Request $request, FormItem $formItem): RedirectResponse
    {
        $validated = $request->validate([
            'form_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('forms', 'form_name')->ignore($formItem->id),
            ],
            'expense_amount' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
        ]);

        $formItem->update([
            'form_name' => trim($validated['form_name']),
            'expense_amount' => $validated['expense_amount'],
        ]);

        return Redirect::route('settings.index')->with('status', 'form-updated');
    }
}
