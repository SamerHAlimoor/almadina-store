<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function register()
    {
        parent::register();

        // هاي معناها انه بستدعيها وقت ما بحتاجها مش وقت ما يتشغل السيرفس كونينر
        $this->app->bind('abilities', function () {
            return include base_path('data/abilities.php');
        });
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */

    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user->super_admin) {
                return true;
            }
        });

        foreach ($this->app->make('abilities') as $code => $ability) {
            Gate::define($code, function ($user) use ($code) {
                return $user->hasAbility($code);
            });
        }
        // Gate::define('categories.view', function ($user) {
        //     return true;
        // });
        // Gate::define('categories.store', function ($user) {
        //     return true;
        // });
        // Gate::define('categories.create', function ($user) {
        //     return false;
        // });
        // Gate::define('categories.show', function ($user) {
        //     return true;
        // });

        // Gate::define('categories.update', function ($user) {
        //     return false;
        // });
        // Gate::define('categories.delete', function ($user) {
        //     return false;
        // });

        // Gate::define('roles.view', function ($user) {
        //     return true;
        // });
        // Gate::define('roles.store', function ($user) {
        //     return true;
        // });
        // Gate::define('roles.create', function ($user) {
        //     return false;
        // });
        // Gate::define('roles.show', function ($user) {
        //     return true;
        // });

        // Gate::define('roles.update', function ($user) {
        //     return true;
        // });
        // Gate::define('roles.delete', function ($user) {
        //     return true;
        // });

        //
    }
}