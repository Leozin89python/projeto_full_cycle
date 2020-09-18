<?php

namespace App;

use App\Models\Organizacoes\OrganizacoesOrganizacoes;
use App\Models\Usuarios\UsuariosGrupos;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements  JWTSubject
{
    use Notifiable;

    protected $table       = 'usuarios.usuarios';
    protected $keyType     = 'string';
    public $primaryKey     = 'id';
    public $incrementing   = false;

    public $timestamps     = false;


    protected $fillable    = [
        'user_login', 'user_passwd',
    ];


    protected $hidden = [
        'user_passwd'
    ];



    public function getJWTIdentifier()

    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) $model->generateNewId();
        });
    }

    public function generateNewId(){
        return Uuid::uuid4();
    }

    //Formatando as datas
    /*public function getDhCadastroAttribute()
    {
        return formatDateAndTime($this->attributes['dh_cadastro']);
    }

    public function getDhAtualizacaoAttribute()
    {
        return formatDateAndTime($this->attributes['dh_atualizacao']);
    }

    public function getDhUltimoAcessoAttribute()
    {
        return formatDateAndTime($this->attributes['dh_ultimo_acesso']);
    }

    public function getDhAcessoAttribute()
    {
        return formatDateAndTime($this->attributes['dh_acesso'],'d/m/Y H:i');
    }

    public function getValidadeAttribute()
    {
        return formatDateAndTime($this->attributes['validade'],'d/m/Y');
    }*/

    //buscar todos os dados de uma organização vinculada ao usuário
    public function organizacoes()
    {
        return $this->hasMany(OrganizacoesOrganizacoes::class,'id','id_organizacao');
    }

    //Buscar a situação de cadastro e financeira da organização vinculado ao usuário
    public function organizacoesSituacoes()
    {
        return $this->hasMany(OrganizacoesOrganizacoes::class,'id','id_organizacao')->
        join('organizacoes.situacoes', 'organizacoes.situacoes.id', '=', 'organizacoes.organizacoes.id_situacao')->
        join('organizacoes.situacao_administrativa','organizacoes.situacao_administrativa.id','=','organizacoes.organizacoes.app_id')->
        select('organizacoes.organizacoes.id','organizacoes.situacoes.ativo','organizacoes.situacao_administrativa.ativo as adm');
    }

    public function acesso_semana($id)
    {
        return DB::select("SELECT usuarios.acesso_semana('{$id}')");
    }

    public function grupos()
    {
        $grupos = $this->hasMany(UsuariosGrupos::class, 'id','id_grupo')->get();

        if ($grupos[0]->administrador || $grupos[0]->administrador_secundario || $grupos[0]->supervisao || $grupos[0]->conta_secundaria)
        {
            return response()->json(["info" => 'monitoramento']);
        }
        elseif ($grupos[0]->conta_cliente_avancado)
        {
            return response()->json(["info" => 'monitoramentoavancado']);
        }
        elseif ($grupos[0]->conta_cliente)
        {
            return response()->json(["info" => 'monitoramentobasico']);
        }
        else
        {
            return response()->json(["info" => 'monitoramento']);
        }
    }

    public function grupo()
    {
        return $this->hasMany(UsuariosGrupos::class, 'id','id_grupo');
    }

    public function updateDhAcesso($id)
    {
        $user = User::find($id);
        $user->dh_acesso = $user->dh_ultimo_acesso;
        //$user->dh_acesso = Carbon::parse($user->dh_acesso)->format('Y-m-d H:i');
        $user->dh_ultimo_acesso = "NOW()";
        if ($user->save())
        {
            return response()->json(["msg" => true]);
        }
        else
        {
            return response()->json([
                "success" => false,
                "msg" => "Erro ao atualizar"
            ]);
        }
    }

    //Alterando os campos padrão de login
    public function getAuthPassword()
    {
        return $this->user_passwd;
    }

    public function getNameAttribute()
    {
        return $this->user_login;
    }
}