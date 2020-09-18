<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PivosFormRequest extends FormRequest
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
        $rules = [
            "id_organizacao" => "required",
            "id_entidade" => "required",
            "id_situacao" => "required",
            "id_tipo" => "required",
            "id_unidade" => "required",
            "placa" => "required|max:15",
            "ano_fabricacao" => "required",
            "id_fabricante" => "required",
            "modelo" => "required|max:60",
            "cor" => "required",
            "id_situacao_administrativa" => "required",
        ];

        if (!empty($this->request->get('chassi'))){
            $rules = array_merge($rules, ["chassi" => "min:17",]);
        }

        if (!empty($this->request->get('id_equipamento'))){
            $rules = array_merge($rules, ["id_equipamento" => [
                    Rule::unique('pgsql.veiculos.veiculos')->ignore($this->route('pivo'))
                ],
            ]);
        }

        return $rules;
    }
}
