<?php

namespace App\Providers;

use App\Models\Ensemble;
use App\Models\Event;
use App\Models\Threads\Comment;
use App\Models\Threads\Post;
use App\Policies\EnsemblePolicy;
use App\Policies\EventPolicy;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensExpireIn(now()->addMinutes(800));


        Gate::define('admin-panel', function (User $user) {
          return true;
        });

    }
}
