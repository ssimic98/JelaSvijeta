<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Meal;
use App\Models\Category;
class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        $faker=Faker::create();
        $id_category=Category::pluck('id')->toArray();
        for($index=1;$index<=10;$index++)
        {
            $meal=Meal::create([
                'category_id'=>rand(0,1) ? null : $id_category[array_rand($id_category)],
                'deleted_at'=>rand(0,1)? null:now(),
            ]);

            foreach(['en','hr'] as $locale)
            {
                $meal->translations()->create(
                    [
                        'locale'=>$locale,
                        'title'=>$locale ==='en' ? 'Meal title ' .$meal->id. ' EN' :'Naslov jela '.$meal->id. ' HR',
                        'content'=>$locale ==='en' ? 'Meal content ' .$meal->id. ' EN': 'Opis jela ' .$meal->id. ' HR',
                    ]
                    );
            }
        }
    }
}
