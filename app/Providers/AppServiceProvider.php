<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        RateLimiter::for('onlineStore', function (Request $request) {
            return Limit::perMinute(50)->by($request->user()?->id ?: $request->ip())->response(function (Request $request, array $headers) {
                return response('Too many requests', 429, $headers);
            });
        });
        Gate::define('admin-role', function (User $user) {
            return $user->role === 3;
        });
    }
}
