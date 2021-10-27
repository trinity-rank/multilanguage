<?php

namespace Trinityrank\Hreflang;

use Illuminate\Support\ServiceProvider;

class HreflangServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ ."/database/migrations/2021_10_27_115398_add_hreflang_columns_to_tables.php" =>
                'database/migrations/2021_10_27_115398_add_hreflang_columns_to_tables.php',
            ], "hreflang-migration");
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
