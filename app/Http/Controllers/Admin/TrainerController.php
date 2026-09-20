<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTrainerRequest;
use App\Http\Requests\Admin\UpdateTrainerRequest;
use App\Services\TrainerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrainerController extends Controller
{
    public function __construct(
        protected TrainerService $trainerService
    ) {}

    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->value() ?: null;
        $gender = $request->string('gender')->trim()->value() ?: null;

        return view('admin.trainers.index', [
            'trainers' => $this->trainerService->getAllTrainers(
                gender: $gender,
                search: $search,
            ),
            'search' => $search,
            'gender' => $gender,
        ]);
    }

    public function create(): View
    {
        return view('admin.trainers.create');
    }

    public function store(
        StoreTrainerRequest $request
    ): RedirectResponse {
        $this->trainerService->createTrainer(
            $request->validated()
        );

        return redirect()
            ->route('admin.trainers.index')
            ->with('success', 'تم إضافة المدرب بنجاح.');
    }

    public function edit(int $trainer): View
    {
        $trainerModel = $this->trainerService->getTrainer($trainer);

        abort_unless($trainerModel, 404);

        return view('admin.trainers.edit', [
            'trainer' => $trainerModel,
        ]);
    }

    public function update(
        UpdateTrainerRequest $request,
        int $trainer
    ): RedirectResponse {
        $trainerModel = $this->trainerService->getTrainer($trainer);

        abort_unless($trainerModel, 404);

        $this->trainerService->updateTrainer(
            $trainerModel,
            $request->validated()
        );

        return redirect()
            ->route('admin.trainers.index')
            ->with('success', 'تم تحديث بيانات المدرب بنجاح.');
    }
}
