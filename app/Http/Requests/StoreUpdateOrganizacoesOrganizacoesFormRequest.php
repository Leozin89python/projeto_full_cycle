<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateOrganizacoesOrganizacoesFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    #validar os demais campos
    public function rules()
    {
        return [
            'razao_social' => [
                'required',
                'min:3',
                'max:100',
                Rule::unique('pgsql.organizacoes.organizacoes')->ignore($this->organizaco)
            ],
            'cnpj_cpf' => [
                'required',
                'cpfcnpj',
                Rule::unique('pgsql.organizacoes.organizacoes')->ignore($this->organizaco)
            ],
            'end_cep' => 'required|formato_cep',
            'id_situacao' => 'required',
            'email_financeiro' => 'required|email',
            'id_tabela_cobranca' => 'required',
            'passar_localizacao' => 'required',
            'utilizar_senha_atendimento' => 'required',
            'vincular_rastreador_veiculo' => 'required'
        ];
    }

    /*public function messages()
    {
        return [
            'end_cep.required' => 'O campo CEP e obrigatório',
            'id_situacao.required' => 'Informe a situação da empresa',
            'id_tabela_cobranca.required' => 'Selecione a tabela de cobrança para a organização'
        ];
    }*/
}
