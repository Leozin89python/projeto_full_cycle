<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{

    protected $dontReport = [
        //
    ];


    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];


    public function report(Exception $exception)
    {
        parent::report($exception);
    }


    public function render($request, Exception $exception)
    {
        if($exception instanceof NotFoundHttpException){
            #requisicao tipo ajax
            if($request->expectsJson())
                return response()->json(['msg' => 'Not_found_URI'],$exception->getStatusCode());
        }

        if($exception instanceof MethodNotAllowedHttpException){
            #Metodos de requisição
            if($request->expectsJson())
                return response()->json(['msg' => 'Method_Not_Allowed'],$exception->getStatusCode());
        }

        return parent::render($request, $exception);
    }
}
