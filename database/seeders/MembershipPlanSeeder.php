<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;

class MembershipPlanSeeder extends Seeder
{
    public function run(): void
    {
        MembershipPlan::query()->delete();

        MembershipPlan::create([
            'name' => 'Monthly',
            'slug' => 'monthly',
            'duration_days' => 30,
            'price' => 300,
            'short_description' => 'Flexible monthly membership.',
            'description' => 'A simple monthly membership for consistent training.',
            'features' => [
                'Full gym access',
                'Professional trainer guidance',
                'Access to daily training sessions',
            ],
            'is_featured' => false,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        MembershipPlan::create([
            'name' => '3 Months',
            'slug' => '3-months',
            'duration_days' => 90,
            'price' => 750,
            'short_description' => 'Commit to three months of progress.',
            'description' => 'A longer membership designed for members focused on consistency.',
            'features' => [
                'Full gym access',
                'Professional trainer guidance',
                'Access to daily training sessions',
            ],
            'is_featured' => true,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        MembershipPlan::create([
            'name' => '6 Months',
            'slug' => '6-months',
            'duration_days' => 180,
            'price' => 1400,
            'short_description' => 'Long-term commitment, lasting results.',
            'description' => 'A six-month membership for members committed to long-term progress.',
            'features' => [
                'Full gym access',
                'Professional trainer guidance',
                'Access to daily training sessions',
            ],
            'is_featured' => false,
            'is_active' => true,
            'sort_order' => 3,
        ]);
    }
}
