<?php

use App\Enums\UserRole;
use App\Models\GalleryItem;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

it('allows an admin to manage gallery items', function () {
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN,
    ]);

    $image = UploadedFile::fake()->create(
        'gallery-test.webp',
        100,
        'image/webp'
    );

    $this->actingAs($admin)
        ->post(route('admin.gallery.store'), [
            'title' => 'صالة MORA',
            'category' => 'الجيم',
            'image' => $image,
            'description' => 'صورة تجريبية.',
            'sort_order' => 1,
            'is_active' => 1,
        ])
        ->assertRedirect(route('admin.gallery.index'));

    $item = GalleryItem::query()->firstOrFail();

    expect($item->title)->toBe('صالة MORA')
        ->and($item->image)->toStartWith('gallery/');

    Storage::disk('public')->assertExists($item->image);

    $oldImage = $item->image;

    $newImage = UploadedFile::fake()->create(
        'gallery-test-2.webp',
        100,
        'image/webp'
    );

    $this->actingAs($admin)
        ->put(route('admin.gallery.update', $item->id), [
            'title' => 'صالة MORA الجديدة',
            'category' => 'التدريب',
            'image' => $newImage,
            'description' => 'وصف محدث.',
            'sort_order' => 2,
            'is_active' => 1,
        ])
        ->assertRedirect(route('admin.gallery.index'));

    $item->refresh();

    expect($item->title)->toBe('صالة MORA الجديدة')
        ->and($item->image)->not->toBe($oldImage);

    Storage::disk('public')->assertExists($item->image);
    Storage::disk('public')->assertMissing($oldImage);

    $imageToDelete = $item->image;

    $this->actingAs($admin)
        ->delete(route('admin.gallery.destroy', $item->id))
        ->assertRedirect(route('admin.gallery.index'));

    expect(GalleryItem::query()->find($item->id))->toBeNull();

    Storage::disk('public')->assertMissing($imageToDelete);
});

it('allows an admin to update gallery item without replacing the image', function () {
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN,
    ]);

    $image = UploadedFile::fake()->create(
        'gallery-test.webp',
        100,
        'image/webp'
    );

    $this->actingAs($admin)
        ->post(route('admin.gallery.store'), [
            'title' => 'صالة MORA',
            'category' => 'الجيم',
            'image' => $image,
            'description' => 'صورة تجريبية.',
            'sort_order' => 1,
            'is_active' => 1,
        ]);

    $item = GalleryItem::query()->firstOrFail();

    $oldImage = $item->image;

    $this->actingAs($admin)
        ->put(route('admin.gallery.update', $item->id), [
            'title' => 'صالة MORA المعدلة',
            'category' => 'التدريب',
            'description' => 'وصف محدث بدون تغيير الصورة.',
            'sort_order' => 2,
            'is_active' => 1,
        ])
        ->assertRedirect(route('admin.gallery.index'));

    $item->refresh();

    expect($item->title)->toBe('صالة MORA المعدلة')
        ->and($item->image)->toBe($oldImage);

    Storage::disk('public')->assertExists($oldImage);
});

it('prevents members from accessing gallery administration', function () {
    $member = User::factory()->create([
        'role' => UserRole::MEMBER,
    ]);

    $this->actingAs($member)
        ->get(route('admin.gallery.index'))
        ->assertForbidden();
});
