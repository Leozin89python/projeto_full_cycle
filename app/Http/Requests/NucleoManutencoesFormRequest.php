<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NucleoManutencoesFormRequest extends FormRequest
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
        $validations = [];
        if (auth('api')->user()->id_grupo == 'b2c64335-b43e-4eac-850b-acef50eac376' || auth('api')->user()->id_grupo == 'aeec581d-ebc2-4327-b471-be7e5e411b03'):
            $validations = [
                'id_situacao' => 'required',
                'id_organizacao' => 'required',
                'id_entidade' => 'required',
                'informacoes' => 'required',
                'dh_visita' => 'required|min:15',
            ];
        else:
            $validations = [
                'id_situacao' => 'required',
                'id_organizacao' => 'required',
                'id_entidade' => 'required',
                'id_fornecedor' => 'required',
                'informacoes' => 'required',
                'dh_visita' => 'required|min:15',
            ];
        endif;
        return $validations;
    }
}
