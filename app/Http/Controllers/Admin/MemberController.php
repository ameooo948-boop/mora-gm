<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index(Request $request): View
    {
        return view('admin.members.index', [
            'members' => $this->userService->getMembers(
                $request->string('search')->trim()->value()
                    ?: null
            ),
            'search' => $request->string('search')->trim()->value(),
        ]);
    }

    public function show(int $member): View
    {
        $user = $this->userService->getMember($member);

        abort_unless($user, 404);

        return view('admin.members.show', [
            'member' => $user,
        ]);
    }
}
