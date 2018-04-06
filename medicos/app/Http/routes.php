<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('inicio.inicio');
});

Route::get('test', function () {
    return view('test');
});

Route::get('index', function () {
    return View::make('dashboard.index');
});

Route::post('verificar_usuario', array(
    'as' => 'verificar_usuario',
    'uses' => 'UserControllers@verificar_usuario'
));

Route::get('nuevo_medico', array(
    'as' => 'nuevo_medico',
    'uses' => 'UserControllers@nuevo_medico'
));

Route::post('guardar_usuario_nuevo', array(
    'as' => 'guardar_usuario_nuevo',
    'uses' => 'UserControllers@guardar_usuario_nuevo'
));

Route::post('guardar_usuario_edicion/{id}', array(
    'as' => 'guardar_usuario_edicion',
    'uses' => 'UserControllers@guardar_usuario_edicion'
));

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});



