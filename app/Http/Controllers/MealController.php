<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealRequest;
use App\Http\Resources\MealCollection;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Tag;
use Illuminate\Support\Facades\URL;
use App\Http\Resources\MealResource;

class MealController extends Controller
{
    public function index(MealRequest $mealRequest)
    {
        $query = Meal::query();
        //filtriranje jela prema diff_time
        if ($mealRequest->filled('diff_time')) {
            $timestamp = (int) $mealRequest->diff_time;
            if ($timestamp > 0) {
                $query->withTrashed()->where(function ($meal) use ($timestamp) {
                    $meal->where('created_at', '>=', date('Y-m-d H:i:s', $timestamp))
                        ->orWhere('updated_at', '>=', date('Y-m-d H:i:s', $timestamp))
                        ->orWhere('deleted_at', '>=', date('Y-m-d H:i:s', $timestamp));
                });
            }
        }
        //filtrianje jela prema kategoriji
        if($mealRequest->filled('category'))
        {
            if($mealRequest->category==='NULL')
            {
                $query->whereNull('category_id');
            }
            else if($mealRequest->category !=='NULL')
            {
                $query->whereNotNull('category_id');
            }
            else
            {
                $query->where('category_id',$mealRequest->category);
            }
        }
        //filtriranje jela prema tagovima
        if ($mealRequest->filled('tags')) {
            $tags = explode(',', $mealRequest->tags);
            foreach ($tags as $tag) {
                $query->whereHas('tags', function ($q) use ($tag) {
                    $q->where('tag_id', $tag);
                });
            }
        }
        //filtriranje jela prema sastojcima
        if ($mealRequest->filled('ingredients')) {
            $ingredients = explode(',', $mealRequest->ingredients);
            foreach ($ingredients as $ingredient) {
                $query->whereHas('ingredients', function ($q) use ($ingredient) {
                    $q->where('ingredient_id', $ingredient);
                });
            }
        }

        if ($mealRequest->has('with')) {
            $with = explode(',', $mealRequest->get('with'));
            $query->with($with); 
        }

        $meals = $query->paginate($mealRequest->get('per_page', 15));

        return new MealCollection($meals);
    }
    
}
