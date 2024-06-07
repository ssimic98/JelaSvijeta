<?php

namespace Database\Seeders;

use App\Models\MealIngredient;
use App\Models\MealTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use App\Models\Meal;
class MealIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $id_meals=Meal::withTrashed()->pluck('id');
        foreach($id_meals as $mealsID)
        {
            $id_tags=Ingredient::pluck('id')->unique()->random(3)->all();
            foreach($id_tags as $tagsID)
            {
                MealIngredient::create(
                    [
                        'meal_id'=>$mealsID,
                        'ingredient_id'=>$tagsID,
                    ]
                );
            }
        }
        
    }
}
