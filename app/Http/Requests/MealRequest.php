<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MealRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category'=>'sometimes|nullable|string',
            'lang'=>'required|string|exists:languages,code',
            'per_page'=>'sometimes|int|min:1',
            'diff_time'=>'sometimes|int|min:0',
            'tags'=>'sometimes|string',
            'ingredients'=>'sometimes|string'
        ];
    }
}
