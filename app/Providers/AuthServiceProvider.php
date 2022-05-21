<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\PersonalAccessToken;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
        // User::class => UserPolicy::class,
        // Category::class => CategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    
        // Gate::before(function($user, $ability) {
        //     if ($user->id == 1) {
        //         return true;
        //     }
        // });

        foreach (config('abilities') as $ability => $label) {
            
            Gate::define($ability, function($user) use ($ability) {
                return $user->hasAbility($ability);
            });

        }
    
    }
}
