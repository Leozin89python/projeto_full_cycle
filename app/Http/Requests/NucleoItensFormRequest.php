<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NucleoItensFormRequest extends FormRequest
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
        $validation = [
            'id_manutencao' => 'required',
            'id_veiculo' => 'required',
            'servico' => 'required',
        ];
        if (($this->servico == 'I' || $this->servico == 'A') && empty($this->id_equipamento_substituto)){
            $validation = array_merge($validation, [
                'id_equipamento_substituto' => 'required'
            ]);
        }elseif ($this->servico == 'S' && empty($this->id_equipamento) && empty($this->id_equipamento_substituto)){
            $validation = array_merge($validation, [
                'id_equipamento' => 'required',
                'id_equipamento_substituto' => 'required'
            ]);
        }elseif (($this->servico == 'R' && empty($this->id_equipamento)) || ($this->servico == 'V' && empty($this->id_equipamento))
            || ($this->servico == 'B' && empty($this->id_equipamento)) || ($this->servico == 'C' && empty($this->id_equipamento))){
            $validation = array_merge($validation, [
                'id_equipamento' => 'required'
            ]);
        }

        return $validation;
    }
}
