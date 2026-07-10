<?php

namespace App\Providers;

use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use App\Repositories\PlayerNoteRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            PlayerNoteRepositoryInterface::class,
            PlayerNoteRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
