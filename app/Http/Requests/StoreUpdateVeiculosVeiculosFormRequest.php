<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateVeiculosVeiculosFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_organizacao' => 'required',
            'id_entidade' => 'required',
            'id_situacao' => 'required',
            'id_tipo' => 'required',
            'id_unidade' => 'required',
            'placa' => 'required|max:15',
            'ano_fabricacao' => 'required',
            'id_fabricante' => 'required',
            'modelo' => 'required|max:60',
            'cor' => 'required',
            'chassi' => 'max:17',
            'id_situacao_administrativa' => 'required',
        ];
    }
}
