<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RelatoriosProgramadosFormRequest extends FormRequest
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
            "descricao" => "required",
            "tipo_relatorio" => "required",
            "id_usuario" => "required",
            "emails_notificacao" => "required|email",
        ];
    }
}
