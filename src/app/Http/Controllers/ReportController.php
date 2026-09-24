<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Task;
use App\Models\TaskMonitoring;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Show the report builder and a preview of the selected report.
     */
    public function index(Request $request): Response
    {
        [$title, $headers, $rows] = $this->reportData($request);

        return response()->view('reports.index', [
            'reportType' => $this->reportType($request),
            'from' => $request->query('from'),
            'to' => $request->query('to'),
            'title' => $title,
            'headers' => $headers,
            'rows' => $rows,
        ]);
    }

    /**
     * Download the selected report as an Excel-compatible CSV file.
     */
    public function export(Request $request): StreamedResponse
    {
        [$title, $headers, $rows] = $this->reportData($request);
        $filename = str($title)->slug('_').'_'.now()->format('Ymd_His').'.csv';

        return response()->streamDownload(function () use ($headers, $rows): void {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, $headers);

            foreach ($rows as $row) {
                fputcsv($output, $row);
            }

            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * @return array{0: string, 1: list<string>, 2: list<list<string|int|null>>}
     */
    private function reportData(Request $request): array
    {
        $type = $this->reportType($request);
        $from = $request->query('from');
        $to = $request->query('to');

        return match ($type) {
            'tasks' => $this->tasksReport($from, $to),
            'bookings' => $this->bookingsReport($from, $to),
            'staff' => $this->staffReport($from, $to),
            default => $this->clientsReport($from, $to),
        };
    }

    private function reportType(Request $request): string
    {
        return in_array($request->query('type'), ['clients', 'tasks', 'bookings', 'staff'], true)
            ? $request->query('type')
            : 'clients';
    }

    private function clientsReport(?string $from, ?string $to): array
    {
        $query = Client::query()->latest('created_at');
        $this->applyDateFilter($query, $from, $to);

        $rows = $query->get()->map(fn (Client $client): array => [
            $client->id,
            $client->client_name,
            $client->business_name,
            $client->address,
            $client->residential_address,
            $client->tin,
            $client->tel_phone_number,
            $client->email_address,
            $client->created_at?->format('Y-m-d'),
        ])->all();

        return ['Client Records', ['ID', 'Name', 'Business Name', 'Business Address', 'Residential Address', 'TIN', 'Contact Number', 'Email Address', 'Created'], $rows];
    }

    private function tasksReport(?string $from, ?string $to): array
    {
        $query = Task::query()->latest('created_at');
        $this->applyDateFilter($query, $from, $to);

        $rows = $query->get()->map(fn (Task $task): array => [
            $task->id,
            $task->task_name,
            $task->created_at?->format('Y-m-d'),
        ])->all();

        return ['Task Records', ['ID', 'Task Name', 'Created'], $rows];
    }

    private function bookingsReport(?string $from, ?string $to): array
    {
        $query = TaskMonitoring::query()->with(['client:id,client_name', 'task:id,task_name'])->latest('created_at');
        $this->applyDateFilter($query, $from, $to);

        $rows = $query->get()->map(fn (TaskMonitoring $booking): array => [
            $booking->id,
            $booking->client?->client_name,
            $booking->task?->task_name,
            $booking->date_task_received?->format('Y-m-d'),
            ucfirst($booking->submission_status ?: 'pending'),
            $booking->created_at?->format('Y-m-d'),
        ])->all();

        return ['Booking Records', ['ID', 'Client', 'Task', 'Date Received', 'Status', 'Created'], $rows];
    }

    private function staffReport(?string $from, ?string $to): array
    {
        $query = User::query()->where('status', User::STATUS_ACTIVE)->orderBy('name');
        $staff = $query->get(['id', 'name', 'email', 'role', 'status', 'created_at']);
        $bookingQuery = TaskMonitoring::query();
        $this->applyDateFilter($bookingQuery, $from, $to);
        $workload = $bookingQuery->selectRaw('assigned_responsible_person_id, COUNT(*) as total')
            ->groupBy('assigned_responsible_person_id')
            ->pluck('total', 'assigned_responsible_person_id');

        $rows = $staff->map(fn (User $user): array => [
            $user->id,
            $user->name,
            $user->email,
            $user->role,
            $workload[$user->id] ?? 0,
            $user->created_at?->format('Y-m-d'),
        ])->all();

        return ['Staff Records', ['ID', 'Name', 'Email', 'Role', 'Assigned Bookings', 'Created'], $rows];
    }

    private function applyDateFilter($query, ?string $from, ?string $to): void
    {
        if ($from && Carbon::hasFormat($from, 'Y-m-d')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to && Carbon::hasFormat($to, 'Y-m-d')) {
            $query->whereDate('created_at', '<=', $to);
        }
    }
}
