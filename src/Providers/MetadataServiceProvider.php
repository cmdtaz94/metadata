<?php


namespace Cmdtaz\Metadata\Providers;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class MetadataServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishResources();
        $this->registerResources();
    }

    /**
     * Publish all the resources of the package.
     */
    protected function publishResources()
    {
        $this->publishesConfigs();
        $this->publishesMigrations();
    }

    /**
     * Register all the resources of the package.
     */
    protected function registerResources()
    {
        $this->registerViews();
        $this->registerTranslations();
        $this->registerMiddlewares();
        $this->registerRoutes();
        $this->registerFactories();
    }

    /**
     * Publish the migrations
     */
    protected function publishesMigrations()
    {
        $this->publishes([
            __DIR__ . '/../../database/migrations/' => database_path('migrations')
        ], 'cmdtaz-metadata-migrations');
    }

    /**
     * Publish the configs
     */
    protected function publishesConfigs()
    {
        $this->publishes([
            __DIR__ . '/../../config/' => config_path(''),
        ], 'cmdtaz-metadata-config');
    }

    /**
     * Register all the migrations of the package.
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    /**
     * Register the Views
     */
    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'metadata');
    }

    /**
     * Register the Views
     */
    protected function registerTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'metadata');
    }

    /**
     * Register the middlewares
     */
    protected function registerMiddlewares()
    {

    }

    /**
     * Register all the routes of the package.
     */
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        });
    }

    /**
     * Register all the routes of the package.
     */
    protected function registerFactories()
    {
        $this->loadFactoriesFrom(__DIR__ . '/../../database/factories');
    }


    /**
     * Routes configurations
     * @return array
     */
    protected function routeConfiguration()
    {
        return [
            'namespace' => 'Cmdtaz\Metadata\Http\Controllers',
            'middleware' => ['api']
        ];
    }

}
