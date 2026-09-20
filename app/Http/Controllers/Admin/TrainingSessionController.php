<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTrainingSessionRequest;
use App\Http\Requests\Admin\UpdateTrainingSessionRequest;
use App\Services\TrainerService;
use App\Services\TrainingSessionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrainingSessionController extends Controller
{
    public function __construct(
        protected TrainingSessionService $trainingSessionService,
        protected TrainerService $trainerService
    ) {}

    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->value() ?: null;
        $audience = $request->string('audience')->trim()->value() ?: null;

        return view('admin.training-sessions.index', [
            'trainingSessions' => $this->trainingSessionService->getAllSessions(
                audience: $audience,
                search: $search,
            ),
            'search' => $search,
            'audience' => $audience,
        ]);
    }

    public function create(): View
    {
        return view('admin.training-sessions.create', [
            'maleTrainers' => $this->trainerService
                ->getActiveTrainersByGender(Gender::MALE->value),

            'femaleTrainers' => $this->trainerService
                ->getActiveTrainersByGender(Gender::FEMALE->value),
        ]);
    }

    public function store(
        StoreTrainingSessionRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        $trainerId = (int) $data['trainer_id'];

        unset($data['trainer_id']);

        $this->trainingSessionService->createSession(
            $data,
            $trainerId
        );

        return redirect()
            ->route('admin.training-sessions.index')
            ->with('success', 'تم إنشاء الجلسة التدريبية بنجاح.');
    }

    public function edit(int $trainingSession): View
    {
        $session = $this->trainingSessionService->getSession(
            $trainingSession
        );

        abort_unless($session, 404);

        return view('admin.training-sessions.edit', [
            'trainingSession' => $session,

            'maleTrainers' => $this->trainerService
                ->getActiveTrainersByGender(Gender::MALE->value),

            'femaleTrainers' => $this->trainerService
                ->getActiveTrainersByGender(Gender::FEMALE->value),
        ]);
    }

    public function update(
        UpdateTrainingSessionRequest $request,
        int $trainingSession
    ): RedirectResponse {
        $session = $this->trainingSessionService->getSession(
            $trainingSession
        );

        abort_unless($session, 404);

        $data = $request->validated();

        $trainerId = (int) $data['trainer_id'];

        unset($data['trainer_id']);

        $this->trainingSessionService->updateSession(
            $session,
            $data,
            $trainerId
        );

        return redirect()
            ->route('admin.training-sessions.index')
            ->with('success', 'تم تحديث الجلسة التدريبية بنجاح.');
    }
}
