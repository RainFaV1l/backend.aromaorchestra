<?php

namespace App\Http\Requests\Order;

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
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'status_id' => 'nullable|integer|exists:statuses,id',
            'delivery_id' => 'required|integer|exists:deliveries,id',
            'address' => 'required|string|max:2000',
            'products' => 'required|array|max:10',
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
          'exists' => 'Поля нет в базе данных',
          'array' => 'Поля должно быть массивом',
          'email' => 'Введите корректный email',
        ];
    }
}
