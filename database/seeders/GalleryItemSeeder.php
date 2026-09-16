<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;

class GalleryItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'منطقة التدريب',
                'category' => 'الجيم',
                'image' => 'gallery/training-floor.webp',
                'description' => 'بيئة تدريبية مركزة مصممة لتحقيق تقدم مستمر.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'منطقة القوة',
                'category' => 'التدريب',
                'image' => 'gallery/strength-area.webp',
                'description' => 'مساحة مخصصة لتدريب القوة والأداء.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'أجواء MORA',
                'category' => 'المكان',
                'image' => 'gallery/mora-atmosphere.webp',
                'description' => 'أجواء نظيفة ومركزة تساعدك على الحفاظ على تركيزك.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'التدريب اليومي',
                'category' => 'التدريب',
                'image' => 'gallery/daily-training.webp',
                'description' => 'تدرّب بهدف. حافظ على استمراريتك. واصل التقدم.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'معدات التدريب',
                'category' => 'المعدات',
                'image' => 'gallery/training-equipment.webp',
                'description' => 'معدات أساسية لتدريب يومي فعال.',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'MORA GYM',
                'category' => 'MORA',
                'image' => 'gallery/mora-gym.webp',
                'description' => 'أكثر من مجرد جيم. مكان لبناء عادات أفضل.',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($items as $item) {
            GalleryItem::updateOrCreate(
                ['image' => $item['image']],
                $item
            );
        }
    }
}
