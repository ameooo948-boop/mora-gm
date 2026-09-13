<?php

namespace Database\Seeders;

use App\Models\GymProfile;
use Illuminate\Database\Seeder;

class GymProfileSeeder extends Seeder
{
    public function run(): void
    {
        GymProfile::query()->delete();

        GymProfile::create([
            'name' => 'MORA GYM',
            'eyebrow' => 'ABOUT MORA',

            'about_title' => 'More Than A Gym.',

            'about_description' => 'MORA is a focused training space built for people who want to train consistently, improve their strength, and become better every day.',

            'mission_title' => 'Our Mission',

            'mission' => 'To provide a focused, comfortable, and motivating environment where every member can train with purpose and stay consistent.',

            'vision_title' => 'Our Vision',

            'vision' => 'To build a strong local fitness community based on discipline, consistency, and real progress.',

            'image' => 'about/mora-gym.webp',

            'space_size' => 150,

            'trainer_count' => 2,

            'is_active' => true,
        ]);
    }
}
