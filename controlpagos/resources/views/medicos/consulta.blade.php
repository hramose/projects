<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\UsuariosControllers;
use App\Http\Controllers\SessionusuarioControllers;
use App\Http\Controllers\UserControllers;
use Session;
use DB;
use View;
use Form;
use Illuminate\Support\Facades\URL;

?>

@include('layaout.header_admin')
{!! Form::open(array('url' => '', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
<!--input type="hidden" name="_token" value="{{ csrf_token() }}"-->
    <!-- page content -->
    <div class="x_content">
        <h2>Medicos <small>Activos</small></h2>
        <span class="section">Informacion de los Medicos</span>
        {{ UserControllers::consulta() }}
    </div>
    <!-- /page content -->
{!! Form::close() !!}
@include('layaout.footer_admin')

