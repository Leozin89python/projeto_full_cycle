<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;


class ServiceController extends Controller
{
    public function createMessage(Request $request)
    {
        //Recupera os campos telefone e mensagem
        $data = $request->all();

        $client = new Guzzle ;

        $myBody = array(
            [
                'name'     => 'email',
                'contents' => 'sau-lode@outlook.com'
            ],
            [
                'name'     => 'token',
                'contents' => 'b544c2bb00ad8cc5ced36acc9e3ef4c6527002'
            ],
            [
                'name'     => 'idapp',
                'contents' => '4742'
            ],
            [
                'name'     => 'idmsg',
                'contents' => Uuid::uuid4()
            ],
            [
                'name'     => 'whatsapp',
                'contents' => $data['telefone']
            ],
            [
                'name'     => 'mensagem',
                'contents' => $data['mensagem']
            ],
            [
                'name' => 'midia',
                'contents' => ''
            ],
            [
                'name' => 'url_anexo',
                'contents' => ''
            ],
            [
                'name' => 'emoji',
                'contents' => 'nao'
            ]
        );

        try{
            $request = $client->post(env('URLWHATSAPP'),  ['multipart'=>$myBody]);

            $data = json_decode($request->getBody());

            return response()->json(['data' => $data]);
        }catch(RequestException $e){
            return response()->json(['error' => $e]);
        }

    }
}
