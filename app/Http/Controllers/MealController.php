<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealRequest;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Tag;
use Illuminate\Support\Facades\URL;

class MealController extends Controller
{
    public function index(MealRequest $mealRequest)
    {
        $query=Meal::query();
        if($mealRequest->filled('diff_time') )
        {
            $timestamp=(int)$mealRequest->diff_time;
            if($timestamp>0)
            {
                $query->withTrashed()->where(function($meal)use($timestamp)
                {
                $meal->where('created_at','>=',date('Y-m-d H:i:s', $timestamp))
                    ->orWhere('updated_at','>=',date('Y-m-d H:i:s', $timestamp))
                    ->orWhere('deleted_at','>=',date('Y-m-d H:i:s', $timestamp));
                });
            }
        }

        if($mealRequest->filled('tags'))
        {
            $tags=explode(',',$mealRequest->tags);
            foreach($tags as $tag)
            {
                $query->whereHas('tags',function($q)use($tag)
                {
                    $q->where('tag_id',$tag);
                });
            }
        }
        if($mealRequest->filled('ingredients'))
        {
            $ingredients=explode(',',$mealRequest->ingredients);
            foreach($ingredients as $ingredient)
            {
                $query->whereHas('ingredients',function($q)use($ingredient)
                {
                    $q->where('ingredient_id',$ingredient);
                });
            }
        }
        $meals=$query->paginate($mealRequest->get('per_page',15));
        

        $meals->getCollection()->transform(function($meal)use ($mealRequest)
        {
            $data=[
                'id'=>$meal->id,
                'title'=>$meal->translate($mealRequest->lang)->title,
                'content'=>$meal->translate($mealRequest->lang)->content,
            ];
            if($meal->deleted_at && strtotime($meal->updated_at) <= strtotime($meal->deleted_at) && $meal->deleted_at->timestamp >= (int)$mealRequest->diff_time)
            {
                $data['status']='deleted';
            }
            else if(strtotime($meal->updated_at) > strtotime($meal->created_at) && $meal->updated_at->timestamp >= (int)$mealRequest->diff_time)
            {
                $data['status']='modified';
            }
            else if($meal->created_at->timestamp >= (int)$mealRequest->diff_time)
            {
                $data['status']='created';
            }
            else 
            {
                $data['status']='created';
            }
            if (strpos($mealRequest->with ?? '', 'category') !== false && $meal->category) {
                $data['category'] = $meal->category ?
                    [
                        'id' => $meal->category->id,
                        'title' => $meal->category->translate($mealRequest->lang)->title,
                        'slug' => $meal->category->slug
                    ] : null;
            }
            else
            {
                $data['category']=null;
            }
             if(strpos($mealRequest->with ?? '','tags') !==false && $meal->tags)
             {
                $tags = $meal->tags()->pluck('tags.id');
                foreach($tags as $tagId)
                {
                    $tag = Tag::find($tagId);

                    if($tag)
                     {
                        $data['tags'][] = [
                            'id' => $tag->id,
                            'title' => $tag->translate($mealRequest->lang)->title,
                            'slug' => $tag->slug
                    ];
                    }
                }
             }
             if(strpos($mealRequest->with ?? '','ingredients') !==false && $meal->ingredients)
             {
                $ingredients = $meal->ingredients()->pluck('ingredients.id');
                foreach($ingredients as $ingredientID)
                {
                    $ingredient = Ingredient::find($ingredientID);

                    if($ingredient)
                     {
                        $data['ingredients'][] = [
                            'id' => $ingredient->id,
                            'title' => $ingredient->translate($mealRequest->lang)->title,
                            'slug' => $ingredient->slug
                    ];
                    }
                }
             }
             
            return $data;
        });
        $prevPage=$meals->previousPageUrl();
        $nextPage=$meals->nextPageUrl();
        $meta=
        [
            'prev'=>$prevPage,
            'next'=>$nextPage,
            'self'=>URL::current(),
        ];
        $response=[
            'links'=>$meta,
            'data'=>$meals,
        ];

        return response()->json($response);
    }
    
}
