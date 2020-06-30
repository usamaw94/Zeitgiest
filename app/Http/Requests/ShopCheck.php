<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopCheck extends FormRequest
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

    public function messages()
    {
        return [
            'address.unique' => 'Shop already exists, Record not saved',
        ];
    }

    public function rules()
    {
        return [
            'address' => 'unique:shops,s_address',
        ];
    }
}
