<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TabelaCobrancaFormRequest extends FormRequest
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
            'descricao' => 'required',
            'valor_adesao' => 'required_if:comodato,=,true',
        ];
    }

    public function messages()
    {
        return [
            'valor_adesao.required_if' => 'O campo valor adesão é obrigatório'
        ];
    }
}
