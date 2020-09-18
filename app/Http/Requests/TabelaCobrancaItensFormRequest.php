<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TabelaCobrancaItensFormRequest extends FormRequest
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
            'id_tabela_preco' => 'required',
            'qtd_inicial' => 'required',
            'qtd_final' => 'required|gt:qtd_inicial',
            'valor' => 'required',
            'valor_sms' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'qtd_final.gt' => 'A quantidade final deve ser maior que a quantidade inicial.'
        ];
    }
}
