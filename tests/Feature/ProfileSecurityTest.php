<?php

use App\Enums\Gender;
use App\Enums\UserRole;
use App\Models\User;

it('does not allow members to change their gender through profile updates', function () {
    $member = User::factory()->create([
        'role' => UserRole::MEMBER,
        'gender' => Gender::MALE,
    ]);

    $this->actingAs($member)
        ->put(route('member.profile.update'), [
            'name' => 'اسم محدث',
            'phone' => '01000000000',
            'gender' => Gender::FEMALE->value,
        ])
        ->assertRedirect();

    expect($member->fresh()->gender)->toBe(Gender::MALE);
});
