<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCheck extends FormRequest
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
//    public function messages()
//    {
//        return [
//            'address.unique' => 'Shop already exists, Record not saved',
//        ];
//    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:temp_users',
            'password' => 'required|min:6|confirmed',
        ];
    }
}
