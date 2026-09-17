<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function edit(Request $request): View
    {
        return view('member.profile', [
            'user' => $request->user(),
        ]);
    }

    public function update(
        UpdateProfileRequest $request
    ): RedirectResponse {
        $this->userService->updateProfile(
            $request->user(),
            $request->validated()
        );

        return back()->with(
            'success',
            'تم تحديث بيانات حسابك بنجاح.'
        );
    }
}
