<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AttendanceService;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function __construct(
        protected AttendanceService $attendanceService
    ) {}

    public function index(): View
    {
        return view('admin.attendance.index', [
            'attendances' => $this->attendanceService
                ->getAllAttendances(),
        ]);
    }
}
