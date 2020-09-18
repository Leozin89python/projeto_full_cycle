<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SendPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $email,$password,$user_login,$nome_completo;

    public function __construct($nome,$login,$mail,$pass)
    {
        $this->email = $mail;
        $this->password = $pass;
        $this->user_login = $login;
        $this->nome_completo = $nome;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $org = DB::table('organizacoes.organizacoes')->where('id','=',auth('api')->user()->id_organizacao)->get();
        $info = 'Para mais informações sobre segurança e senha de acesso, clique no botão ao lado.';
        $info_link = 'http://www.geomx.com.br/ajuda/?q=Password';

        return $this->from('smtp1@monitorar24h.com.br')
            ->to($this->email)
            ->subject($org[0]->razao_social.' - Senha de Acesso')
            ->view('email')
            ->with([
                'SAUDACAO' => $this->nome_completo,
                'USERLOGIN' => $this->user_login,
                'PASSWORD' => $this->password,
                'INFORMACOES' => $info,
                'INFORMACOES_LINK' => $info_link,
            ]);
    }
}
