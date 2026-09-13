<?php

namespace App\Http\Controllers;

use App\Services\TrainingSessionService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected TrainingSessionService $trainingSessionService
    ) {}

    public function index(): View
    {
        $trainingSessions = $this->trainingSessionService
            ->getActiveSessions();

        return view('home.index', [
            'trainingSessions' => $trainingSessions,
        ]);
    }
}
