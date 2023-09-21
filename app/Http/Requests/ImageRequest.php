<?php

namespace App\Http\Requests;
use App\Models\Images;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\ImageController;
class ImageRequest extends FormRequest
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
        return  [
            'images_url' => 'required|url',
        'users_id' => 'required|exists:users,id',
        'product_id' => 'required|exists:product,id',
        ];
    }
    public function messages(){
        return [
            'images_url.required'=>'image_url is required',
            'users.required'=>'userid is required',
            'product.required'=>'product is required',
        ];
    }
}
