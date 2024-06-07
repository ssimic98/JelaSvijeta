<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $languages=[
            ['code'=>'en','name'=>'English'],
            ['code'=>'hr','name'=>'Croatian'],
        ];
        foreach($languages as $language)
        {
            Language::create($language);
        }
    }
}