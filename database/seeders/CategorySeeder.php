<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker=Faker::create();
        for($index=1;$index<=5;$index++)
        {
            $category=Category::create();
            $slug=Str::slug('Category - '.$category->id);
            $category->update(['slug'=>$slug,]);
            foreach(['en','hr'] as $locale)
            {
                $category->translation()->create([
                        'locale'=>$locale,
                        'title'=>$locale === 'en'?'Meal Category '.$category->id. ' in En': 'Kategorija jela ' .$category->id. ' na Hr',
                    ]);
            }
            
        }
    }
}
