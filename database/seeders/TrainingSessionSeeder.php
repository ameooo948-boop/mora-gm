<?php

namespace Database\Seeders;

use App\Models\TrainingSession;
use Illuminate\Database\Seeder;

class TrainingSessionSeeder extends Seeder
{
    public function run(): void
    {
        TrainingSession::query()->delete();

        TrainingSession::create([
            'name' => 'Ladies Morning',
            'audience' => 'Women',
            'starts_at' => '10:00:00',
            'ends_at' => '18:00:00',
            'description' => 'A dedicated training session for women.',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        TrainingSession::create([
            'name' => 'Men Evening',
            'audience' => 'Men',
            'starts_at' => '18:00:00',
            'ends_at' => '03:00:00',
            'description' => 'A dedicated evening training session for men.',
            'is_active' => true,
            'sort_order' => 2,
        ]);
    }
}
