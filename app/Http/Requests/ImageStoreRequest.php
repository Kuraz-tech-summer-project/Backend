<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageStoreRequest extends FormRequest
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
        if(request()->isMethod('post')) {
            return [

                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            ];
        } else {
            return [

                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            ];
        }
    }
    public function messages()
    {
        if(request()->isMethod('post')) {
            return [
                'image.required' => 'Image is required!',
            ];

        }
        else {
            return [
                'image.required' => 'Image is required!',
            ];
         }
    }
}
