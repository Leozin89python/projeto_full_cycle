<?php
//alterações feitas
# se extra_validação for true  não gera token

namespace App\Http\Controllers\Api\V1;

use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonInterval;
use App\Models\ExtraValidacao\ExtraValidacao;

class AuthApiController extends Controller
{
    public  function  login (Request $request)
    {
        $credentials =  $request->all('user_login', 'user_passwd');#validação de acesso

        $this->validate($request, [
            $this->username() => 'required|string',
            'user_passwd' => 'required|string',
        ]);

        try
        {
            if(!$token = auth('api')->attempt($credentials))
                return response()->json(['msg' => 'Unauthorized'], 401);

        }
        catch (JWTException $e)
        {
            return response()->json(['msg' => 'coud_not_created_token'],500);
        }

        $extra = auth('api')->user()['extra_validacao']; #obtem  valor da flag  true ou false
        $user = auth('api')->user();

        if($extra === true) { #caso for true não gera token

            //Envio do Codigo de Validação 2fa
            /*Dados de Acesso Api sms*/
            $userName = env('USERNAMEALAGAR');
            $passWord = env('PASSWORDALGAR');


            $telefone = $user['celular_validacao'];
            $telefone = str_replace("(", "", $telefone);
            $telefone = str_replace(")", "", $telefone);
            $telefone = str_replace("-", "", $telefone);
            $txtNumero = "+55" . $telefone;

            $_temp_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            $resp2 = '{"messages":[{"from":"Power","destinations":[{"to":"'.$txtNumero.'"}],"text":"'.$_temp_code.'","flash":false,"intermediateReport":false,"notifyUrl" : "http://power.acidata.com.br/algarStatusSMS/" ,"notifyContentType":"application/json","callbackData":"DLR callback data"}],"tracking":{"track":"SMS","type":"MY_CAMPAIGN"}}';

            $client = new Client();
            $credentials = base64_encode("$userName:$passWord");
            $res = $client->post(env('URL_API_SMS_ALGAR'), [
                'body' => $resp2,
                'headers' => [
                    'Content-Type: application/json',
                    'Authorization' => 'Basic '.$credentials
                ]
            ]);

            $result = $res->getBody()->getContents();

            /*$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, env('URL_API_SMS_ALGAR'));
            curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $resp2);
            $result = curl_exec($ch);
            curl_close($ch);*/

            $date = Carbon::now('America/Sao_Paulo');
            $interval = CarbonInterval::minutes(5);
            $dh_interval = $date->addSeconds($interval->totalSeconds);

            if (DB::table('notificacoes.sms_2fa')->where('id_usuario_envio','=',$user['id'])->count() > 0)
            {
                if(!ExtraValidacao::where('id_usuario_envio','=', $user['id'])
                    ->update([
                        'id_usuario_envio' => $user['id'],
                        'dh_cadastro' => $dh_interval,
                        'id_organizacao' => User::find($user['id'])->organizacoes[0]->id,
                        'numero_envio' => $txtNumero,
                        'codigo_2fa' => $_temp_code,
                        'sms_retorno' => $result
                    ]))
                    return response()->json([ 'errors' => ['msg' => 'Erro ao inserir codigo 2fa' ]],401);

            }else{
                $notificacao = new ExtraValidacao();
                $notificacao->dh_cadastro = $dh_interval;
                $notificacao->id_usuario_envio = $user['id'];
                $notificacao->id_organizacao = User::find($user['id'])->organizacoes[0]->id;
                $notificacao->numero_envio = $txtNumero;
                $notificacao->codigo_2fa = $_temp_code;
                $notificacao->sms_retorno = $result;

                if(!$insert = $notificacao->save())
                    return response()->json([ 'errors' => ['msg' => 'Erro ao inserir codigo 2fa' ]],401);

            }

            return response()->json([
                'success' => false,
                'extra_validacao' => $extra,
                "id_user" => $user['id'],
                'status_2fa' => true
            ]);
        }

        $org_ativo = User::find($user['id'])->organizacoesSituacoes;

        $dh_atual = Carbon::now();

        $acesso_semana = User::find($user['id'])->
        acesso_semana(auth('api')->
        user()['id']);

        #validações  de acesso
        #acesso ha plataforma
        if (!$user['acesso_plataforma'])
            return response()->json([
                "errors" => [
                    "msg" => "Usuário não tem permissão para acessar a plataforma. Contacte do administrador",
                ],
            ],401);

        #veirifica se usuario esta ativo
        if (!$user['ativo'])
            return response()->json([
                "errors" => [
                    "msg" => "Usuário desabilitado no cadastro. Contacte do administrador"
                ],
            ],401);


        if ($user['bloqueio'])
            return response()->json([
                "errors" => [
                    "msg" => "Permissão Negada! Favor entrar em contato com o suporte!"
                ]
            ]);


        if ($dh_atual->isAfter(Carbon::create($user['validade'])))
            return response()->json([
                "errors" => [
                    "msg" => "Usuário com acesso vencido. Contacte do administrador"
                ]
            ]);

        #situacoes da organização
        if ($org_ativo[0]->ativo == false)
            return response()->json([
                "errors" => [
                    "msg" => "Organização desabilitada no cadastro. Contacte do administrador"
                ]
            ]);

        if ($org_ativo[0]->adm)
            return response()->json([
                "errors" => [
                    "msg" => "Permissão Negada! Favor entrar em contato com o suporte!"
                ]
            ]);

        if (!$acesso_semana[0]->acesso_semana)
            return response()->json([
                "errors" => [
                    "msg" => "Usuário não tem permissão de acesso neste horário."
                ]
            ]);


        User::find($user['id'])->updateDhAcesso($user['id']);

        return response()->json([
            "success" => true,
            "token"=> $token,
            "extra_validacao"=> $extra,
            "user" => $user
        ]);

        // return response()->json(['token'=> $token, '2fa' => $extra],200);
    }

    public function  logout()
    {
        auth('api')->logout();

        return response()->json([
            "msg" => "Logout sucesso"
        ]);
    }

    public function refresh()
    {
        $token = auth('api')->refresh();

        return response()->json(['token' => $token],200);
    }

    #
    public function info()
    {
        return response()->json(auth('api')->user());
    }

    //Alterando username padrão
    public function username(){
        return 'user_login';
    }
}
