<?php

namespace App\Http\Requests;

use App\Rules\Space;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuariosUsuariosFormRequest extends FormRequest
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
            "id_grupo" => "required",
            "nome_completo" => "required",
            "user_login" => [
                "required",
                new Space(),
                Rule::unique('pgsql.usuarios.usuarios')->ignore($this->route('usuario'))
            ],
            "user_email" => "required|email",
            "validade" => "required",
            "id_organizacao" => "required",
            "id_organizacao_dono" => "required",
            "id_fuso_horario" => "required",
        ];

        if ($this->request->get('extra_validacao') == 'true'){
            $rules = array_merge($rules,["celular_validacao" => "required|celular_com_ddd",]);
        }

        return $rules;
    }
}
