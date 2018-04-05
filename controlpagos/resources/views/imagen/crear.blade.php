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
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>Proveedor</h3>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <h2>Creación de Proveedores <small></small></h2>
                                <div class="x_content">
                                    <br />
                                    {!! Form::open(['route' => 'prov_store', 'method' => 'POST', 'class' => "form-horizontal"]) !!}
                                        {!! csrf_field() !!}
                                        @include('admin.proveedor.partials.fields')
                                        <br />
                                        <div class="ln_solid"></div>
                                        <div class="form-group" align="center">
                                            {!! Form::submit('Guardar', array('class'=>'send-btn', 'class'=>'btn btn-primary')) !!}
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /page content -->
                @include('footer')
            </div>
    <!-- /page content -->
@include('layout.footer_admin')


