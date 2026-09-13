<?php

namespace App\Providers;

use App\Repositories\Contracts\TrainingSessionRepositoryInterface;
use App\Repositories\Eloquent\TrainingSessionRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            TrainingSessionRepositoryInterface::class,
            TrainingSessionRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
