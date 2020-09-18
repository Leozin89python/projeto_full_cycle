<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EquipamentosEquipamentosRequest extends FormRequest
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
            "id_situacao" => "required",
            "id_fabricante" => "required",
            "id_modelo" => "required",
            "eqpt_numero" => [
                "required",
                "max:15",
                Rule::unique('pgsql.equipamentos.equipamentos')->ignore($this->route('equipamento'))
            ],
            "eqpt_numero_serie" => "required",
            "id_estoque" => "required",
        ];

        if (!empty($this->request->get('id_simcard'))){
            $rules = array_merge($rules, ["id_simcard" => [
                    Rule::unique('pgsql.equipamentos.equipamentos')->ignore($this->route('equipamento'))
                ],
            ]);
        }

        if (!empty($this->request->get('id_simcard_2'))){
            $rules = array_merge($rules, ["id_simcard_2" => [
                    Rule::unique('pgsql.equipamentos.equipamentos')->ignore($this->route('equipamento'))
                ],
            ]);
        }

        return $rules;
    }
}
