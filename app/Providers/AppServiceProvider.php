<?php

namespace App\Providers;

use App\Models\File;
use App\Observers\FileObserver;
use Illuminate\Support\ServiceProvider;

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
        \Schema::defaultStringLength(191);

        $this->loadMigrationsFrom([
            base_path() . '/database/migrations/2019'
        ]);

        $this->loadObservers();
    }

    /**
     * Load observers
     *
     * @return void
     */
    private function loadObservers()
    {
        File::observe(FileObserver::class);
    }
}
