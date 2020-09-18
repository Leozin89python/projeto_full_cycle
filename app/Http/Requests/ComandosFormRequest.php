<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComandosFormRequest extends FormRequest
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
            "id_fabricante" => "required",
            "id_modelo" => "required",
            "descricao" => "required",
            "template_xml" => "required",
            "sequencia_max" => "required_if:sequencia_numerica,=,true",
            "tamanho_alfa" => "required_if:sequencia_numerica,=,false",
        ];
    }
}
