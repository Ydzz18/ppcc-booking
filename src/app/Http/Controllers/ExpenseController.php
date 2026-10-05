<?php

namespace App\Http\Controllers;

use App\Models\TaskMonitoring;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function index(Request $request): View
    {
        $report = $this->reportData($request);
        $perPage = 25;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $entries = new LengthAwarePaginator(
            $report['entries']->forPage($page, $perPage)->values(),
            $report['entries']->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );

        return view('expenses.index', [
            'entries' => $entries,
            'from' => $report['from'],
            'to' => $report['to'],
            'search' => $report['search'],
            'totalExpenses' => $report['totalExpenses'],
            'expenseCount' => $report['expenseCount'],
            'taskCount' => $report['taskCount'],
        ]);
    }

    public function print(Request $request): View
    {
        return view('expenses.print', $this->printData($request));
    }

    public function downloadPdf(Request $request)
    {
        return Pdf::loadView('expenses.print', $this->printData($request) + ['isPdf' => true])
            ->setPaper('a4', 'landscape')
            ->download('expenses-report-'.now()->format('Ymd_His').'.pdf');
    }

    /** @return array{entries: \Illuminate\Support\Collection<int, array<string, mixed>>, from: ?string, to: ?string, search: string, totalExpenses: float, expenseCount: int, taskCount: int} */
    private function reportData(Request $request): array
    {
        $filters = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
            'search' => ['nullable', 'string', 'max:120'],
        ]);
        $from = $filters['from'] ?? null;
        $to = $filters['to'] ?? null;
        $search = trim((string) ($filters['search'] ?? ''));

        $monitorings = TaskMonitoring::query()
            ->with(['client:id,client_name', 'task:id,task_name'])
            ->when($from, fn ($query) => $query->whereDate('date_task_received', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('date_task_received', '<=', $to))
            ->latest('date_task_received')
            ->latest('id')
            ->get();

        $entries = $monitorings->flatMap(function (TaskMonitoring $monitoring): array {
            return collect($monitoring->expenses_breakdown ?? [])
                ->filter(fn ($expense): bool => is_array($expense)
                    && isset($expense['catalog_id'], $expense['catalog_name'], $expense['expense_amount']))
                ->map(fn (array $expense): array => [
                    'task_id' => $monitoring->id,
                    'date' => $monitoring->date_task_received?->format('Y-m-d'),
                    'client' => $monitoring->client?->client_name ?? '—',
                    'task' => $monitoring->task?->task_name ?? '—',
                    'item' => $expense['catalog_name'],
                    'amount' => (float) $expense['expense_amount'],
                ])
                ->all();
        })->values();

        if ($search !== '') {
            $needle = mb_strtolower($search);
            $entries = $entries->filter(function (array $entry) use ($needle): bool {
                $haystack = mb_strtolower(implode(' ', [
                    $entry['task_id'],
                    $entry['client'],
                    $entry['task'],
                    $entry['item'],
                ]));

                return str_contains($haystack, $needle);
            })->values();
        }

        return [
            'entries' => $entries,
            'from' => $from,
            'to' => $to,
            'search' => $search,
            'totalExpenses' => round((float) $entries->sum('amount'), 2),
            'expenseCount' => $entries->count(),
            'taskCount' => $entries->pluck('task_id')->unique()->count(),
        ];
    }

    /** @return array<string, mixed> */
    private function printData(Request $request): array
    {
        return $this->reportData($request) + [
            'title' => __('Expenses Report'),
            'backUrl' => route('expenses.index', $request->query()),
            'downloadUrl' => route('expenses.pdf', $request->query()),
        ];
    }
}