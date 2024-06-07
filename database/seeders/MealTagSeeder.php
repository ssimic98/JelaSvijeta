<?php

namespace Database\Seeders;

use App\Models\MealTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\Meal;
class MealTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $id_meals=Meal::withTrashed()->pluck('id');
        foreach($id_meals as $mealsID)
        {
            $id_tags=Tag::pluck('id')->unique()->random(3)->all();
            foreach($id_tags as $tagsID)
            {
                MealTag::create(
                    [
                        'meal_id'=>$mealsID,
                        'tag_id'=>$tagsID,
                    ]
                );
            }
        }
        
    }
}
