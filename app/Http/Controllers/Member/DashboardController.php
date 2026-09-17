<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\MemberDashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected MemberDashboardService $dashboardService
    ) {}

    public function index(Request $request): View
    {
        return view('member.dashboard', [
            'user' => $request->user(),
            ...$this->dashboardService->getDashboardData(
                $request->user()
            ),
        ]);
    }
}
