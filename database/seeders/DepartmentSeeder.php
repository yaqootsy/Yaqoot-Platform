<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                
                'name' => 'الإلكترونيات',
                'slug' => 'electronics',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'أزياء النساء',
                'slug' => 'womens-fashion',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'أزياء الرجال',
                'slug' => 'mens-fashion',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'أزياء الأطفال',
                'slug' => 'kids-fashion',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'الجمال والعطور',
                'slug' => 'beauty-and-fragrances',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'المنزل',
                'slug' => 'home',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'البقالة',
                'slug' => 'grocery',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'الصحة والتغذية',
                'slug' => 'health-and-nutrition',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'البيبي',
                'slug' => 'baby',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'الرياضة',
                'slug' => 'sports',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'الألعاب',
                'slug' => 'toys',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'الطعام',
                'slug' => 'food',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'السيارات',
                'slug' => 'cars',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'الكتب والميديا',
                'slug' => 'books-and-media',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'القرطاسية',
                'slug' => 'stationery',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'أدوات الصيانة',
                'slug' => 'maintenance-tools',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'الكهربائيات',
                'slug' => 'electrical',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'ملابس بسيطة',
                'slug' => 'simple-clothing',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('departments')->insert($departments);
    }
}
