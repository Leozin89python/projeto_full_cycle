<?php

use Carbon\Carbon;

function formatDateAndTime($date, $format){
    return Carbon::parse($date)->format($format);
}

function gerar_senha($tamanho, $maiusculas = true, $minusculas= true, $numeros = true, $simbolos= false){
    $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiusculas
    $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
    $nu = "0123456789"; // $nu contem os numeros
    $si = "!@#$%¨&*()_+="; // $si contem os sibolos
    $senha = "";


    if ($maiusculas){
        // se $maiusculas for "true", a variavel $ma é embaralhada e adicionada para a variavel $senha
        $senha .= str_shuffle($ma);
    }

    if ($minusculas){
        // se $minusculas for "true", a variavel $mi é embaralhada e adicionada para a variavel $senha
        $senha .= str_shuffle($mi);
    }

    if ($numeros){
        // se $numeros for "true", a variavel $nu é embaralhada e adicionada para a variavel $senha
        $senha .= str_shuffle($nu);
    }

    if ($simbolos){
        // se $simbolos for "true", a variavel $si é embaralhada e adicionada para a variavel $senha
        $senha .= str_shuffle($si);
    }

    // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variavel $tamanho
    return substr(str_shuffle($senha),0,$tamanho);
}

function setDataAttribute($value){
    //Recebe data no padrão brasileiro (d-m-Y) e transforma para (Y-m-d)
    $dia = substr($value, 0, 2);
    $mes = substr($value, 3, 2);
    $ano = substr($value, 6, 4);

    //retorna a data em uma instancia de Carbon
    return Carbon::create($ano,$mes,$dia);

}

function formatCnpjCpf($value)
{
    $cnpj_cpf = preg_replace("/\D/", '', $value);

    if (strlen($cnpj_cpf) === 11) {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
    }

    return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}

function monthText($strDate){
    $arrMonthsOfYear = array(1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
    $intMonthOfYear = date('n',strtotime($strDate));
    return $arrMonthsOfYear[$intMonthOfYear] ;
}

function getFile($path,$name)
{
    return glob($path.$name);
}