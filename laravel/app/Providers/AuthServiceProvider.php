<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Providers\auhtUserProvider;
use Illuminate\Support\Facades\Auth;


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
    public function boot()
    {
        $this->registerPolicies();

        // Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addMonths(3));
        Passport::personalAccessTokensExpireIn(now()->addMonths(2));

        // Auth::provider('custom', function ($app, array $config) {
        //     return new auhtUserProvider($app['hash'], $config['model']);
        // });

        
    // $this->registerPolicies();
    // Passport::routes();
    }
}