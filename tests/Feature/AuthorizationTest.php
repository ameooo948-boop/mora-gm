<?php

use App\Enums\UserRole;
use App\Models\User;

it('redirects guests to the login page when they open the admin dashboard', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('login'));
});

it('prevents members from accessing admin pages', function () {
    $member = User::factory()->create([
        'role' => UserRole::MEMBER,
    ]);

    $this->actingAs($member)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

it('prevents admins from accessing member pages', function () {
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN,
    ]);

    $this->actingAs($admin)
        ->get(route('member.dashboard'))
        ->assertForbidden();
});

it('redirects an admin to the admin dashboard after login', function () {
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN,
        'password' => 'password',
    ]);

    $this->post(route('login.store'), [
        'email' => $admin->email,
        'password' => 'password',
    ])->assertRedirect(route('admin.dashboard'));
});

it('creates every newly registered account as a member', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'عضو جديد',
        'email' => 'member@example.com',
        'gender' => 'male',
        'phone' => '01000000000',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('verification.notice'));

    expect(User::query()->where('email', 'member@example.com')->value('role'))
        ->toBe(UserRole::MEMBER);
});
