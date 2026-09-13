<?php

namespace App\Http\Controllers;

use App\Services\GymProfileService;
use App\Services\MembershipPlanService;
use App\Services\TrainingSessionService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected TrainingSessionService $trainingSessionService,
        protected GymProfileService $gymProfileService,
        protected MembershipPlanService $membershipPlanService
    ) {}

    public function index(): View
    {
        return view('home.index', [
            'trainingSessions' => $this->trainingSessionService
                ->getActiveSessions(),

            'gymProfile' => $this->gymProfileService
                ->getActiveProfile(),

            'membershipPlans' => $this->membershipPlanService
                ->getActivePlans(),
        ]);
    }
}
