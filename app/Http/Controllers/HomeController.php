<?php

namespace App\Http\Controllers;

use App\Models\TrainingSession;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $trainingSessions = TrainingSession::active()->get();

        return view('home.index', compact('trainingSessions'));
    }
}
