<?php

namespace App\Providers;

use App\Models\Configuration;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {

            $configuration = Configuration::first();

            $view->with('configuration', $configuration);
            $view->with('appConfig', $configuration);

        });
    }
}