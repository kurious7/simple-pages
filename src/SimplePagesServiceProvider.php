<?php

namespace Kurious7\SimplePages;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Kurious7\SimplePages\Contracts\SimplePage as SimplePageContract;
use Kurious7\SimplePages\Http\Controllers\SimplePagesController;
use Kurious7\SimplePages\Models\SimplePage as SimplePageModel;

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

        if (config('simple-pages.route.register')) {
            Route::get(config('simple-pages.route.path'), SimplePagesController::class);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/simple-pages.php', 'simple-pages');
    }

    public static function determineSimplePageModel(): string
    {
        $simplePageModel = config('simpel-pages.model') ?? SimplePageModel::class;

        if (! is_a($simplePageModel, SimplePage::class, true)
            || ! is_a($simplePageModel, Model::class, true)
        ) {
            throw InvalidConfiguration::modelIsNotValid($simplePageModel);
        }

        return $simplePageModel;
    }

    public static function getSimplePageModelInstance(): SimplePageContract
    {
        $simplePageModelClassName = self::determineSimplePageModel();

        return new $simplePageModelClassName();
    }
}
