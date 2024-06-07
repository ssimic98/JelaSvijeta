<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
class Ingredient extends Model implements TranslatableContract
{
    use Translatable, HasFactory;
    public $translatedAttributes=['title'];
    protected $fillable=['slug'];
    public function meals()
    {
        return $this->belongsToMany(Meal::class,'meal_ingredients');
    }
}
