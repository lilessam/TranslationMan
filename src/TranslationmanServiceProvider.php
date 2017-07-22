<?php namespace Lilessam\Translationman;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class TranslationmanServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //Load Routes
        $this->setupRoutes($this->app->router);

        $this->loadViewsFrom(__DIR__ . '/views', 'translationman');

        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/translationman'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/translationman.php', 'translationman'
        );
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Lilessam\Translationman\Controllers'], function ($router) {
            require __DIR__ . '/routes.php';
        });
    }

}
