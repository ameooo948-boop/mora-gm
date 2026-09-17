<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\TrainingSession;
use App\Services\AttendanceService;
use App\Services\TrainingSessionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function __construct(
        protected AttendanceService $attendanceService,
        protected TrainingSessionService $trainingSessionService
    ) {}

    public function index(Request $request): View
    {
        return view('member.attendance', [
            'attendances' => $this->attendanceService
                ->getUserAttendances(
                    $request->user()->id
                ),

            'trainingSessions' => $this->trainingSessionService
                ->getActiveSessions(),
        ]);
    }

    public function checkIn(
        Request $request,
        TrainingSession $trainingSession
    ): RedirectResponse {
        $this->attendanceService->checkIn(
            $request->user()->id,
            $trainingSession
        );

        return back()->with(
            'success',
            'تم تسجيل حضورك بنجاح.'
        );
    }

    public function checkOut(
        Request $request,
        TrainingSession $trainingSession
    ): RedirectResponse {
        $this->attendanceService->checkOut(
            $request->user()->id,
            $trainingSession
        );

        return back()->with(
            'success',
            'تم تسجيل انصرافك بنجاح.'
        );
    }
}
