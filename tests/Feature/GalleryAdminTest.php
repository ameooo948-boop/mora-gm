<?php

use App\Enums\UserRole;
use App\Models\GalleryItem;
use App\Models\User;

it('allows an admin to manage gallery items', function () {
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN,
    ]);

    $this->actingAs($admin)
        ->post(route('admin.gallery.store'), [
            'title' => 'صالة MORA',
            'category' => 'الجيم',
            'image' => 'gallery/test.webp',
            'description' => 'صورة تجريبية.',
            'sort_order' => 1,
            'is_active' => 1,
        ])
        ->assertRedirect(route('admin.gallery.index'));

    $item = GalleryItem::query()->firstOrFail();

    expect($item->title)->toBe('صالة MORA');

    $this->actingAs($admin)
        ->put(route('admin.gallery.update', $item->id), [
            'title' => 'صالة MORA الجديدة',
            'category' => 'التدريب',
            'image' => 'gallery/test-2.webp',
            'description' => 'وصف محدث.',
            'sort_order' => 2,
            'is_active' => 1,
        ])
        ->assertRedirect(route('admin.gallery.index'));

    expect($item->fresh()->title)->toBe('صالة MORA الجديدة');

    $this->actingAs($admin)
        ->delete(route('admin.gallery.destroy', $item->id))
        ->assertRedirect(route('admin.gallery.index'));

    expect(GalleryItem::query()->find($item->id))->toBeNull();
});

it('prevents members from accessing gallery administration', function () {
    $member = User::factory()->create([
        'role' => UserRole::MEMBER,
    ]);

    $this->actingAs($member)
        ->get(route('admin.gallery.index'))
        ->assertForbidden();
});
