<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SmsAvulsoRequest extends FormRequest
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
            'id_organizacao' => 'required',
            'destinatarios' => 'required',
            'numero_equipamento' => 'required',
            'corpo_sms' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'destinatarios.required' => 'O campo telefone e obrigatório.',
            'corpo_sms.required' => 'O campo comando e obrigatório.'
        ];
    }
}
