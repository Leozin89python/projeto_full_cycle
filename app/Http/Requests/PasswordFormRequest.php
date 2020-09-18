<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordFormRequest extends FormRequest
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
            'passwrd_atual' => 'required',
            'new_passwrd' => 'required|min:6',
            'confirm_passwrd' => 'required|same:new_passwrd'
        ];
    }

    public function messages()
    {
        return [
            'confirm_passwrd.same' => 'Sua senha e a confirmação devem ser iguais.',
        ];
    }
}
