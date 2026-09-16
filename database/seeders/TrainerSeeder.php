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
                'specialization' => 'تربية رياضية',
                'bio' => 'مدرب لياقة مؤهل بخلفية في التربية الرياضية، يكرّس خبرته لمساعدة الأعضاء على التدريب باستمرار وتحقيق أهدافهم.',
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
                'specialization' => 'تربية رياضية',
                'bio' => 'مدرب لياقة مؤهل بخلفية في التربية الرياضية، يركز على مساعدة الأعضاء في بناء القوة والاستمرارية وعادات تدريب أفضل.',
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
