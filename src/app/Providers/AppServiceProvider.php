<?php

namespace App\Providers;

use App\Models\User;
use App\Models\TaskMonitoring;
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

        View::composer('layouts.app', function ($view): void {
            $view->with([
                'notificationCount' => TaskMonitoring::query()->pending()->count(),
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
