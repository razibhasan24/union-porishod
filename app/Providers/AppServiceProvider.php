<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // ==================== SUPER ADMIN BYPASS ====================
        // Super Admin সব permission check bypass করবে
        Gate::before(function ($user, $ability) {
            if ($user->user_type === 'super_admin') {
                return true;
            }
        });

        // ==================== CHAIRMAN BYPASS ====================
        // Chairman-ও প্রায় সব permission পাবে (delete বাদে)
        Gate::before(function ($user, $ability) {
            if ($user->user_type === 'chairman') {
                $denied = ['user.delete', 'role.delete', 'union.delete'];
                if (in_array($ability, $denied)) {
                    return null; // স্বাভাবিক check হবে
                }
                return true;
            }
        });
    }
}