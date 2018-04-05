<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\UsuariosControllers;
use App\Http\Controllers\SessionusuarioControllers;
use App\Http\Controllers\ProveedorControllers;
use Session;
use DB;
use View;
use Form;
use Illuminate\Support\Facades\URL;

?>

@include('layout.header_admin')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="clearfix">
            <div class="page-title">
                <div class="title_left" style="width:100%;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="dashboard_graph">
                                <div class="row x_title">
                                    <h2>Proveedores <small>Activos</small></h2>        
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <span class="section">Informacion de los Proveedores</span>
                                    {{ ProveedorControllers::consulta() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('footer')    
    </div>
    <!-- /page content -->
@include('layout.footer_admin')

