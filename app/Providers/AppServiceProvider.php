<?php

namespace App\Providers;

use App\Models\Config as ConfigModel;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use NumberFormatter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //include __DIR__ . '/../helpers.php';

        $this->app->singleton('currency', function($app) {
            return new NumberFormatter(App::currentLocale(), NumberFormatter::CURRENCY);
        });

        // $frmt = new NumberFormatter(App::currentLocale(), NumberFormatter::CURRENCY);
        // $this->app->instance('currency', $frmt);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $configs = Cache::get('configs');
        if (!$configs) {
            $configs = ConfigModel::all();
            Cache::put('configs', $configs);
        }
        foreach ($configs as $config) {
            Config::set($config->name, $config->value);
        }

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
