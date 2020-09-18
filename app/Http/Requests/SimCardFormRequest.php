<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimCardFormRequest extends FormRequest
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
            "id_organizacao" => "required",
            "id_situacao" => "required",
            "id_operadora" => "required",
            "tipo" => "required",
            "numero_serie" => "required",
            "apn_url" => "required",
            "apn_usuario" => "required",
            "apn_senha" => "required",
        ];
    }
}
