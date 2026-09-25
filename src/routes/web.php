<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FormItemController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Client;
use App\Models\FormItem;
use App\Models\Task;
use App\Models\TaskMonitoring;
use App\Models\User;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function (Request $request) {
    $statusCounts = TaskMonitoring::query()
        ->selectRaw("COALESCE(submission_status, 'pending') as status, COUNT(*) as total")
        ->groupBy('submission_status')
        ->pluck('total', 'status');

    $bookingTotal = (int) $statusCounts->sum();
    $completedBookings = (int) ($statusCounts['completed'] ?? 0);
    $pendingBookings = max(0, $bookingTotal - $completedBookings);
    $bookingsToday = TaskMonitoring::query()->whereDate('date_task_received', today())->count();
    $bookingsThisWeek = TaskMonitoring::query()
        ->whereBetween('date_task_received', [now()->startOfWeek(), now()->endOfWeek()])
        ->count();
    $completionRate = $bookingTotal > 0 ? (int) round(($completedBookings / $bookingTotal) * 100) : 0;
    $bookingDistribution = collect([
        ['label' => 'Pending', 'value' => $pendingBookings, 'color' => 'bg-amber-400'],
        ['label' => 'Completed', 'value' => $completedBookings, 'color' => 'bg-emerald-500'],
    ]);

    $calendarView = in_array($request->query('calendar_view'), ['day', 'week', 'month'], true)
        ? $request->query('calendar_view')
        : 'month';
    $calendarStart = match ($calendarView) {
        'day' => now()->startOfDay(),
        'week' => now()->startOfWeek(),
        default => now()->startOfMonth()->startOfWeek(),
    };
    $calendarEnd = match ($calendarView) {
        'day' => now()->endOfDay(),
        'week' => now()->endOfWeek(),
        default => now()->endOfMonth()->endOfWeek(),
    };
    $calendarCounts = TaskMonitoring::query()
        ->selectRaw('date_task_received, COUNT(*) as total')
        ->whereBetween('date_task_received', [$calendarStart->toDateString(), $calendarEnd->toDateString()])
        ->groupBy('date_task_received')
        ->pluck('total', 'date_task_received');
    $calendarDays = collect();
    for ($date = $calendarStart->copy(); $date->lte($calendarEnd); $date->addDay()) {
        $calendarDays->push([
            'date' => $date->copy(),
            'count' => (int) ($calendarCounts[$date->toDateString()] ?? 0),
        ]);
    }

    $search = trim((string) $request->query('client_search', ''));
    $clientFilter = (string) $request->query('client_filter', 'all');
    $clients = Client::query()
        ->select(['id', 'client_name', 'business_name', 'address', 'created_at'])
        ->when($search !== '', function ($query) use ($search): void {
            $query->where(function ($clientQuery) use ($search): void {
                $clientQuery->where('client_name', 'like', "%{$search}%")
                    ->orWhere('business_name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        })
        ->when($clientFilter === 'recent', fn ($query) => $query->where('created_at', '>=', now()->subDays(30)))
        ->when($clientFilter === 'oldest', fn ($query) => $query->oldest('created_at'))
        ->when($clientFilter !== 'oldest', fn ($query) => $query->latest('created_at'))
        ->limit(8)
        ->get();

    $staff = User::query()
        ->where('status', User::STATUS_ACTIVE)
        ->orderBy('name')
        ->get(['id', 'name', 'role']);
    $staffWorkload = TaskMonitoring::query()
        ->selectRaw('assigned_responsible_person_id, COUNT(*) as total')
        ->whereIn('assigned_responsible_person_id', $staff->pluck('id'))
        ->where(function ($query): void {
            $query->whereNull('submission_status')->orWhere('submission_status', '!=', 'completed');
        })
        ->groupBy('assigned_responsible_person_id')
        ->pluck('total', 'assigned_responsible_person_id');

    $notifications = TaskMonitoring::query()
        ->with(['client:id,client_name', 'task:id,task_name'])
        ->where(function ($query): void {
            $query->whereNull('submission_status')->orWhere('submission_status', '!=', 'completed');
        })
        ->latest('created_at')
        ->limit(5)
        ->get(['id', 'client_id', 'task_id', 'submission_status', 'created_at']);

    $trend = collect(range(5, 0))->map(function (int $monthsAgo): array {
        $month = Carbon::now()->startOfMonth()->subMonths($monthsAgo);

        return [
            'label' => $month->format('M'),
            'total' => TaskMonitoring::query()->whereBetween('created_at', [$month, $month->copy()->endOfMonth()])->count(),
        ];
    });

    return view('dashboard', compact('bookingTotal', 'completedBookings', 'pendingBookings', 'bookingsToday', 'bookingsThisWeek', 'completionRate', 'bookingDistribution', 'calendarView', 'calendarDays', 'clients', 'search', 'clientFilter', 'staff', 'staffWorkload', 'notifications', 'trend'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{monitoring}/print', [BookingController::class, 'print'])->name('bookings.print');
    Route::get('/bookings/{monitoring}/pdf', [BookingController::class, 'downloadPdf'])->name('bookings.pdf');
    Route::get('/bookings/{monitoring}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::patch('/bookings/{monitoring}', [BookingController::class, 'update'])->name('bookings.update');
    Route::post('/bookings/{monitoring}/form-note', [BookingController::class, 'saveFormNote'])->name('bookings.form-note.save');

    Route::get('/settings', function () {
        $users = User::query()
            ->select(['id', 'name', 'email', 'role', 'status', 'created_at'])
            ->latest('created_at')
            ->paginate(10, ['*'], 'users_page');

        $clients = Client::query()
            ->select(['id', 'client_name', 'contact_person', 'address', 'tin', 'tel_phone_number', 'created_at'])
            ->latest('created_at')
            ->paginate(10, ['*'], 'clients_page');

        $tasks = Task::query()
            ->select(['id', 'task_name', 'created_at'])
            ->latest('created_at')
            ->paginate(10, ['*'], 'tasks_page');

        $forms = FormItem::query()
            ->select(['id', 'form_name', 'created_at'])
            ->latest('created_at')
            ->paginate(10, ['*'], 'forms_page');

        $roles = User::roles();

        return view('settings', compact('users', 'clients', 'tasks', 'forms', 'roles'));
    })->name('settings.index');

    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::patch('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');

    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/print', [TaskController::class, 'print'])->name('tasks.print');
    Route::get('/tasks/{task}/pdf', [TaskController::class, 'downloadPdf'])->name('tasks.pdf');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

    Route::post('/forms', [FormItemController::class, 'store'])->name('forms.store');
    Route::get('/forms/{formItem}/edit', [FormItemController::class, 'edit'])->name('forms.edit');
    Route::patch('/forms/{formItem}', [FormItemController::class, 'update'])->name('forms.update');

    Route::middleware('can:manage-users')->group(function () {
        Route::get('/users/register', [UserController::class, 'create'])->name('users.create');
        Route::post('/users/register', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
