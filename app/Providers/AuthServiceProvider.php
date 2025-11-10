<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Admin Dashboard Gate
        Gate::define('view-admin-dashboard', function (User $user) {
            return $user->role === 'admin';
        });

        // Optional: Agent Dashboard Gate
        Gate::define('view-agent-dashboard', function (User $user) {
            return $user->role === 'agent';
        });
    }
}
