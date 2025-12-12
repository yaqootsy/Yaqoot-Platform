<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // 1. الإلكترونيات (department_id: 1)
                [
                    'name' => 'إكسسوارات إلكترونية',
                    'department_id' => 1,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الجوالات والاكسسوارات',
                    'department_id' => 1,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'جالاكسي Al',
                    'department_id' => 1,
                    'parent_id' => 1,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'آيفون',
                    'department_id' => 1,
                    'parent_id' => 1,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'جوالات أندرويد فخمة',
                    'department_id' => 1,
                    'parent_id' => 1,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تابلت',
                    'department_id' => 1,
                    'parent_id' => 1,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'سماعات ومكبرات صوت',
                    'department_id' => 1,
                    'parent_id' => 1,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة الارتداء',
                    'department_id' => 1,
                    'parent_id' => 1,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شواحن متنقلة',
                    'department_id' => 1,
                    'parent_id' => 1,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شواحن',
                    'department_id' => 1,
                    'parent_id' => 1,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'اللابتوبات واكسسواراتها',
                    'department_id' => 1,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ماك بوك',
                    'department_id' => 1,
                    'parent_id' => 10,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'لابتوبات قوية',
                    'department_id' => 1,
                    'parent_id' => 10,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'لابتوبات لعب',
                    'department_id' => 1,
                    'parent_id' => 10,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'لابتوبات على الميزانية',
                    'department_id' => 1,
                    'parent_id' => 10,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شاشات',
                    'department_id' => 1,
                    'parent_id' => 10,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'طابعات',
                    'department_id' => 1,
                    'parent_id' => 10,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة تخزين',
                    'department_id' => 1,
                    'parent_id' => 10,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة إدخال',
                    'department_id' => 1,
                    'parent_id' => 10,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أساسيات اللعب',
                    'department_id' => 1,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة اللعب',
                    'department_id' => 1,
                    'parent_id' => 19,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أكسسوارات اللعب',
                    'department_id' => 1,
                    'parent_id' => 19,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ألعاب الفيديو',
                    'department_id' => 1,
                    'parent_id' => 19,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شاشات اللعب',
                    'department_id' => 1,
                    'parent_id' => 19,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بطاقات رقمية',
                    'department_id' => 1,
                    'parent_id' => 19,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التلفزيونات والترفيه المنزلي',
                    'department_id' => 1,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'LED',
                    'department_id' => 1,
                    'parent_id' => 25,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'QLED',
                    'department_id' => 1,
                    'parent_id' => 25,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'OLED',
                    'department_id' => 1,
                    'parent_id' => 25,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => '4K',
                    'department_id' => 1,
                    'parent_id' => 25,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => '8K',
                    'department_id' => 1,
                    'parent_id' => 25,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بروجكترات',
                    'department_id' => 1,
                    'parent_id' => 25,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ساوند بار',
                    'department_id' => 1,
                    'parent_id' => 25,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة البث',
                    'department_id' => 1,
                    'parent_id' => 25,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كاميرات',
                    'department_id' => 1,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كاميرات حركية',
                    'department_id' => 1,
                    'parent_id' => 34,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كاميرات رقمية',
                    'department_id' => 1,
                    'parent_id' => 34,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كاميرات مراقبة',
                    'department_id' => 1,
                    'parent_id' => 34,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كاميرات فورية',
                    'department_id' => 1,
                    'parent_id' => 34,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'اكسسوارات الكاميرات',
                    'department_id' => 1,
                    'parent_id' => 34,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],

            // 2. أزياء الرجال (department_id: 3)
                [
                    'name' => 'ربيع/صيف',
                    'department_id' => 3,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تيشيرتات',
                    'department_id' => 3,
                    'parent_id' => 40,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'البولو',
                    'department_id' => 3,
                    'parent_id' => 40,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'السنيكزر والأحذية الرياضية',
                    'department_id' => 3,
                    'parent_id' => 40,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'البنطلونات',
                    'department_id' => 3,
                    'parent_id' => 40,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ملابس السباحة',
                    'department_id' => 3,
                    'parent_id' => 40,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شباشب',
                    'department_id' => 3,
                    'parent_id' => 40,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ملابس',
                    'department_id' => 3,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ملابس تقليدية',
                    'department_id' => 3,
                    'parent_id' => 47,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تيشرتات',
                    'department_id' => 3,
                    'parent_id' => 47,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بولو',
                    'department_id' => 3,
                    'parent_id' => 47,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'قمصان',
                    'department_id' => 3,
                    'parent_id' => 47,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بنطلونات',
                    'department_id' => 3,
                    'parent_id' => 47,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'جينزات',
                    'department_id' => 3,
                    'parent_id' => 47,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ملابس رياضية',
                    'department_id' => 3,
                    'parent_id' => 47,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أحذية',
                    'department_id' => 3,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أحذية رياضية',
                    'department_id' => 3,
                    'parent_id' => 55,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'سنيكرز',
                    'department_id' => 3,
                    'parent_id' => 55,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'لوفر',
                    'department_id' => 3,
                    'parent_id' => 55,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أحذية رسمية',
                    'department_id' => 3,
                    'parent_id' => 55,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'صنادل عربية',
                    'department_id' => 3,
                    'parent_id' => 55,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أبوات',
                    'department_id' => 3,
                    'parent_id' => 55,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شباشب',
                    'department_id' => 3,
                    'parent_id' => 55,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الشنط والاكسسوارات',
                    'department_id' => 3,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شنط الظهر',
                    'department_id' => 3,
                    'parent_id' => 63,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'محافظ',
                    'department_id' => 3,
                    'parent_id' => 63,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شنط السفر',
                    'department_id' => 3,
                    'parent_id' => 63,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شنط وأغطية اللابتوب',
                    'department_id' => 3,
                    'parent_id' => 63,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مجوهرات',
                    'department_id' => 3,
                    'parent_id' => 63,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أحزمة',
                    'department_id' => 3,
                    'parent_id' => 63,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ساعات',
                    'department_id' => 3,
                    'parent_id' => 63,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'نظارات',
                    'department_id' => 3,
                    'parent_id' => 63,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],

            // 3. أزياء النساء (department_id: 2)
                [
                    'name' => 'ربيع/صيف',
                    'department_id' => 2,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بلايز',
                    'department_id' => 2,
                    'parent_id' => 72,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'فساتين',
                    'department_id' => 2,
                    'parent_id' => 72,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بنطلونات',
                    'department_id' => 2,
                    'parent_id' => 72,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الصنادل',
                    'department_id' => 2,
                    'parent_id' => 72,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التنانير',
                    'department_id' => 2,
                    'parent_id' => 72,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ملابس السباحة',
                    'department_id' => 2,
                    'parent_id' => 72,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ملابس',
                    'department_id' => 2,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بلايز',
                    'department_id' => 2,
                    'parent_id' => 79,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'فساتين',
                    'department_id' => 2,
                    'parent_id' => 79,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بنطلونات',
                    'department_id' => 2,
                    'parent_id' => 79,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العبايات والجلابيات',
                    'department_id' => 2,
                    'parent_id' => 79,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'جينزات',
                    'department_id' => 2,
                    'parent_id' => 79,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أوفرولات',
                    'department_id' => 2,
                    'parent_id' => 79,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ملابس رياضية',
                    'department_id' => 2,
                    'parent_id' => 79,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أحذية',
                    'department_id' => 2,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أحذية رياضية',
                    'department_id' => 2,
                    'parent_id' => 87,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'سنيكرز',
                    'department_id' => 2,
                    'parent_id' => 87,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'صنادل',
                    'department_id' => 2,
                    'parent_id' => 87,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كعوب',
                    'department_id' => 2,
                    'parent_id' => 87,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'فلات',
                    'department_id' => 2,
                    'parent_id' => 87,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أبوات',
                    'department_id' => 2,
                    'parent_id' => 87,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شباشب',
                    'department_id' => 2,
                    'parent_id' => 87,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الشنط والاكسسوارات',
                    'department_id' => 2,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شنط الظهر',
                    'department_id' => 2,
                    'parent_id' => 95,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شنط اليد',
                    'department_id' => 2,
                    'parent_id' => 95,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شنط السفر',
                    'department_id' => 2,
                    'parent_id' => 95,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'محافظ',
                    'department_id' => 2,
                    'parent_id' => 95,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مجوهرات',
                    'department_id' => 2,
                    'parent_id' => 95,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شنط وأغطية اللابتوب',
                    'department_id' => 2,
                    'parent_id' => 95,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ساعات',
                    'department_id' => 2,
                    'parent_id' => 95,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'نظارات',
                    'department_id' => 2,
                    'parent_id' => 95,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],

            // 4. أزياء الأطفال (department_id: 4)
                [
                    'name' => 'ملابس البنات',
                    'department_id' => 4,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تيشرتات',
                    'department_id' => 4,
                    'parent_id' => 104,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التخزين والتنظيم',
                    'department_id' => 4,
                    'parent_id' => 104,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أواني السفرة والتقديم',
                    'department_id' => 4,
                    'parent_id' => 104,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'اكسسوارات',
                    'department_id' => 4,
                    'parent_id' => 104,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أدوات المائدة',
                    'department_id' => 4,
                    'parent_id' => 104,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'القهوة والشاي',
                    'department_id' => 4,
                    'parent_id' => 104,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'هوديز وسويترات',
                    'department_id' => 4,
                    'parent_id' => 104,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ملابس الأولاد',
                    'department_id' => 4,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تيشرتات',
                    'department_id' => 4,
                    'parent_id' => 112,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بنطلونات',
                    'department_id' => 4,
                    'parent_id' => 112,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أطقم الملابس',
                    'department_id' => 4,
                    'parent_id' => 112,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أوفرولات',
                    'department_id' => 4,
                    'parent_id' => 112,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ملابس رياضة',
                    'department_id' => 4,
                    'parent_id' => 112,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'هوديز وسويترات',
                    'department_id' => 4,
                    'parent_id' => 112,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أحذية',
                    'department_id' => 4,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أحذية رياضية',
                    'department_id' => 4,
                    'parent_id' => 119,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'سنيكرز',
                    'department_id' => 4,
                    'parent_id' => 119,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'لوفر',
                    'department_id' => 4,
                    'parent_id' => 119,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أبوات',
                    'department_id' => 4,
                    'parent_id' => 119,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شباشب',
                    'department_id' => 4,
                    'parent_id' => 119,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الشنط والاكسسوارات',
                    'department_id' => 4,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الإضاءة',
                    'department_id' => 4,
                    'parent_id' => 125,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'عطور للبيت',
                    'department_id' => 4,
                    'parent_id' => 125,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الأبسطة والسجادات',
                    'department_id' => 4,
                    'parent_id' => 125,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أغطية الأثاث',
                    'department_id' => 4,
                    'parent_id' => 125,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],

            // 5. المنزل (department_id: 6)
                [
                    'name' => 'منظفات المنزل',
                    'department_id' => 6,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أدوات منزلية',
                    'department_id' => 6,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المطبخ والسفرة',
                    'department_id' => 6,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أواني الطبخ',
                    'department_id' => 6,
                    'parent_id' => 130,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التخزين والتنظيم',
                    'department_id' => 6,
                    'parent_id' => 130,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أواني السفرة والتقديم',
                    'department_id' => 6,
                    'parent_id' => 130,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'اكسسوارات',
                    'department_id' => 6,
                    'parent_id' => 130,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أدوات المائدة',
                    'department_id' => 6,
                    'parent_id' => 130,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'القهوة والشاي',
                    'department_id' => 6,
                    'parent_id' => 130,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أواني الخبز',
                    'department_id' => 6,
                    'parent_id' => 130,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أواني الشرب',
                    'department_id' => 6,
                    'parent_id' => 130,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الأثاث',
                    'department_id' => 6,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الكنب',
                    'department_id' => 6,
                    'parent_id' => 139,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'طاولات القهوة',
                    'department_id' => 6,
                    'parent_id' => 139,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كراسي اللعب',
                    'department_id' => 6,
                    'parent_id' => 139,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بين باج',
                    'department_id' => 6,
                    'parent_id' => 139,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المكاتب وكراسي المكتب',
                    'department_id' => 6,
                    'parent_id' => 139,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'وحدات التلفزيونات',
                    'department_id' => 6,
                    'parent_id' => 139,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الخزائن والتخزين',
                    'department_id' => 6,
                    'parent_id' => 139,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الكراسي',
                    'department_id' => 6,
                    'parent_id' => 139,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أدوات تحسين البيت',
                    'department_id' => 6,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أدوات كهربائية',
                    'department_id' => 6,
                    'parent_id' => 148,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أدوات يدوية',
                    'department_id' => 6,
                    'parent_id' => 148,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مستلزمات التنظيف',
                    'department_id' => 6,
                    'parent_id' => 148,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تنظيم البيت',
                    'department_id' => 6,
                    'parent_id' => 148,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العناية بالغسيل',
                    'department_id' => 6,
                    'parent_id' => 148,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'السلامة والحماية',
                    'department_id' => 6,
                    'parent_id' => 148,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التمديدات الكهربائية والإضاءات',
                    'department_id' => 6,
                    'parent_id' => 148,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مستلزمات الجدار والدهان',
                    'department_id' => 6,
                    'parent_id' => 148,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ديكور البيت',
                    'department_id' => 6,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الإضاءة',
                    'department_id' => 6,
                    'parent_id' => 157,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'عطور للبيت',
                    'department_id' => 6,
                    'parent_id' => 157,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الأبسطة والسجادات',
                    'department_id' => 6,
                    'parent_id' => 157,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أغطية الأثاث',
                    'department_id' => 6,
                    'parent_id' => 157,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المرايات',
                    'department_id' => 6,
                    'parent_id' => 157,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العناية بالنوافذ',
                    'department_id' => 6,
                    'parent_id' => 157,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مخدات ديكور',
                    'department_id' => 6,
                    'parent_id' => 157,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ديكورات منزلية',
                    'department_id' => 6,
                    'parent_id' => 157,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الاستحمام والمفارش',
                    'department_id' => 6,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الشراشف وأغطية المخدات',
                    'department_id' => 6,
                    'parent_id' => 166,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'رؤوس الدش',
                    'department_id' => 6,
                    'parent_id' => 166,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أطقم الألحفة',
                    'department_id' => 6,
                    'parent_id' => 166,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أغطية ألحفة مبطنة',
                    'department_id' => 6,
                    'parent_id' => 166,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مناشف',
                    'department_id' => 6,
                    'parent_id' => 166,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مخدات',
                    'department_id' => 6,
                    'parent_id' => 166,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أرواب الاستحمام',
                    'department_id' => 6,
                    'parent_id' => 166,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'منظمات الحمام',
                    'department_id' => 6,
                    'parent_id' => 166,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة البيت',
                    'department_id' => 6,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'قلايات هوائية',
                    'department_id' => 6,
                    'parent_id' => 175,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'آلات قهوة',
                    'department_id' => 6,
                    'parent_id' => 175,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أفران وحماصات',
                    'department_id' => 6,
                    'parent_id' => 175,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كوايات بخار',
                    'department_id' => 6,
                    'parent_id' => 175,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'خلاطات',
                    'department_id' => 6,
                    'parent_id' => 175,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مكانس كهربائية',
                    'department_id' => 6,
                    'parent_id' => 175,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'غلايات كهربائية',
                    'department_id' => 6,
                    'parent_id' => 175,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة كبيرة',
                    'department_id' => 6,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ثلاجات',
                    'department_id' => 6,
                    'parent_id' => 183,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'غسالات',
                    'department_id' => 6,
                    'parent_id' => 183,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مكييفات',
                    'department_id' => 6,
                    'parent_id' => 183,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أفران غاز',
                    'department_id' => 6,
                    'parent_id' => 183,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'غسالات صحون',
                    'department_id' => 6,
                    'parent_id' => 183,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'موزعات مياه',
                    'department_id' => 6,
                    'parent_id' => 183,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مجففات',
                    'department_id' => 6,
                    'parent_id' => 183,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'فريزرات',
                    'department_id' => 6,
                    'parent_id' => 183,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            
            // 6. الجمال والعطور (department_id: 5)
                [
                    'name' => 'منظفات شخصية',
                    'department_id' => 5,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تجميل وعناية شخصية',
                    'department_id' => 5,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مكياج',
                    'department_id' => 5,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مسكارا',
                    'department_id' => 5,
                    'parent_id' => 192,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كريمات الأساس',
                    'department_id' => 5,
                    'parent_id' => 192,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'البلاشر والبرونزر',
                    'department_id' => 5,
                    'parent_id' => 192,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'باليتات ظلال العيون',
                    'department_id' => 5,
                    'parent_id' => 192,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ملمات الشفاه',
                    'department_id' => 5,
                    'parent_id' => 192,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'فرش المكياج',
                    'department_id' => 5,
                    'parent_id' => 192,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شنط ومنظمات المكياج',
                    'department_id' => 5,
                    'parent_id' => 192,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العناية بالبشرة',
                    'department_id' => 5,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مرطبات',
                    'department_id' => 5,
                    'parent_id' => 200,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'واقيات الشمس',
                    'department_id' => 5,
                    'parent_id' => 200,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'غسولات',
                    'department_id' => 5,
                    'parent_id' => 200,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الاستحمام والجسم',
                    'department_id' => 5,
                    'parent_id' => 200,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'معالجات وسيرومات',
                    'department_id' => 5,
                    'parent_id' => 200,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تونر',
                    'department_id' => 5,
                    'parent_id' => 200,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أطقم الهدايا',
                    'department_id' => 5,
                    'parent_id' => 200,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العناية بالشعر',
                    'department_id' => 5,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شامبو',
                    'department_id' => 5,
                    'parent_id' => 208,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بلسم',
                    'department_id' => 5,
                    'parent_id' => 208,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ماسكات الشعر',
                    'department_id' => 5,
                    'parent_id' => 208,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'زيوت وسيرمات الشعر',
                    'department_id' => 5,
                    'parent_id' => 208,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'صبغات الشعر',
                    'department_id' => 5,
                    'parent_id' => 208,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'منتجات تساقط الشعر',
                    'department_id' => 5,
                    'parent_id' => 208,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مجموعة بروفيشنال',
                    'department_id' => 5,
                    'parent_id' => 208,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العناية الشخصية',
                    'department_id' => 5,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الاستحمام والجسم',
                    'department_id' => 5,
                    'parent_id' => 216,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'عناية فموية',
                    'department_id' => 5,
                    'parent_id' => 216,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مزيلات التعرق',
                    'department_id' => 5,
                    'parent_id' => 216,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'عناية أنثوية',
                    'department_id' => 5,
                    'parent_id' => 216,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مرطبات',
                    'department_id' => 5,
                    'parent_id' => 216,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'غسولات الوجه',
                    'department_id' => 5,
                    'parent_id' => 216,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العناية بالشفاه',
                    'department_id' => 5,
                    'parent_id' => 216,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'عطور',
                    'department_id' => 5,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'عطور نسائية',
                    'department_id' => 5,
                    'parent_id' => 224,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'عطور رجالية',
                    'department_id' => 5,
                    'parent_id' => 224,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'عطور عربية',
                    'department_id' => 5,
                    'parent_id' => 224,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أطقم الهدايا',
                    'department_id' => 5,
                    'parent_id' => 224,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'عطور فخمة',
                    'department_id' => 5,
                    'parent_id' => 224,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'عطور وبخاخات الجسم',
                    'department_id' => 5,
                    'parent_id' => 224,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الأفضل مبيعًا',
                    'department_id' => 5,
                    'parent_id' => 224,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'حلاقة رجالية',
                    'department_id' => 5,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شفرات',
                    'department_id' => 5,
                    'parent_id' => 232,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كريمات وجل الحلاقة',
                    'department_id' => 5,
                    'parent_id' => 232,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شامبو وجل الاستحمام',
                    'department_id' => 5,
                    'parent_id' => 232,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'غسولات وبلسم ما بعد الحلاقة',
                    'department_id' => 5,
                    'parent_id' => 232,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العناية باللحية',
                    'department_id' => 5,
                    'parent_id' => 232,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تصفيف الشعر',
                    'department_id' => 5,
                    'parent_id' => 232,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أدوات تصفيف الشعر',
                    'department_id' => 5,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مجففات الشعر',
                    'department_id' => 5,
                    'parent_id' => 239,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة تمليس الشعر',
                    'department_id' => 5,
                    'parent_id' => 239,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة تجعيد الشعر',
                    'department_id' => 5,
                    'parent_id' => 239,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'رولر للشعر',
                    'department_id' => 5,
                    'parent_id' => 239,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ليزر وIPL',
                    'department_id' => 5,
                    'parent_id' => 239,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة إزالة الشعر',
                    'department_id' => 5,
                    'parent_id' => 239,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],

            // 7. البيبي (department_id: 9)
                [
                    'name' => 'مستلزمات أطفال',
                    'department_id' => 9,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أساسيات البيبي',
                    'department_id' => 9,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الأفضل مبيعًا',
                    'department_id' => 9,
                    'parent_id' => 246,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'متجر الهدايا',
                    'department_id' => 9,
                    'parent_id' => 246,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'متجر المنتجات الفخمة',
                    'department_id' => 9,
                    'parent_id' => 246,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تصفيات',
                    'department_id' => 9,
                    'parent_id' => 246,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'آخر شي وصل',
                    'department_id' => 9,
                    'parent_id' => 246,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'دليل شراء كرسي سيارة',
                    'department_id' => 9,
                    'parent_id' => 246,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'دليل شراء عربة',
                    'department_id' => 9,
                    'parent_id' => 246,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تجهيزات شنطة المستشفى',
                    'department_id' => 9,
                    'parent_id' => 246,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أساسيات الإطعام',
                    'department_id' => 9,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مضخات الثدي',
                    'department_id' => 9,
                    'parent_id' => 255,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الرضاعات',
                    'department_id' => 9,
                    'parent_id' => 255,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'اللهايات والعضاضات',
                    'department_id' => 9,
                    'parent_id' => 255,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'محضرات الطعام',
                    'department_id' => 9,
                    'parent_id' => 255,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الكراسي المرتفعة والدعامات',
                    'department_id' => 9,
                    'parent_id' => 255,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شنط الأكل',
                    'department_id' => 9,
                    'parent_id' => 255,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة التعقيم والتسخين',
                    'department_id' => 9,
                    'parent_id' => 255,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مرايل وأقمشة التجشؤ',
                    'department_id' => 9,
                    'parent_id' => 255,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العناية بالبيبي',
                    'department_id' => 9,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الحفاضات',
                    'department_id' => 9,
                    'parent_id' => 264,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المناديل المبللة',
                    'department_id' => 9,
                    'parent_id' => 264,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الاستحمام والعناية بالبشرة',
                    'department_id' => 9,
                    'parent_id' => 264,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أطعمة البيبي',
                    'department_id' => 9,
                    'parent_id' => 264,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التصفيف والعناية بالصحة',
                    'department_id' => 9,
                    'parent_id' => 264,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كراسي التدريب على الحمام',
                    'department_id' => 9,
                    'parent_id' => 264,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أحواض وكراسي الاستحمام',
                    'department_id' => 9,
                    'parent_id' => 264,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أساسيات الحضانة',
                    'department_id' => 9,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المشايات والهزازات',
                    'department_id' => 9,
                    'parent_id' => 272,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مهاد البيبي',
                    'department_id' => 9,
                    'parent_id' => 272,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'البطانيات والقماط',
                    'department_id' => 9,
                    'parent_id' => 272,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مفارش البيبي',
                    'department_id' => 9,
                    'parent_id' => 272,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'حماية البيبي',
                    'department_id' => 9,
                    'parent_id' => 272,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ديكور الحضانة',
                    'department_id' => 9,
                    'parent_id' => 272,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أسرة نوم محمولة',
                    'department_id' => 9,
                    'parent_id' => 272,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'روضة أطفال',
                    'department_id' => 9,
                    'parent_id' => 272,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'معدات سفر البيبي',
                    'department_id' => 9,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العربات',
                    'department_id' => 9,
                    'parent_id' => 281,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كراسي السيارة',
                    'department_id' => 9,
                    'parent_id' => 281,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أنظمة السفر',
                    'department_id' => 9,
                    'parent_id' => 281,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'حمّالات الأطفال',
                    'department_id' => 9,
                    'parent_id' => 281,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'عربات للتوأم',
                    'department_id' => 9,
                    'parent_id' => 281,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شنط ومنظمات الحفاضات',
                    'department_id' => 9,
                    'parent_id' => 281,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'اكسسوارات العربة',
                    'department_id' => 9,
                    'parent_id' => 281,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'اكسسوارات كرسي السيارة',
                    'department_id' => 9,
                    'parent_id' => 281,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            
            // 8. الألعاب (department_id: 11)
                [
                    'name' => 'ألعاب أطفال',
                    'department_id' => 11,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الألعاب',
                    'department_id' => 11,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الأفضل مبيعًا',
                    'department_id' => 11,
                    'parent_id' => 290,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'متجر الهدايا',
                    'department_id' => 11,
                    'parent_id' => 290,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تصفيات',
                    'department_id' => 11,
                    'parent_id' => 290,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'آخر شي وصل',
                    'department_id' => 11,
                    'parent_id' => 290,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ألعاب للبنات',
                    'department_id' => 11,
                    'parent_id' => 290,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ألعاب للأولاد',
                    'department_id' => 11,
                    'parent_id' => 290,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مستلزمات الحفلات',
                    'department_id' => 11,
                    'parent_id' => 290,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الألعاب الخارجية',
                    'department_id' => 11,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مسدسات اللعب',
                    'department_id' => 11,
                    'parent_id' => 298,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الترامبولين والألعاب النطاطة',
                    'department_id' => 11,
                    'parent_id' => 298,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أحواض السباحة والألعاب المائية',
                    'department_id' => 11,
                    'parent_id' => 298,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'سكوترات الأطفال',
                    'department_id' => 11,
                    'parent_id' => 298,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ألعاب التحكم عن بعد',
                    'department_id' => 11,
                    'parent_id' => 298,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ألعاب الدراجات',
                    'department_id' => 11,
                    'parent_id' => 298,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'دراجات الأطفال',
                    'department_id' => 11,
                    'parent_id' => 298,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'معدات ساحات اللعب',
                    'department_id' => 11,
                    'parent_id' => 298,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الألعاب الداخلية',
                    'department_id' => 11,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'البزل',
                    'department_id' => 11,
                    'parent_id' => 307,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'البطاقات والألعاب اللوحية',
                    'department_id' => 11,
                    'parent_id' => 307,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الألعاب التعليمية',
                    'department_id' => 11,
                    'parent_id' => 307,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الفنون والحرف',
                    'department_id' => 11,
                    'parent_id' => 307,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ألعاب البناء',
                    'department_id' => 11,
                    'parent_id' => 307,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ألعاب الخيم',
                    'department_id' => 11,
                    'parent_id' => 307,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المركبات المجسمة',
                    'department_id' => 11,
                    'parent_id' => 307,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ألعاب عصرية',
                    'department_id' => 11,
                    'parent_id' => 307,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ألعاب الأطفال الصغار والرضع',
                    'department_id' => 11,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ألعاب الاستحمام',
                    'department_id' => 11,
                    'parent_id' => 316,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أبسطة اللعب',
                    'department_id' => 11,
                    'parent_id' => 316,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مراكز اللعب',
                    'department_id' => 11,
                    'parent_id' => 316,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'حيوانات محشوة',
                    'department_id' => 11,
                    'parent_id' => 316,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'لهايات',
                    'department_id' => 11,
                    'parent_id' => 316,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ألعاب فرز الأشكال',
                    'department_id' => 11,
                    'parent_id' => 316,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ألعاب موسيقية',
                    'department_id' => 11,
                    'parent_id' => 316,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ألعاب السحب والدفع',
                    'department_id' => 11,
                    'parent_id' => 316,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'اللعب التظاهري',
                    'department_id' => 11,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الأزياء التنكرية',
                    'department_id' => 11,
                    'parent_id' => 325,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الأقنعة',
                    'department_id' => 11,
                    'parent_id' => 325,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أطقم ألعاب المطبخ',
                    'department_id' => 11,
                    'parent_id' => 325,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أطقم ألعاب الجمال',
                    'department_id' => 11,
                    'parent_id' => 325,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أطقم ألعاب الطبيب',
                    'department_id' => 11,
                    'parent_id' => 325,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المجسمات',
                    'department_id' => 11,
                    'parent_id' => 325,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الدمى والاكسسوارات',
                    'department_id' => 11,
                    'parent_id' => 325,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'اكسسوارات الأزياء التنكرية',
                    'department_id' => 11,
                    'parent_id' => 325,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],

            // 9. الرياضة (department_id: 10)
                [
                    'name' => 'الرياضة والتمارين',
                    'department_id' => 10,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'اكسسوارات',
                    'department_id' => 10,
                    'parent_id' => 334,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الركض والتمرين',
                    'department_id' => 10,
                    'parent_id' => 334,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تمارين اللياقة والقوة',
                    'department_id' => 10,
                    'parent_id' => 334,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'آلات التمرين',
                    'department_id' => 10,
                    'parent_id' => 334,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'آلات الكارديو',
                    'department_id' => 10,
                    'parent_id' => 334,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'يوغا',
                    'department_id' => 10,
                    'parent_id' => 334,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الترامبولين والاكسسوارات',
                    'department_id' => 10,
                    'parent_id' => 334,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'رياضات جماعية',
                    'department_id' => 10,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كرة القدم',
                    'department_id' => 10,
                    'parent_id' => 342,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كرة السلة',
                    'department_id' => 10,
                    'parent_id' => 342,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كريكت',
                    'department_id' => 10,
                    'parent_id' => 342,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بيسبول',
                    'department_id' => 10,
                    'parent_id' => 342,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الكرة الطائرة',
                    'department_id' => 10,
                    'parent_id' => 342,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كرة اليد',
                    'department_id' => 10,
                    'parent_id' => 342,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'هوكي الحقل',
                    'department_id' => 10,
                    'parent_id' => 342,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الرجبي',
                    'department_id' => 10,
                    'parent_id' => 342,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ركوب القوارب والرياضات المائية',
                    'department_id' => 10,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'السباحة',
                    'department_id' => 10,
                    'parent_id' => 351,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الغوص والغطس',
                    'department_id' => 10,
                    'parent_id' => 351,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ركوب القوارب',
                    'department_id' => 10,
                    'parent_id' => 351,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ركوب الأمواج',
                    'department_id' => 10,
                    'parent_id' => 351,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ركوب الكياك',
                    'department_id' => 10,
                    'parent_id' => 351,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كرة الماء',
                    'department_id' => 10,
                    'parent_id' => 351,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ركوب القوارب الشراعية',
                    'department_id' => 10,
                    'parent_id' => 351,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التزلج الشراعي',
                    'department_id' => 10,
                    'parent_id' => 351,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'رياضات المضرب',
                    'department_id' => 10,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الريشة الطائرة',
                    'department_id' => 10,
                    'parent_id' => 360,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التنس',
                    'department_id' => 10,
                    'parent_id' => 360,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تنس الطاولة',
                    'department_id' => 10,
                    'parent_id' => 360,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'البادل',
                    'department_id' => 10,
                    'parent_id' => 360,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'سكواش',
                    'department_id' => 10,
                    'parent_id' => 360,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ركوب الدراجة',
                    'department_id' => 10,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'اكسسوارات',
                    'department_id' => 10,
                    'parent_id' => 366,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'معدات الحماية',
                    'department_id' => 10,
                    'parent_id' => 366,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الدراجات الهوائية',
                    'department_id' => 10,
                    'parent_id' => 366,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'قطع الدراجات',
                    'department_id' => 10,
                    'parent_id' => 366,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'خوزات الدراجات',
                    'department_id' => 10,
                    'parent_id' => 366,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أدوات الدراجات وصيانتها',
                    'department_id' => 10,
                    'parent_id' => 366,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'خوزات الدراجات وشنط التخزين',
                    'department_id' => 10,
                    'parent_id' => 366,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التخييم والهايكنج',
                    'department_id' => 10,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مطبخ المخيم',
                    'department_id' => 10,
                    'parent_id' => 374,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الخيام',
                    'department_id' => 10,
                    'parent_id' => 374,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الشنط وشنط الظهر',
                    'department_id' => 10,
                    'parent_id' => 374,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أكياس النوم',
                    'department_id' => 10,
                    'parent_id' => 374,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'معدات الحماية',
                    'department_id' => 10,
                    'parent_id' => 374,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الإضاءات والفوانيس',
                    'department_id' => 10,
                    'parent_id' => 374,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ألواح التزلج والسكوترات',
                    'department_id' => 10,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'سكوترات',
                    'department_id' => 10,
                    'parent_id' => 381,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'قطع السكوترات',
                    'department_id' => 10,
                    'parent_id' => 381,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المزلجات وألواح التزلج',
                    'department_id' => 10,
                    'parent_id' => 381,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ألوح تزلّج',
                    'department_id' => 10,
                    'parent_id' => 381,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            
            // 10. الصحة والتغذية (department_id: 8)
                [
                    'name' => 'فيتامينات ومكملات',
                    'department_id' => 8,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'فيتامينات',
                    'department_id' => 8,
                    'parent_id' => 386,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مكملات هضمية',
                    'department_id' => 8,
                    'parent_id' => 386,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الصحة النسائية',
                    'department_id' => 8,
                    'parent_id' => 386,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'صحة الرجال',
                    'department_id' => 8,
                    'parent_id' => 386,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كولاجين',
                    'department_id' => 8,
                    'parent_id' => 386,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'معززات المناعة',
                    'department_id' => 8,
                    'parent_id' => 386,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شاي نباتي',
                    'department_id' => 8,
                    'parent_id' => 386,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'معدات طبية',
                    'department_id' => 8,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة مراقبة الصحة',
                    'department_id' => 8,
                    'parent_id' => 394,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الحمالات والدعامات والجبائر',
                    'department_id' => 8,
                    'parent_id' => 394,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العناية بالسكري',
                    'department_id' => 8,
                    'parent_id' => 394,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة الاستنشاق',
                    'department_id' => 8,
                    'parent_id' => 394,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'لوازم طبية احترافية',
                    'department_id' => 8,
                    'parent_id' => 394,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مستلزمات المعيشة اليومية',
                    'department_id' => 8,
                    'parent_id' => 394,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العناية بالصحة',
                    'department_id' => 8,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الاسعافات الأولية',
                    'department_id' => 8,
                    'parent_id' => 401,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مزيلات الألم',
                    'department_id' => 8,
                    'parent_id' => 401,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الحساسة والربو',
                    'department_id' => 8,
                    'parent_id' => 401,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الهضم والغثيان',
                    'department_id' => 8,
                    'parent_id' => 401,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العناية بالأرجل',
                    'department_id' => 8,
                    'parent_id' => 401,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'حفاضات البالغين وسلس البول',
                    'department_id' => 8,
                    'parent_id' => 401,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الإقلاع عن التدخين',
                    'department_id' => 8,
                    'parent_id' => 401,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'السعال والبرد والانفلونزا',
                    'department_id' => 8,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أدوية السعال والبرد',
                    'department_id' => 8,
                    'parent_id' => 409,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بخاخ ونقط للأنف',
                    'department_id' => 8,
                    'parent_id' => 409,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أقراص السعال والبرد',
                    'department_id' => 8,
                    'parent_id' => 409,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بخاخات الحلق',
                    'department_id' => 8,
                    'parent_id' => 409,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أعواد الاستنشاق والزيوت',
                    'department_id' => 8,
                    'parent_id' => 409,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'قراص استحلاب التهاب الحلق',
                    'department_id' => 8,
                    'parent_id' => 409,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المساج والاسترخاء',
                    'department_id' => 8,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مسدسات المساج',
                    'department_id' => 8,
                    'parent_id' => 416,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'زيوت المساج',
                    'department_id' => 8,
                    'parent_id' => 416,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'رولر المساج',
                    'department_id' => 8,
                    'parent_id' => 416,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كراسي المساج',
                    'department_id' => 8,
                    'parent_id' => 416,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كرات المساج',
                    'department_id' => 8,
                    'parent_id' => 416,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كريمات المساج',
                    'department_id' => 8,
                    'parent_id' => 416,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أحجار المساج',
                    'department_id' => 8,
                    'parent_id' => 416,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التغذية',
                    'department_id' => 8,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'منظمات الوزن',
                    'department_id' => 8,
                    'parent_id' => 424,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مشروبات غذائية',
                    'department_id' => 8,
                    'parent_id' => 424,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المنظفات ومزيلات الروائح الكريهة',
                    'department_id' => 8,
                    'parent_id' => 424,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'عسل مانوكا',
                    'department_id' => 8,
                    'parent_id' => 424,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مزيج الأطعمة',
                    'department_id' => 8,
                    'parent_id' => 424,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التغذية الرياضية',
                    'department_id' => 8,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'البروتين',
                    'department_id' => 8,
                    'parent_id' => 430,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الكرياتين',
                    'department_id' => 8,
                    'parent_id' => 430,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الإلكترولايت',
                    'department_id' => 8,
                    'parent_id' => 430,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'محفزات الطاقة قبل التمرين',
                    'department_id' => 8,
                    'parent_id' => 430,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الأحماض الأمينية',
                    'department_id' => 8,
                    'parent_id' => 430,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'السناكات والمشروبات الصحية',
                    'department_id' => 8,
                    'parent_id' => 430,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            
            // 11. البقالة (department_id: 7)
                [
                    'name' => 'ورقيات ومحارم',
                    'department_id' => 7,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مواد غذائية',
                    'department_id' => 7,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'معلبات',
                    'department_id' => 7,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'سناكات وتسلية',
                    'department_id' => 7,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'حبوب وبقوليات',
                    'department_id' => 7,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مستلزمات العناية بالبيت',
                    'department_id' => 7,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'منظفات البيت',
                    'department_id' => 7,
                    'parent_id' => 437,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العناية بالغسيل',
                    'department_id' => 7,
                    'parent_id' => 437,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'منقيات الهواء',
                    'department_id' => 7,
                    'parent_id' => 437,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الورق والبلاستيك واللفافات',
                    'department_id' => 7,
                    'parent_id' => 437,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مشروبات',
                    'department_id' => 7,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شاي',
                    'department_id' => 7,
                    'parent_id' => 442,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'قهوة',
                    'department_id' => 7,
                    'parent_id' => 442,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مشروبات غازية',
                    'department_id' => 7,
                    'parent_id' => 442,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مشروبات طاقة',
                    'department_id' => 7,
                    'parent_id' => 442,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'عصائر',
                    'department_id' => 7,
                    'parent_id' => 442,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مياه',
                    'department_id' => 7,
                    'parent_id' => 442,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'خلطات مشروبات صحية',
                    'department_id' => 7,
                    'parent_id' => 442,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الأغذية المعلبة والمعبأة',
                    'department_id' => 7,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'صلصات المرق والمخللات',
                    'department_id' => 7,
                    'parent_id' => 450,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المعكرونة والنودلز',
                    'department_id' => 7,
                    'parent_id' => 450,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المخلل والزيتون',
                    'department_id' => 7,
                    'parent_id' => 450,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الخضراوات المعلبة',
                    'department_id' => 7,
                    'parent_id' => 450,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التونة',
                    'department_id' => 7,
                    'parent_id' => 450,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'لحمة',
                    'department_id' => 7,
                    'parent_id' => 450,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الشوربات',
                    'department_id' => 7,
                    'parent_id' => 450,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'وجبات جاهزة للتسخين',
                    'department_id' => 7,
                    'parent_id' => 450,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الأعشاب والتوابل',
                    'department_id' => 7,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بدائل الملح',
                    'department_id' => 7,
                    'parent_id' => 459,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الأعشاب والبهارات',
                    'department_id' => 7,
                    'parent_id' => 459,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التوابل المطحونة',
                    'department_id' => 7,
                    'parent_id' => 459,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'حبوب وتوبل كاملة',
                    'department_id' => 7,
                    'parent_id' => 459,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'توابل مخلوطة',
                    'department_id' => 7,
                    'parent_id' => 459,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'فلفل',
                    'department_id' => 7,
                    'parent_id' => 459,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'لوازم الطبخ والخبز',
                    'department_id' => 7,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الدقيق',
                    'department_id' => 7,
                    'parent_id' => 466,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شراب السكريات والمحليات',
                    'department_id' => 7,
                    'parent_id' => 466,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'خميرة خلط الخبز',
                    'department_id' => 7,
                    'parent_id' => 466,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'حليب مكثف وبودرة',
                    'department_id' => 7,
                    'parent_id' => 466,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'خلطات الحلوى',
                    'department_id' => 7,
                    'parent_id' => 466,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'خلطات البودنج والجيلاتين',
                    'department_id' => 7,
                    'parent_id' => 466,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'لوازم الزينة',
                    'department_id' => 7,
                    'parent_id' => 466,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'سناكات',
                    'department_id' => 7,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'رقائق البطاطس',
                    'department_id' => 7,
                    'parent_id' => 474,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المكسرات والبذور',
                    'department_id' => 7,
                    'parent_id' => 474,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'فواكه مجففة',
                    'department_id' => 7,
                    'parent_id' => 474,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الفشار',
                    'department_id' => 7,
                    'parent_id' => 474,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ويفر',
                    'department_id' => 7,
                    'parent_id' => 474,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بسكويت',
                    'department_id' => 7,
                    'parent_id' => 474,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تمور',
                    'department_id' => 7,
                    'parent_id' => 474,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الصلصات والمغموسات والأطعمة القابلة للفرد',
                    'department_id' => 7,
                    'parent_id' => 474,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'طعام الإفطار',
                    'department_id' => 7,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المربى والطعام القابل للدهن',
                    'department_id' => 7,
                    'parent_id' => 483,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'حبوب ومنتجات الأفطار',
                    'department_id' => 7,
                    'parent_id' => 483,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الشوفان',
                    'department_id' => 7,
                    'parent_id' => 483,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الحبوب الباردة',
                    'department_id' => 7,
                    'parent_id' => 483,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'حبوب إفطار للأطفال',
                    'department_id' => 7,
                    'parent_id' => 483,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الرقائق',
                    'department_id' => 7,
                    'parent_id' => 483,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الغرانولا',
                    'department_id' => 7,
                    'parent_id' => 483,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'وجبات الإفطار الخفيفة',
                    'department_id' => 7,
                    'parent_id' => 483,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            
            // 12. السيارات (department_id: 13)
                [
                    'name' => 'اكسسوارات داخلية',
                    'department_id' => 13,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة لعب ومنظمات',
                    'department_id' => 13,
                    'parent_id' => 492,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شواحن السيارات',
                    'department_id' => 13,
                    'parent_id' => 492,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أغطية المقاعد والاكسسوارات',
                    'department_id' => 13,
                    'parent_id' => 492,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'منقيات الجو',
                    'department_id' => 13,
                    'parent_id' => 492,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'عجلات القيادة والاكسسوارات',
                    'department_id' => 13,
                    'parent_id' => 492,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'دواسات الأرضيات وبطانات التحميل',
                    'department_id' => 13,
                    'parent_id' => 492,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'اكسسوارات خارجية',
                    'department_id' => 13,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الشارات وملصقات ممتصات الصدمات',
                    'department_id' => 13,
                    'parent_id' => 499,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المصابيح واكسسوارات الإضاءة',
                    'department_id' => 13,
                    'parent_id' => 499,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'منتجات السحب',
                    'department_id' => 13,
                    'parent_id' => 499,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أغطية السيارة بالكامل',
                    'department_id' => 13,
                    'parent_id' => 499,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'السلامة',
                    'department_id' => 13,
                    'parent_id' => 499,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العناية بالسيارات',
                    'department_id' => 13,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المعدات والأدوات',
                    'department_id' => 13,
                    'parent_id' => 505,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العناية الخارجية',
                    'department_id' => 13,
                    'parent_id' => 505,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'العناية الداخلية',
                    'department_id' => 13,
                    'parent_id' => 505,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'طلاءات',
                    'department_id' => 13,
                    'parent_id' => 505,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'بطارية تشغيل السيارة',
                    'department_id' => 13,
                    'parent_id' => 505,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'منافخ الإطارات',
                    'department_id' => 13,
                    'parent_id' => 505,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'إلكترونيات السيارات',
                    'department_id' => 13,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة الفيديو للسيارات',
                    'department_id' => 13,
                    'parent_id' => 512,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'صوتيات للسيارات',
                    'department_id' => 13,
                    'parent_id' => 512,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كاميرات داش',
                    'department_id' => 13,
                    'parent_id' => 512,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أجهزة تحديد المواقع للسيارات',
                    'department_id' => 13,
                    'parent_id' => 512,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],

            // 13. القرطاسية (department_id: 15)
                [
                    'name' => 'أدوات مدرسية',
                    'department_id' => 15,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الأوراق',
                    'department_id' => 15,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'دفاتر الملاحظات',
                    'department_id' => 15,
                    'parent_id' => 517,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مجموعات البطاقات',
                    'department_id' => 15,
                    'parent_id' => 517,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ملاحظات لاصقة',
                    'department_id' => 15,
                    'parent_id' => 517,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ورق نسخ ومتعدد الأغراض',
                    'department_id' => 15,
                    'parent_id' => 517,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'ورق الصور',
                    'department_id' => 15,
                    'parent_id' => 517,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التقاويم والمنظمات',
                    'department_id' => 15,
                    'parent_id' => 517,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التعليم والحرف اليدوية',
                    'department_id' => 15,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'لوازم الفنون والحرف',
                    'department_id' => 15,
                    'parent_id' => 524,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مستلزمات الخياطة',
                    'department_id' => 15,
                    'parent_id' => 524,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المواد اللاصقة',
                    'department_id' => 15,
                    'parent_id' => 524,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أدوات الدراسات الاجتماعية',
                    'department_id' => 15,
                    'parent_id' => 524,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'اكسسوارات المكتب',
                    'department_id' => 15,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مقالم',
                    'department_id' => 15,
                    'parent_id' => 529,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'حاملات الأقلام',
                    'department_id' => 15,
                    'parent_id' => 529,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'حوامل وأرفف البطاقات والملفات',
                    'department_id' => 15,
                    'parent_id' => 529,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'لوازم المكتب والحوامل والموزعات',
                    'department_id' => 15,
                    'parent_id' => 529,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مستلزمات الكتابة والتصحيح',
                    'department_id' => 15,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الأقلام والعبوات',
                    'department_id' => 15,
                    'parent_id' => 534,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'اقلام رصاص',
                    'department_id' => 15,
                    'parent_id' => 534,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'قلام الماركر والتظليل',
                    'department_id' => 15,
                    'parent_id' => 534,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'المحايات ومنتجات التصحيح',
                    'department_id' => 15,
                    'parent_id' => 534,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'برايات أقلام الرصاص',
                    'department_id' => 15,
                    'parent_id' => 534,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'مستلزمات الهدايا والتغليف',
                    'department_id' => 15,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أكياس الهدايا',
                    'department_id' => 15,
                    'parent_id' => 540,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'علب الهدايا',
                    'department_id' => 15,
                    'parent_id' => 540,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'أوراق تغليف الهدايا',
                    'department_id' => 15,
                    'parent_id' => 540,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'شرائط تغليف الهدايا',
                    'department_id' => 15,
                    'parent_id' => 540,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            
            // 14. الكتب والميديا (department_id: 14)
                [
                    'name' => 'كتب',
                    'department_id' => 14,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كتب مجازية',
                    'department_id' => 14,
                    'parent_id' => 545,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كتب الأطفال',
                    'department_id' => 14,
                    'parent_id' => 545,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'كتب المراجع',
                    'department_id' => 14,
                    'parent_id' => 545,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الأعمال والتمويل',
                    'department_id' => 14,
                    'parent_id' => 545,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الطعام والشراب',
                    'department_id' => 14,
                    'parent_id' => 545,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الكتب العربية',
                    'department_id' => 14,
                    'parent_id' => 545,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'التعليم',
                    'department_id' => 14,
                    'parent_id' => 545,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'السير الذاتية والقصص الواقعية',
                    'department_id' => 14,
                    'parent_id' => 545,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الفنون',
                    'department_id' => 14,
                    'parent_id' => 545,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'تطوير الذات',
                    'department_id' => 14,
                    'parent_id' => 545,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الموسيقى والوسائط',
                    'department_id' => 14,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الجيتار',
                    'department_id' => 14,
                    'parent_id' => 556,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'البيانو ولوحات المفاتيح الموسيقية',
                    'department_id' => 14,
                    'parent_id' => 556,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الطبول',
                    'department_id' => 14,
                    'parent_id' => 556,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الآلات الوترية',
                    'department_id' => 14,
                    'parent_id' => 556,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'الآلات الهوائيةآلات نفخ',
                    'department_id' => 14,
                    'parent_id' => 556,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            
            // 15. الطعام (department_id: 12)
                [
                    'name' => 'طعام',
                    'department_id' => 12,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],

            // أدوات الصيانة (department_id: 16)
                [
                    'name' => 'أدوات صيانة',
                    'department_id' => 16,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],

            // الكهربائيات (department_id: 17)
                [
                    'name' => 'أدوات كهربائية بسيطة',
                    'department_id' => 17,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],

            // ملابس بسيطة (department_id: 18)
                [
                    'name' => 'ملابس بسيطة',
                    'department_id' => 18,
                    'parent_id' => null,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],

        ];

        DB::table('categories')->insert($categories);
    }
}
