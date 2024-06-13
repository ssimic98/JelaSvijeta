<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
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
            'diff_time'=>'sometimes|int|min:1',
            'tags'=>'sometimes|string',
            'ingredients'=>'sometimes|string',
            'with'=>'sometimes|string',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(),422));
    }

    public function messages()
    {
        return 
        [
            'lang.exists'=>'Lang can only be hr or en',
        ];
    }
}
