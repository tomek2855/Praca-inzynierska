<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\File;
use App\Models\Issue;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\UserRoles;
use App\Observers\StoredByUserObserver;
use App\Observers\StoredCommentFileObserver;
use App\Observers\UserRolesObserver;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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

        Passport::routes();

        $this->loadMigrationsFrom([
            base_path() . '/database/migrations/2019',
            base_path() . '/database/migrations/2020'
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
        File::observe(StoredByUserObserver::class);
        Project::observe(StoredByUserObserver::class);
        ProjectUser::observe(StoredByUserObserver::class);
        Issue::observe(StoredByUserObserver::class);
        Comment::observe(StoredByUserObserver::class);

        Comment::observe(StoredCommentFileObserver::class);
    }
}
