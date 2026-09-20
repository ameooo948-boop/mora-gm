<?php

use App\Enums\Gender;
use App\Enums\PaymentStatus;
use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Trainer;
use App\Models\User;

it('resets member email verification when an admin changes the email', function () {
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN,
    ]);

    $member = User::factory()->create([
        'role' => UserRole::MEMBER,
        'gender' => Gender::MALE,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($admin)
        ->put(route('admin.members.update', $member->id), [
            'name' => $member->name,
            'email' => 'updated@example.com',
            'phone' => $member->phone,
            'gender' => Gender::MALE->value,
        ])
        ->assertRedirect(route('admin.members.show', $member->id));

    expect($member->fresh()->email)->toBe('updated@example.com')
        ->and($member->fresh()->email_verified_at)->toBeNull();
});

it('rejects an invalid local image path in gallery administration', function () {
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN,
    ]);

    $this->actingAs($admin)
        ->post(route('admin.gallery.store'), [
            'title' => 'صورة تجريبية',
            'category' => 'الجيم',
            'image' => '../secret.webp',
            'description' => 'وصف.',
            'sort_order' => 1,
            'is_active' => 1,
        ])
        ->assertSessionHasErrors('image');
});

it('rejects a training session whose start and end times are identical', function () {
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN,
    ]);

    $trainer = Trainer::query()->create([
        'name' => 'مدرب تجريبي',
        'slug' => 'same-time-session-trainer',
        'gender' => 'male',
        'specialization' => 'تربية رياضية',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $this->actingAs($admin)
        ->post(route('admin.training-sessions.store'), [
            'name' => 'جلسة تجريبية',
            'audience' => 'Men',
            'trainer_id' => $trainer->id,
            'starts_at' => '18:00',
            'ends_at' => '18:00',
            'description' => 'جلسة اختبار.',
            'is_active' => 1,
            'sort_order' => 1,
        ])
        ->assertSessionHasErrors('ends_at');
});

it('does not approve a payment when its amount differs from the subscription price', function () {
    $member = User::factory()->create([
        'role' => UserRole::MEMBER,
        'gender' => Gender::MALE,
    ]);

    $plan = MembershipPlan::query()->create([
        'name' => 'شهري',
        'slug' => 'payment-mismatch-test',
        'duration_days' => 30,
        'price' => 300,
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $subscription = Subscription::query()->create([
        'user_id' => $member->id,
        'membership_plan_id' => $plan->id,
        'price' => 300,
        'duration_days' => 30,
        'status' => SubscriptionStatus::PENDING,
    ]);

    $payment = Payment::query()->create([
        'user_id' => $member->id,
        'subscription_id' => $subscription->id,
        'amount' => 250,
        'method' => 'vodafone_cash',
        'transaction_reference' => 'VF-MISMATCH-123',
        'status' => PaymentStatus::PENDING,
    ]);

    $admin = User::factory()->create([
        'role' => UserRole::ADMIN,
    ]);

    $this->actingAs($admin)
        ->post(route('admin.payments.approve', $payment->id))
        ->assertSessionHasErrors('payment');

    expect($payment->fresh()->status)->toBe(PaymentStatus::PENDING)
        ->and($subscription->fresh()->status)->toBe(SubscriptionStatus::PENDING);
});
