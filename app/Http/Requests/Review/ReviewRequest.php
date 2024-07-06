<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'rating' => 'required|integer|max:5|min:1',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'required' => 'Это поле должно быть заполнено',
            'string' => 'Поле должно быть строкой',
            'max' => 'Максимальное кол-во символов: 255',
            'integer' => 'Поле должно быть целочисленным значением',
        ];
    }
}
