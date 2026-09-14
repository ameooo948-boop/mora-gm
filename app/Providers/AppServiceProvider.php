<?php

namespace App\Providers;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\Contracts\GalleryItemRepositoryInterface;
use App\Repositories\Contracts\GymProfileRepositoryInterface;
use App\Repositories\Contracts\MembershipPlanRepositoryInterface;
use App\Repositories\Contracts\TrainerRepositoryInterface;
use App\Repositories\Contracts\TrainingSessionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface as ContractsUserRepositoryInterface;
use App\Repositories\Eloquent\GalleryItemRepository;
use App\Repositories\Eloquent\GymProfileRepository;
use App\Repositories\Eloquent\MembershipPlanRepository;
use App\Repositories\Eloquent\TrainerRepository;
use App\Repositories\Eloquent\TrainingSessionRepository;
use App\Repositories\Eloquent\UserRepository;
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

        $this->app->bind(
            TrainerRepositoryInterface::class,
            TrainerRepository::class
        );

        $this->app->bind(
            GalleryItemRepositoryInterface::class,
            GalleryItemRepository::class
        );

        $this->app->bind(
            ContractsUserRepositoryInterface::class,
            UserRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
