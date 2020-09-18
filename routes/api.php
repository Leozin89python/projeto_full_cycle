<?php


use Illuminate\Support\Facades\Route;

Route::prefix('v1')->namespace('Api\V1')->group(function (){

    Route::post('createMessage', 'ServiceController@createMessage');

    Route::post('login',  'AuthApiController@login');
    Route::get('logout',  'AuthApiController@logout');
    Route::get('refresh', 'AuthApiController@refresh');
    Route::get('info',   'AuthApiController@info');
    Route::post('extra_validacao', 'ExtraValidacao\ExtraValidacaoController@validar');

    //Route::get('/eqtp_fabricante', 'EquipamentosFabricantesController@index');

    Route::group(['middleware' =>['jwt.auth']], function (){


        Route::prefix('users')->name('users.')->group(function (){
            Route::resource('/', 'UserController');
        });


    });

});



