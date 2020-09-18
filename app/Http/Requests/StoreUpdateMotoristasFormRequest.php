<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateMotoristasFormRequest extends FormRequest
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
            'cpf' => [
                'required',
                'cpf',
                Rule::unique('pgsql.motoristas.motoristas')->ignore($this->motorista)
            ],
            'id_organizacao' => 'required',
            'id_entidade' => 'required',
            'nome_completo' => 'required',
            'validade_cnh' => 'date',
            'validade_mopp' => 'date',
            'email_principal' => 'email',
            'id_ibutton' => [
                Rule::unique('pgsql.motoristas.motoristas')->ignore($this->motorista)
            ]
        ];
    }
}
