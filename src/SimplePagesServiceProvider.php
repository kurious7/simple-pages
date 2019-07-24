<?php

namespace Kurious7\SimplePages;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Kurious7\SimplePages\Http\Controllers\SimplePagesController;

class SimplePagesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'simple-pages');

        $this->publishes([
                __DIR__.'/../resources/views/' => resource_path('views/vendor/simple-pages'),
            ], 'views');

        $this->publishes([
            __DIR__.'/../config/simple-pages.php' => base_path('config/simple-pages.php'),
        ], 'config');

        if (! class_exists('CreateSimplePagesTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_simple_pages_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_simple_pages_table.php'),
            ], 'migrations');
        }

        Route::get(config('simple-pages.route'), SimplePagesController::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/simple-pages.php', 'simple-pages');
    }
}
