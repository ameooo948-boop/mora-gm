<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMembershipPlanRequest;
use App\Http\Requests\Admin\UpdateMembershipPlanRequest;
use App\Models\MembershipPlan;
use App\Services\MembershipPlanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipPlanController extends Controller
{
    public function __construct(
        protected MembershipPlanService $service
    ) {}

    public function index(Request $request): View
    {
        $plans = $this->service->getAllPlans(
            $request->string('search')->toString()
        );

        return view('admin.membership-plans.index', compact('plans'));
    }

    public function create(): View
    {
        return view('admin.membership-plans.create');
    }

    public function store(StoreMembershipPlanRequest $request): RedirectResponse
    {
        $this->service->createPlan($request->validated());

        return redirect()
            ->route('admin.membership-plans.index')
            ->with('success', 'تمت إضافة خطة العضوية بنجاح.');
    }

    public function edit(MembershipPlan $membershipPlan): View
    {
        return view('admin.membership-plans.edit', compact('membershipPlan'));
    }

    public function update(
        UpdateMembershipPlanRequest $request,
        MembershipPlan $membershipPlan
    ): RedirectResponse {
        $this->service->updatePlan(
            $membershipPlan,
            $request->validated()
        );

        return redirect()
            ->route('admin.membership-plans.index')
            ->with('success', 'تم تحديث خطة العضوية بنجاح.');
    }
}
