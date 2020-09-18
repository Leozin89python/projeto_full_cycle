<?php

namespace App\Models\Viagens;

use App\Models\Traits\Uud;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Passageiros extends Model
{
    use Uud;
    protected $table       = 'viagens.passageiros';
    protected $keyType     = 'string';
    public $primaryKey     = 'id';
    public $incrementing   = false;
    public $timestamps     = false;

    protected $fillable    = [
        'dh_cadastro', 'id_operador_cadastro', 'dh_atualizacao', 'id_operador_atualizacao', 'id_organizacao', 'id_entidade',
        'ativo', 'nome_completo', 'id_ibutton', 'matricula_id'
    ];


    #ocultar campos de retorno
    protected $hidden = [];



    public function getResults($data)
    {
        $totalPages = $data['per_page'] ?? '10';

        return DB::table('viagens.passageiros as pass')
            ->join('organizacoes.organizacoes as org','pass.id_organizacao','=','org.id')
            ->join('entidades.entidades as enti','pass.id_entidade','=','enti.id')
            ->where(function ($query) use ($data){
                $query->whereRaw(
                    "(pass.nome_completo ILIKE '%".$data['filtro']."%' OR
                        org.razao_social ILIKE '%".$data['filtro']."%' OR
                        enti.razao_social ILIKE '%".$data['filtro']."%' OR 
                        CAST(pass.id_ibutton AS VARCHAR) ILIKE '".$data['filtro']."%' OR
                        CAST(pass.matricula_id AS VARCHAR) ILIKE '".$data['filtro']."%')"
                );
            })->selectRaw("pass.id,pass.dh_cadastro,pass.dh_atualizacao,pass.ativo,pass.nome_completo,pass.id_ibutton,
                    pass.matricula_id,org.razao_social AS organizacao,enti.razao_social AS entidade")
            ->orderBy('pass.nome_completo')
            ->orderBy('enti.razao_social')
            ->paginate($totalPages);
    }

    public function show($id)
    {
        return DB::table($this->table)
            ->where('id','=',$id)
            ->selectRaw("id,dh_cadastro,dh_atualizacao,id_organizacao,id_entidade,ativo,nome_completo,id_ibutton,matricula_id")
            ->get();
    }

    public function checkPassageiro($id_organizacao,$id_entidade,$nome,$id = null)
    {
        $filtro = "id_organizacao = '".$id_organizacao."' AND id_entidade = '".$id_entidade."' AND UPPER(nome_completo) = UPPER('".$nome."')";

        if (isset($id) && !empty($id)){
            $filtro = "id <> '".$id."' AND id_organizacao = '".$id_organizacao."' AND id_entidade = '".$id_entidade."' AND UPPER(nome_completo) = UPPER('".$nome."')";
        }

        return DB::table($this->table)
            ->whereRaw($filtro)
            ->count();
    }

    public function checkRFID($id_organizacao,$id_entidade,$id_button,$id = null)
    {
        $filtro = "id_organizacao = '".$id_organizacao."' AND id_entidade = '".$id_entidade."' AND id_ibutton = '".$id_button."'";

        if (isset($id) && !empty($id))
            $filtro = "id <> '".$id."' AND id_organizacao = '".$id_organizacao."' AND id_entidade = '".$id_entidade."' AND id_ibutton = '".$id_button."'";

        return DB::table($this->table)
            ->whereRaw($filtro)
            ->count();
    }
}
