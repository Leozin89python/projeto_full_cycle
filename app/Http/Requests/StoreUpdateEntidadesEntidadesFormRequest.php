<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateEntidadesEntidadesFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $validation = [];

        if (!empty($this->request->get('dt_nascimento')))
        {
            $validation = [
                'razao_social' => 'required|min:3|max:100',
                'id_organizacao' => 'required',
                'cnpj_cpf' => [
                    'required',
                    'cpfcnpj',
                    Rule::unique('pgsql.entidades.entidades')->ignore($this->entidade)
                ],
                'id_situacao' => 'required',
                'tipo' => 'required',
                'email_pessoal' => 'required|email',
                'email_cobranca' => 'required|email',
                'dt_nascimento' => 'date'
            ];
        }else {
            $validation = [
                'razao_social' => 'required|min:3|max:100',
                'id_organizacao' => 'required',
                'cnpj_cpf' => [
                    'required',
                    'cpfcnpj',
                    Rule::unique('pgsql.entidades.entidades')->ignore($this->entidade)
                ],
                'id_situacao' => 'required',
                'tipo' => 'required',
                'email_pessoal' => 'required|email',
                'email_cobranca' => 'required|email',
            ];
        }

        return $validation;
    }

    /*public function messages()
    {
        return [
          'id_organizacao.required' => 'Informe a organização',
          'id_situacao.required' => 'Informe a situação da entidade'
        ];
    }*/
}
