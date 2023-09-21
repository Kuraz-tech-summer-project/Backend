<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequeset extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'date' => 'required|date_format:Y-m-d',
            'category'=>'required |string'
        ];
    }
    public function messages(){
        return[
        'quantity.required' => 'quantity is required',
            'price' => 'price is required',
            'date' => 'date is required',
            'category'=>'category is required'
        ];
    }
}
