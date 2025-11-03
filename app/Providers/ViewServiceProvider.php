<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('user', Auth::user());
            }
        });

        View::composer('instructor.*', function ($view) {
            if (Auth::check() && Auth::user()->hasRole('instructor')) {
                $notifications = [
                    'assignments' => 0,
                    'students' => 0,
                ];

                $view->with('notifications', $notifications);
            }
        });

        View::composer(['admin.*', 'admin*'], function ($view) {
            if (Auth::check() && Auth::user()->hasRole('admin')) {
                $notifications = [
                    'users' => 0,
                    'courses' => 0,
                ];

                $view->with('notifications', $notifications);
            }
        });

        View::composer('student.*', function ($view) {
            if (Auth::check() && Auth::user()->hasRole('student')) {
                $notifications = [
                    'assignments' => 0,
                    'courses' => 0,
                ];

                $view->with('notifications', $notifications);
            }
        });
    }
}
