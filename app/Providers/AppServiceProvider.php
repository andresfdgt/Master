<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

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
        Schema::defaultStringLength(191);

        if (App::environment(['staging', 'production'])) {
            URL::forceScheme('https');
        }
        /**
        DB::listen(function ($query) {

            if (!preg_match('/^select/i', $query->sql)) {
               Log::info("DB_QUERY", ["sql" => $query->sql, "binding" => $query->bindings, "db" => DB::connection('privada')->getDatabaseName()]);
            }

        });
        */
        
    }
}
