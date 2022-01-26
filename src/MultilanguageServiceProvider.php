<?php

namespace Trinityrank\Multilanguage;

use Illuminate\Support\ServiceProvider;

class MultilanguageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // In future version, we can switch to load migrations without publishing
        // $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ ."/database/migrations/2021_10_27_115398_add_multilang_columns_to_tables.php" =>
                'database/migrations/2021_10_27_115398_add_multilang_columns_to_tables.php',
            ], "multilanguage-migration");
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
