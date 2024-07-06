<?php

namespace App\Http\Requests\Subscribe;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'email' => 'required|email|max:255|min:3|unique:subscribes,email'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'required' => 'Это поле должно быть заполнено',
            'max' => 'Максимальное кол-во символов: 255',
            'min' => 'Минимальное кол-во символов: 3',
            'unique' => 'Данный email уже подписан на рассылку',
            'array' => 'Поля должно быть массивом',
            'email' => 'Введите корректный email',
        ];
    }
}
