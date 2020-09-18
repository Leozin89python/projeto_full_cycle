<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateFinanceiroTabelaPrecosFormRequest extends FormRequest
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

    public function rules()
    {
        return [
            'id_organizacao' => 'required',
            'descricao' => 'required',
            'valor_adesao' => 'required_if:comodato,==,TRUE|required_if:ativo_sem_transmissao,==,TRUE'
        ];
    }
}
