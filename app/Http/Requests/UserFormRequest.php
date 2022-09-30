<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
        $rules = [];
        $rules['first_name'] = 'required|regex:/^[\pL\s\-]+$/u|max:255';

//        if ($this->method() == 'PUT') {
//            $rules['email'] = 'required|email|max:255|unique:users,email,' . $this->id . ',id';
//        } else {
//            $rules['email'] = 'required|email|max:255|unique:users,email';
//        }
        return $rules;
    }
    public function messages()
    {
        return $messages = [
            'first_name.required' => "First Name field is required.",
        ];
    }
}
