<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
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
    <div class="left_col" role="main">
        <div class="clearfix">
            <div class="page-title">
                <div class="title_left" style="width:100%;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="dashboard_graph">
                                <div class="row x_title">
                                    <h2>Usuarios <small>Activos</small></h2>        
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <span class="section">Informacion de los Usuarios</span>
                                    {{ UserControllers::consulta_usuario() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
{!! Form::close() !!}
@include('layaout.footer_admin')

