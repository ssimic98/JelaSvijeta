<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientTranslation extends Model
{
    public $timestamps=false;
    protected $fillable=['title','locale'];
    protected $table='ingredients_translations';
}
