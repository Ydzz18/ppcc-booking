<?php

namespace App\Http\Controllers;

use App\Models\TaskMonitoring;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display actionable booking notifications.
     */
    public function index(): View
    {
        $notifications = TaskMonitoring::query()
            ->pending()
            ->with(['client:id,client_name', 'task:id,task_name'])
            ->latest('created_at')
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Return the latest actionable bookings for the live header notifications.
     */
    public function live(): JsonResponse
    {
        $notifications = TaskMonitoring::query()
            ->pending()
            ->with(['client:id,client_name', 'task:id,task_name'])
            ->latest('created_at')
            ->limit(5)
            ->get(['id', 'client_id', 'task_id', 'submission_status', 'created_at']);

        return response()->json([
            'count' => TaskMonitoring::query()->pending()->count(),
            'notifications' => $notifications->map(fn (TaskMonitoring $notification): array => [
                'id' => $notification->id,
                'task_name' => $notification->task?->task_name ?? __('Booking'),
                'client_name' => $notification->client?->client_name ?? __('Unknown client'),
                'status' => ucfirst($notification->submission_status ?: 'pending'),
                'url' => route('bookings.edit', $notification),
                'created_at' => $notification->created_at?->toIso8601String(),
            ])->values(),
        ]);
    }
}
