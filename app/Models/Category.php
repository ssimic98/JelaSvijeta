<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use App\Models\Meal;
class Category extends Model implements TranslatableContract
{
    use Translatable, HasFactory;
    public $translatedAttributes=['title'];
    protected $fillable=['slug'];
    protected $table='categories';
    public function meals()
    {
        return $this->belongsTo(Meal::class);
    }
}
