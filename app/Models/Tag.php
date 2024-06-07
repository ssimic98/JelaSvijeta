<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
class Tag extends Model implements TranslatableContract
{
    use Translatable;
    public $translatedAttributes=['title'];
    protected $fillable=['slug'];
    public function meals()
    {
        return $this->belongsToMany(Meal::class,'meal_tag');
    }
}
