<?php

namespace Database\Seeders;

use App\Models\GymProfile;
use Illuminate\Database\Seeder;

class GymProfileSeeder extends Seeder
{
    public function run(): void
    {
        if (GymProfile::query()->exists()) {
            return;
        }

        GymProfile::create([
            'name' => 'MORA GYM',
            'eyebrow' => 'عن MORA',

            'about_title' => 'أكثر من مجرد جيم.',

            'about_description' => 'MORA مساحة تدريب متخصصة صُممت لمن يريدون التدريب باستمرار، وتطوير قوتهم، وأن يصبحوا أفضل كل يوم.',

            'mission_title' => 'رسالتنا',

            'mission' => 'توفير بيئة تدريبية مريحة ومحفزة ومركزة، تتيح لكل عضو التدريب بهدف والحفاظ على الاستمرارية.',

            'vision_title' => 'رؤيتنا',

            'vision' => 'بناء مجتمع لياقة بدنية قوي يقوم على الانضباط والاستمرارية والتقدم الحقيقي.',

            'image' => 'about/mora-gym.webp',

            'space_size' => 150,

            'trainer_count' => 2,

            'is_active' => true,

            'phone' => '01063950691',
            'whatsapp' => '01063950691',
            'email' => 'amrwael105@gmail.com',
            'address' => 'الدقهلية، نبروه، الدروتين',
            'instagram_url' => null,
            'vodafone_cash' => '01063950691',
        ]);
    }
}
