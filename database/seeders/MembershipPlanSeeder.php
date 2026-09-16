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
            'name' => 'شهري',
            'slug' => 'monthly',
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
        ]);

        MembershipPlan::create([
            'name' => '3 Months',
            'slug' => '3-months',
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
        ]);

        MembershipPlan::create([
            'name' => '6 Months',
            'slug' => '6-months',
            'duration_days' => 180,
            'price' => 1400,
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
        ]);
    }
}
