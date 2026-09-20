<?php

use App\Enums\Gender;
use App\Enums\PaymentStatus;
use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;

it('creates a pending subscription and payment from an active plan', function () {
    $member = User::factory()->create([
        'role' => UserRole::MEMBER,
        'gender' => Gender::MALE,
    ]);

    $plan = MembershipPlan::query()->create([
        'name' => 'شهري',
        'slug' => 'monthly-test',
        'duration_days' => 30,
        'price' => 300,
        'short_description' => 'عضوية شهرية.',
        'description' => 'عضوية شهرية.',
        'features' => ['دخول كامل إلى الجيم'],
        'is_featured' => false,
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $response = $this->actingAs($member)->post(
        route('member.membership.subscribe', $plan)
    );

    $subscription = Subscription::query()->firstOrFail();
    $payment = Payment::query()->firstOrFail();

    $response->assertRedirect(
        route('member.payment.show', $payment->id)
    );

    expect($subscription->status)->toBe(SubscriptionStatus::PENDING)
        ->and((float) $subscription->price)->toBe(300.0)
        ->and($subscription->duration_days)->toBe(30)
        ->and($payment->status)->toBe(PaymentStatus::PENDING)
        ->and((float) $payment->amount)->toBe(300.0);
});

it('activates a payment using the subscription duration snapshot', function () {
    $member = User::factory()->create([
        'role' => UserRole::MEMBER,
        'gender' => Gender::MALE,
    ]);

    $plan = MembershipPlan::query()->create([
        'name' => '6 أشهر',
        'slug' => 'six-months-test',
        'duration_days' => 180,
        'price' => 1500,
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $subscription = Subscription::query()->create([
        'user_id' => $member->id,
        'membership_plan_id' => $plan->id,
        'price' => 1500,
        'duration_days' => 180,
        'status' => SubscriptionStatus::PENDING,
    ]);

    $payment = Payment::query()->create([
        'user_id' => $member->id,
        'subscription_id' => $subscription->id,
        'amount' => 1500,
        'method' => 'vodafone_cash',
        'transaction_reference' => 'VF123456',
        'status' => PaymentStatus::PENDING,
    ]);

    $admin = User::factory()->create([
        'role' => UserRole::ADMIN,
    ]);

    $now = Carbon::parse('2026-09-20 23:30:00', 'Africa/Cairo');
    Carbon::setTestNow($now);

    try {
        $this->actingAs($admin)
            ->post(route('admin.payments.approve', $payment->id))
            ->assertRedirect();

        $subscription = $subscription->fresh();
        $payment = $payment->fresh();

        expect($payment->status)->toBe(PaymentStatus::PAID)
            ->and($subscription->status)->toBe(SubscriptionStatus::ACTIVE)
            ->and($subscription->starts_at->equalTo($now))->toBeTrue()
            ->and($subscription->ends_at->equalTo($now->copy()->addDays(180)))->toBeTrue();
    } finally {
        Carbon::setTestNow();
    }
});

it('does not expose another member payment to the current member', function () {
    $owner = User::factory()->create([
        'role' => UserRole::MEMBER,
    ]);

    $otherMember = User::factory()->create([
        'role' => UserRole::MEMBER,
    ]);

    $plan = MembershipPlan::query()->create([
        'name' => 'شهري',
        'slug' => 'monthly-access-test',
        'duration_days' => 30,
        'price' => 300,
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $subscription = Subscription::query()->create([
        'user_id' => $owner->id,
        'membership_plan_id' => $plan->id,
        'price' => 300,
        'duration_days' => 30,
        'status' => SubscriptionStatus::PENDING,
    ]);

    $payment = Payment::query()->create([
        'user_id' => $owner->id,
        'subscription_id' => $subscription->id,
        'amount' => 300,
        'method' => 'vodafone_cash',
        'status' => PaymentStatus::PENDING,
    ]);

    $this->actingAs($otherMember)
        ->get(route('member.payment.show', $payment->id))
        ->assertNotFound();
});
