<?php

namespace Maravel\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Policies\TermPolicy;
use App\Policies\UserPolicy;
use App\Term;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        Gate::resource('dashboard.terms', TermPolicy::class);
        Gate::resource('dashboard.users', UserPolicy::class);
        Auth::viaRequest('cookie', function () {
            if (User::token()) {
                return User::me();
            }
            return null;
        });
    }
}
