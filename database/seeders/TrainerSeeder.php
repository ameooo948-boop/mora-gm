<?php

namespace Database\Seeders;

use App\Models\Trainer;
use App\Models\TrainingSession;
use Illuminate\Database\Seeder;

class TrainerSeeder extends Seeder
{
    public function run(): void
    {
        $ladiesSession = TrainingSession::query()
            ->where('audience', 'Women')
            ->firstOrFail();

        $menSession = TrainingSession::query()
            ->where('audience', 'Men')
            ->firstOrFail();

        $femaleTrainer = Trainer::updateOrCreate(
            ['slug' => 'mai-omar'],
            [
                'name' => 'Mai Omar',
                'gender' => 'female',
                'specialization' => 'Physical Education',
                'bio' => 'A qualified fitness coach with a background in Physical Education, dedicated to helping members train consistently and achieve their goals.',
                'image' => null,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        $maleTrainer = Trainer::updateOrCreate(
            ['slug' => 'mohamed-ramadan'],
            [
                'name' => 'Mohamed Ramadan',
                'gender' => 'male',
                'specialization' => 'Physical Education',
                'bio' => 'A qualified fitness coach with a background in Physical Education, focused on helping members build strength, consistency, and better training habits.',
                'image' => null,
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        $ladiesSession->trainers()->sync([
            $femaleTrainer->id,
        ]);

        $menSession->trainers()->sync([
            $maleTrainer->id,
        ]);
    }
}
