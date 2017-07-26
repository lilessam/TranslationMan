<?php namespace Lilessam\Translationman;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class TranslationmanServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->loadViewsFrom(__DIR__ . '/views', 'translationman');

        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/translationman'),
            __DIR__.'/config/translationman.php' => config_path('translationman.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/translationman.php', 'translationman'
        );
        
    }

}
