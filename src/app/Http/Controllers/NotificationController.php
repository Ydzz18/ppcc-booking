<?php

namespace App\Http\Controllers;

use App\Models\TaskMonitoring;
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
}
