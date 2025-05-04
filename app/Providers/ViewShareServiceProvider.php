<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ViewShareServiceProvider extends ServiceProvider
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
        view()->composer(['user.*'], function ($view) {
            $data['active_time'] = Auth::user()->active_time;
            $data['balance'] = Auth::user()->balance;
            $view->with($data);
        });
    }
}
