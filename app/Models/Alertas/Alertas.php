<?php

namespace App\Models\Alertas;

use App\Models\Traits\Uud;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Alertas extends Model
{
    use Uud;
    protected $table       = 'notificacoes.alertas';
    protected $keyType     = 'string';
    public $primaryKey     = 'id';
    public $incrementing   = false;
    public $timestamps     = false;

    protected $fillable    = [
        "descricao", "dh_cadastro", "id_operador_cadastro","status","titulo","status_interno","dh_atualizacao","id_operador_atualizacao"
    ];


    #ocultar campos de retorno
    protected $hidden = [];


    public function getResults($pages)
    {
        return DB::table('notificacoes.alertas as al')
            ->join('usuarios.usuarios as usucad','usucad.id','=','al.id_operador_cadastro')
            ->leftJoin('usuarios.usuarios as usuat','usuat.id','=','al.id_operador_atualizacao')
            ->where('al.status','=','true')
            ->selectRaw("al.id,al.descricao,al.status,TO_CHAR(al.dh_cadastro, 'DD/MM/YYYY HH24:MI') as dh_cadastro,usuat.nome_completo as usuario_atualizacao,
                TO_CHAR(al.dh_atualizacao, 'DD/MM/YYYY HH24:MI') as dh_atualizacao,usucad.nome_completo as usuario_cadastro,al.titulo")
            ->orderBy('al.dh_cadastro')
            ->paginate($pages);
    }

    public function show($id)
    {
        return DB::table($this->table)
            ->where('id','=',$id)
            ->selectRaw("id,descricao,status,titulo")
            ->get();
    }

    public function alertasApi()
    {
        return DB::table('notificacoes.alertas')
            ->where('status','=',true)
            ->selectRaw("id,titulo,descricao,status,TO_CHAR(dh_cadastro, 'DD/MM/YYYY') as data_cadastro")
            ->orderBy('dh_cadastro')
            ->get();
    }
}
