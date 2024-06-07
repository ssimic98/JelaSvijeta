<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
class Meal extends Model implements TranslatableContract
{
    use Translatable, SoftDeletes;

    public $translatedAttributes=['title','content'];
    protected $fillable=[];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class,'meal_ingredient');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'meal_tag');
    }

    public function category()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }
}
