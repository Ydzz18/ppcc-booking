<?php

namespace App\Http\Controllers;

use App\Models\TaskMonitoring;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
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
        $viewedAt = DB::table('user_notification_views')->where('user_id', auth()->id())->value('viewed_at');
        $notifications = TaskMonitoring::query()
            ->pending()
            ->with(['client:id,client_name', 'task:id,task_name'])
            ->latest('created_at')
            ->limit(5)
            ->get(['id', 'client_id', 'task_id', 'submission_status', 'created_at']);

        return response()->json([
            'count' => $this->unreadNotificationCount($viewedAt),
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

    public function markViewed(Request $request): JsonResponse
    {
        $viewedAt = now();

        DB::table('user_notification_views')->updateOrInsert(
            ['user_id' => $request->user()->id],
            ['viewed_at' => $viewedAt, 'updated_at' => $viewedAt, 'created_at' => $viewedAt],
        );

        return response()->json(['viewed_at' => $viewedAt->toIso8601String()]);
    }

    private function unreadNotificationCount(mixed $viewedAt): int
    {
        return TaskMonitoring::query()
            ->pending()
            ->when($viewedAt !== null, fn ($query) => $query->where('created_at', '>', $viewedAt))
            ->count();
    }
}
