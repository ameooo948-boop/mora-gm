<?php

use App\Enums\Gender;
use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use App\Models\MembershipPlan;
use App\Models\Subscription;
use App\Models\TrainingSession;
use App\Models\User;
use Carbon\Carbon;

it('records overnight attendance under the previous session date', function () {
    $member = User::factory()->create([
        'role' => UserRole::MEMBER,
        'gender' => Gender::MALE,
    ]);

    $plan = MembershipPlan::query()->create([
        'name' => 'شهري',
        'slug' => 'monthly-attendance-test',
        'duration_days' => 30,
        'price' => 300,
        'is_active' => true,
        'sort_order' => 1,
    ]);

    Subscription::query()->create([
        'user_id' => $member->id,
        'membership_plan_id' => $plan->id,
        'price' => 300,
        'duration_days' => 30,
        'starts_at' => '2026-09-01 00:00:00',
        'ends_at' => '2026-10-01 00:00:00',
        'status' => SubscriptionStatus::ACTIVE,
    ]);

    $session = TrainingSession::query()->create([
        'name' => 'تدريب الرجال مساءً',
        'audience' => 'Men',
        'starts_at' => '18:00:00',
        'ends_at' => '03:00:00',
        'description' => 'جلسة مسائية.',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    Carbon::setTestNow(Carbon::parse('2026-09-20 02:30:00', 'Africa/Cairo'));

    try {
        $this->actingAs($member)
            ->post(route('member.attendance.check-in', $session))
            ->assertRedirect();

        $attendance = $member->attendances()->firstOrFail();

        expect($attendance->attendance_date->toDateString())
            ->toBe('2026-09-19');

        Carbon::setTestNow(Carbon::parse('2026-09-20 03:00:00', 'Africa/Cairo'));

        $this->actingAs($member)
            ->post(route('member.attendance.check-out', $session))
            ->assertRedirect();

        expect($attendance->fresh()->checked_out_at)->not->toBeNull();
    } finally {
        Carbon::setTestNow();
    }
});

it('rejects check-in for an inactive training session', function () {
    $member = User::factory()->create([
        'role' => UserRole::MEMBER,
        'gender' => Gender::MALE,
    ]);

    $plan = MembershipPlan::query()->create([
        'name' => 'شهري',
        'slug' => 'monthly-inactive-session-test',
        'duration_days' => 30,
        'price' => 300,
        'is_active' => true,
        'sort_order' => 1,
    ]);

    Subscription::query()->create([
        'user_id' => $member->id,
        'membership_plan_id' => $plan->id,
        'price' => 300,
        'duration_days' => 30,
        'starts_at' => '2026-09-01 00:00:00',
        'ends_at' => '2026-10-01 00:00:00',
        'status' => SubscriptionStatus::ACTIVE,
    ]);

    $session = TrainingSession::query()->create([
        'name' => 'جلسة غير متاحة',
        'audience' => 'Men',
        'starts_at' => '18:00:00',
        'ends_at' => '03:00:00',
        'is_active' => false,
        'sort_order' => 1,
    ]);

    Carbon::setTestNow(Carbon::parse('2026-09-20 20:00:00', 'Africa/Cairo'));

    try {
        $this->actingAs($member)
            ->post(route('member.attendance.check-in', $session))
            ->assertSessionHasErrors('attendance');
    } finally {
        Carbon::setTestNow();
    }
});
