<?php

namespace App\Providers;

use App\Repositories\Contracts\GymProfileRepositoryInterface;
use App\Repositories\Contracts\MembershipPlanRepositoryInterface;
use App\Repositories\Contracts\TrainingSessionRepositoryInterface;
use App\Repositories\Eloquent\GymProfileRepository;
use App\Repositories\Eloquent\MembershipPlanRepository;
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

        $this->app->bind(
            GymProfileRepositoryInterface::class,
            GymProfileRepository::class
        );

        $this->app->bind(
            MembershipPlanRepositoryInterface::class,
            MembershipPlanRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
