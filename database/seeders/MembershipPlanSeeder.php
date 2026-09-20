<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;

class MembershipPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'slug' => 'monthly',
                'name' => 'شهري',
                'duration_days' => 30,
                'price' => 300,
                'short_description' => 'عضوية شهرية مرنة.',
                'description' => 'عضوية شهرية بسيطة للتدريب المستمر.',
                'features' => [
                    'دخول كامل إلى الجيم',
                    'إرشاد من مدرب محترف',
                    'الاستفادة من مواعيد التدريب اليومية',
                ],
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'slug' => '3-months',
                'name' => '3 أشهر',
                'duration_days' => 90,
                'price' => 750,
                'short_description' => 'التزم بثلاثة أشهر من التقدم.',
                'description' => 'عضوية أطول مصممة للأعضاء الذين يركزون على الاستمرارية.',
                'features' => [
                    'دخول كامل إلى الجيم',
                    'إرشاد من مدرب محترف',
                    'الاستفادة من مواعيد التدريب اليومية',
                ],
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'slug' => '6-months',
                'name' => '6 أشهر',
                'duration_days' => 180,
                'price' => 1500,
                'short_description' => 'التزام طويل المدى، ونتائج مستمرة.',
                'description' => 'عضوية لمدة ستة أشهر للأعضاء الملتزمين بالتقدم على المدى الطويل.',
                'features' => [
                    'دخول كامل إلى الجيم',
                    'إرشاد من مدرب محترف',
                    'الاستفادة من مواعيد التدريب اليومية',
                ],
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            $existing = MembershipPlan::query()->firstOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );

            $updates = [];

            $legacyNames = [
                'monthly' => 'Monthly',
                '3-months' => '3 Months',
                '6-months' => '6 Months',
            ];

            if ($existing->name === ($legacyNames[$plan['slug']] ?? null)) {
                $updates['name'] = $plan['name'];
            }

            if ($plan['slug'] === '6-months' && (float) $existing->price === 1400.0) {
                $updates['price'] = 1500;
            }

            if ($updates) {
                $existing->update($updates);
            }
        }
    }
}
