<?php

namespace App\Providers;

use App\Models\AuditLog;
use App\Models\Client;
use App\Models\FormItem;
use App\Models\Task;
use App\Models\TaskMonitoring;
use App\Models\TaskMonitoringFormNote;
use App\Models\User;
use App\Observers\AuditModelObserver;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('manage-users', fn (User $user): bool => $user->isAdmin());

        foreach ([Client::class, FormItem::class, Task::class, TaskMonitoring::class, TaskMonitoringFormNote::class, User::class] as $model) {
            $model::observe(AuditModelObserver::class);
        }

        Event::listen(Login::class, static function (Login $event): void {
            AuditLog::record('auth.login', $event->user instanceof Model ? $event->user : null, [], $event->user);
        });

        Event::listen(Logout::class, static function (Logout $event): void {
            AuditLog::record('auth.logout', $event->user instanceof Model ? $event->user : null, [], $event->user);
        });

        Event::listen(Failed::class, static function (Failed $event): void {
            AuditLog::record('auth.login_failed', $event->user instanceof Model ? $event->user : null, [], $event->user);
        });

        Event::listen(Lockout::class, static function (Lockout $event): void {
            AuditLog::record('auth.lockout');
        });

        View::composer('layouts.app', function ($view): void {
            $userId = auth()->id();
            $notificationViewedAt = $userId
                ? DB::table('user_notification_views')->where('user_id', $userId)->value('viewed_at')
                : null;
            $unreadNotifications = TaskMonitoring::query()->pending();

            if ($notificationViewedAt !== null) {
                $unreadNotifications->where('created_at', '>', $notificationViewedAt);
            }

            $view->with([
                'notificationCount' => $unreadNotifications->count(),
                'headerNotifications' => TaskMonitoring::query()
                    ->pending()
                    ->with(['client:id,client_name', 'task:id,task_name'])
                    ->latest('created_at')
                    ->limit(5)
                    ->get(['id', 'client_id', 'task_id', 'submission_status', 'created_at']),
            ]);
        });
    }
}
