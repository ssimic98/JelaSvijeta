<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Tag;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker=Faker::create();
        for($index=1;$index<=5;$index++)
        {
            $tag=Tag::create();
            $slug=Str::slug('Tag - '.$tag->id);
            $tag->update(['slug'=>$slug,]);
            foreach(['en','hr'] as $locale)
            {
                $tag->translations()->create([
                        'locale'=>$locale,
                        'title'=>$locale === 'en'?'Title Tag '.$tag->id. ' in En': 'Naslov taga ' .$tag->id. ' na Hr',
                    ]);
            }
            
        }
    }
}
