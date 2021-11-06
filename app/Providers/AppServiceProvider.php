<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
        
        if (App::environment('production')) {
            Config::set('app.debug', false);
            //Config::set('app.timezone', 'UTC');
        }

        Validator::extend('filter', function($attribute, $value) {
            if ($value == 'god') {
                return false;
            }
            return true;
        }, 'Invalid word');

        Paginator::useBootstrap();
        //Paginator::defaultView('vendor.pagination.tailwind');
        //Paginator::defaultSimpleView('vendor.pagination.simple-tailwind');
    }
}
