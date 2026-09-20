<?php

use App\Enums\UserRole;
use App\Models\Trainer;
use App\Models\User;

it('does not allow assigning a trainer with the wrong gender to a training session', function () {
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN,
    ]);

    $maleTrainer = Trainer::query()->create([
        'name' => 'مدرب تجريبي',
        'slug' => 'test-male-trainer',
        'gender' => 'male',
        'specialization' => 'تربية رياضية',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $this->actingAs($admin)
        ->post(route('admin.training-sessions.store'), [
            'name' => 'جلسة سيدات تجريبية',
            'audience' => 'Women',
            'trainer_id' => $maleTrainer->id,
            'starts_at' => '10:00',
            'ends_at' => '18:00',
            'description' => 'جلسة اختبار.',
            'is_active' => 1,
            'sort_order' => 1,
        ])
        ->assertSessionHasErrors('trainer_id');
});
