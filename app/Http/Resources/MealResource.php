<?php

namespace App\Http\Resources;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class MealResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->translate($request->lang)->title,
            'content' => $this->translate($request->lang)->content,
            'status' => $this->determineStatus($request->diff_time),
            'category' => new CategoryResources($this->whenLoaded('category')),
            'ingredients' => IngredientResources::collection($this->whenLoaded('ingredients')),
            'tags' => TagResources::collection($this->whenLoaded('tags')),
        ];


    }
    
    protected function determineStatus($diff_time)
    {
        if($this->deleted_at && strtotime($this->updated_at) <= strtotime($this->deleted_at) && $this->deleted_at->timestamp >= (int)$diff_time)
        {
                return'deleted';
        }
        else if(strtotime($this->updated_at) > strtotime($this->created_at) && $this->updated_at->timestamp >= (int)$diff_time)
        {
               return'modified';
        }
        else
        {
                return'created';
        }
    }
}
