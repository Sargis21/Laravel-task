<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProducteStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|string|max:50|min:3',
            'description'=>'required|string|max:150|min:5',
            'price'=>'numeric|required|min:1|max:999',
            'photo'=>'required',
        ];
    }
}
