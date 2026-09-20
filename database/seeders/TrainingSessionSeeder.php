<?php

namespace Database\Seeders;

use App\Models\TrainingSession;
use Illuminate\Database\Seeder;

class TrainingSessionSeeder extends Seeder
{
    public function run(): void
    {
        TrainingSession::query()->firstOrCreate(
            ['audience' => 'Women'],
            [
                'name' => 'تدريب السيدات صباحًا',
                'starts_at' => '10:00:00',
                'ends_at' => '18:00:00',
                'description' => 'موعد تدريبي مخصص للسيدات.',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        TrainingSession::query()->firstOrCreate(
            ['audience' => 'Men'],
            [
                'name' => 'تدريب الرجال مساءً',
                'starts_at' => '18:00:00',
                'ends_at' => '03:00:00',
                'description' => 'موعد تدريبي مسائي مخصص للرجال.',
                'is_active' => true,
                'sort_order' => 2,
            ]
        );
    }
}
