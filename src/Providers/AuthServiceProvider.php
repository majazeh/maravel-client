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
        Auth::viaRequest('cookie', function ($request) {
            if (User::token()) {
                if ($request->getMethod() == 'GET' && (!$request->session()->get('User_cacheed_at') || $request->session()->get('User_cacheed_at') < time() - 5)) {
                    User::$me = (new User)->execute('me');
                    $request->session()->put('User', User::$me->response()->toArray());
                    $request->session()->put('User_cacheed_at', time());
                }
                $user = User::me();
                return $user;
            }
            return null;
        });
    }
}
