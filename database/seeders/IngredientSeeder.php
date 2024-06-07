<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker=Faker::create();
        for($index=1;$index<=5;$index++)
        {
            $ingredient=Ingredient::create();
            $slug=Str::slug('Ingredient - '.$ingredient->id);
            $ingredient->update(['slug'=>$slug,]);
            foreach(['en','hr'] as $locale)
            {
                $ingredient->translations()->create([
                        'locale'=>$locale,
                        'title'=>$locale === 'en'?'Title Ingredient '.$ingredient->id. ' in En': 'Naslov sastojka ' .$ingredient->id. ' na Hr',
                    ]);
            }
            
        }
    }
}
