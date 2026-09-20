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

        $femaleTrainer = Trainer::firstOrCreate(
            ['slug' => 'mai-omar'],
            [
                'name' => 'مي عمر',
                'gender' => 'female',
                'specialization' => 'تربية رياضية',
                'bio' => 'مدربة لياقة مؤهلة بخلفية في التربية الرياضية، تكرّس خبرتها لمساعدة العضوات على التدريب باستمرار وتحقيق أهدافهن.',
                'image' => null,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        $maleTrainer = Trainer::firstOrCreate(
            ['slug' => 'mohamed-ramadan'],
            [
                'name' => 'محمد رمضان',
                'gender' => 'male',
                'specialization' => 'تربية رياضية',
                'bio' => 'مدرب لياقة مؤهل بخلفية في التربية الرياضية، يركز على مساعدة الأعضاء في بناء القوة والاستمرارية وعادات تدريب أفضل.',
                'image' => null,
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        $legacyFemaleNames = ['Mai Omar'];
        if (in_array($femaleTrainer->name, $legacyFemaleNames, true)) {
            $femaleTrainer->update([
                'name' => 'مي عمر',
                'bio' => 'مدربة لياقة مؤهلة بخلفية في التربية الرياضية، تكرّس خبرتها لمساعدة العضوات على التدريب باستمرار وتحقيق أهدافهن.',
            ]);
        }

        $legacyMaleNames = ['Mohamed Ramadan'];
        if (in_array($maleTrainer->name, $legacyMaleNames, true)) {
            $maleTrainer->update([
                'name' => 'محمد رمضان',
            ]);
        }

        if (! $ladiesSession->trainers()->whereKey($femaleTrainer->id)->exists()) {
            $ladiesSession->trainers()->attach($femaleTrainer->id);
        }

        if (! $menSession->trainers()->whereKey($maleTrainer->id)->exists()) {
            $menSession->trainers()->attach($maleTrainer->id);
        }
    }
}
