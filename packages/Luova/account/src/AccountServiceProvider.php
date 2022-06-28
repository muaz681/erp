<?php

namespace Luova\Account;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AccountServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'account');
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');

        // $this->publishes([
        //     __DIR__ . '/Database' => resource_path('views/vendor/account')
        // ]);

        $this->publishes([
            __DIR__.'/Database/Seeds/' => database_path('seeds')
        ], 'erp-account');

        if (file_exists($file =  __DIR__ . '/Helpers/account_helpers.php')) {
            require $file;
        }

        $this->app->register(SeedServiceProvider::class);
    }

    // public function register()
    // {


    //     $this->mergeConfigFrom(__DIR__ . '/Config/menu.php', 'menu.admin');
    // }
}
