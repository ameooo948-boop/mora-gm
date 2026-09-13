<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;

class GalleryItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Training Floor',
                'category' => 'GYM',
                'image' => 'gallery/training-floor.webp',
                'description' => 'A focused training environment built for consistent progress.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Strength Area',
                'category' => 'TRAINING',
                'image' => 'gallery/strength-area.webp',
                'description' => 'A dedicated space for strength and performance training.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'MORA Atmosphere',
                'category' => 'SPACE',
                'image' => 'gallery/mora-atmosphere.webp',
                'description' => 'A clean, focused atmosphere designed to keep you locked in.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Daily Training',
                'category' => 'TRAINING',
                'image' => 'gallery/daily-training.webp',
                'description' => 'Train with purpose. Stay consistent. Keep progressing.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Training Equipment',
                'category' => 'EQUIPMENT',
                'image' => 'gallery/training-equipment.webp',
                'description' => 'Essential equipment for effective everyday training.',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'MORA GYM',
                'category' => 'MORA',
                'image' => 'gallery/mora-gym.webp',
                'description' => 'More than a gym. A place to build better habits.',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($items as $item) {
            GalleryItem::updateOrCreate(
                ['image' => $item['image']],
                $item
            );
        }
    }
}
