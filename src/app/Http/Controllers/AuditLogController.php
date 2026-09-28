<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        $event = trim((string) $request->query('event', ''));
        $search = trim((string) $request->query('search', ''));

        $logs = AuditLog::query()
            ->when($event !== '', fn ($query) => $query->where('event', $event))
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($searchQuery) use ($search): void {
                    $searchQuery->where('actor_name', 'like', "%{$search}%")
                        ->orWhere('event', 'like', "%{$search}%")
                        ->orWhere('subject_type', 'like', "%{$search}%")
                        ->orWhere('subject_id', 'like', "%{$search}%")
                        ->orWhere('route_name', 'like', "%{$search}%")
                        ->orWhere('ip_address', 'like', "%{$search}%");
                });
            })
            ->latest('created_at')
            ->latest('id')
            ->paginate(25)
            ->withQueryString();

        $events = AuditLog::query()
            ->distinct()
            ->orderBy('event')
            ->pluck('event');

        return view('audit-logs.index', compact('logs', 'events', 'event', 'search'));
    }
}
