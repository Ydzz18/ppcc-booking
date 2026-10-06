<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCatalogItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ExpenseCatalogController extends Controller
{
    public function index(): View
    {
        return view('expenses.catalog', [
            'items' => ExpenseCatalogItem::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge(['name' => trim((string) $request->input('name', ''))]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('expense_catalog', 'name')],
            'default_amount' => ['required', 'numeric', 'min:0', 'max:99999999.99', 'decimal:0,2'],
        ]);

        $nextOrder = (int) ExpenseCatalogItem::query()->max('sort_order') + 1;
        ExpenseCatalogItem::query()->create([
            'name' => trim($validated['name']),
            'default_amount' => $validated['default_amount'],
            'sort_order' => $nextOrder,
        ]);

        return to_route('expense-catalog.index')->with('status', 'expense-catalog-created');
    }

    public function update(Request $request, ExpenseCatalogItem $expenseCatalogItem): RedirectResponse
    {
        $request->merge(['name' => trim((string) $request->input('name', ''))]);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('expense_catalog', 'name')->ignore($expenseCatalogItem->id),
            ],
            'default_amount' => ['required', 'numeric', 'min:0', 'max:99999999.99', 'decimal:0,2'],
        ]);

        $expenseCatalogItem->update([
            'name' => trim($validated['name']),
            'default_amount' => $validated['default_amount'],
        ]);

        return to_route('expense-catalog.index')->with('status', 'expense-catalog-updated');
    }

    public function destroy(ExpenseCatalogItem $expenseCatalogItem): RedirectResponse
    {
        $expenseCatalogItem->delete();

        return to_route('expense-catalog.index')->with('status', 'expense-catalog-deleted');
    }
}
