<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GymProfile\StoreGymProfileRequest;
use App\Http\Requests\Admin\GymProfile\UpdateGymProfileRequest;
use App\Models\GymProfile;
use App\Services\GymProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GymProfileController extends Controller
{
    public function __construct(
        protected GymProfileService $service
    ) {}

    public function index(): View
    {
        $profiles = $this->service->getAllProfiles();

        return view('admin.gym-profile.index', compact('profiles'));
    }

    public function create(): View
    {
        return view('admin.gym-profile.create');
    }

    public function store(StoreGymProfileRequest $request): RedirectResponse
    {
        $this->service->createProfile($request->validated());

        return redirect()
            ->route('admin.gym-profile.index')
            ->with('success', 'تمت إضافة بيانات الجيم بنجاح.');
    }

    public function edit(GymProfile $gymProfile): View
    {
        return view('admin.gym-profile.edit', compact('gymProfile'));
    }

    public function update(
        UpdateGymProfileRequest $request,
        GymProfile $gymProfile
    ): RedirectResponse {
        $this->service->updateProfile(
            $gymProfile,
            $request->validated()
        );

        return redirect()
            ->route('admin.gym-profile.index')
            ->with('success', 'تم تحديث بيانات الجيم بنجاح.');
    }
}
