<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;
use App\Http\Controllers\monedaControllers;
use Session;
use DB;
use View;
use Form;
use Illuminate\Support\Facades\URL;

$fecha = Session::get('fecha');
if (strpos($fecha,"-") !== false) {
    $fecha=explode("-",$fecha);
    if ($fecha[1]<10)
        $fecha[1]='0'.$fecha[1];
    if ($fecha[2]<10)
        $fecha[2]='0'.$fecha[2];
    $fecha = $fecha[2]."/".$fecha[1]."/".$fecha[0];
}

?>

@include('layaout.header_admin')
    <!-- page content -->
    {!! Form::open(array('url' => 'guardar_pago_nuevo', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
    <input type="hidden" name="total" value=0 />
    <input type="hidden" name="montos" value="" />

    <div class="left_col" role="main">
        <div class="clearfix">         
            <div class="page-title">
                <div class="title_left" style="width:100%;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="dashboard_graph">
                                <div class="row x_title">
                                    <h2>Consulta de Pagos</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <!--div class="item form-group">
                                    <div class="col-xs-3">
                                        <input id="nro_factura" name="nro_factura" type="text" data-validate-length-range="10" data-validate-words="1" required="required" class="form-control" placeholder="Nro de Factura" value="">
                                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                                    </div>
                                    <div class="col-xs-3">
                                        <input id="nro_control" name="nro_control" type="text" data-validate-length-range="10" data-validate-words="1" required="required" class="form-control" placeholder="Nro de Control" value="">
                                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                                    </div>                
                                    <div class="col-md-3">
                                        <input value="{{ $fecha }}" type="text" class="form-control" data-inputmask="'mask': '99/99/9999'" id="fecha_pago" name="fecha_pago">
                                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                                    </div>               
                                </div-->                                   
                                <div class="x_content">
                                    {{ PagosControllers::consulta_pagos($id_clinica, $id_medico) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>       
        <!--div class='alert alert-info'>
            <strong>Nota: 
                <ul>
                    <li>Si luego de haber seleccionado un monto desea cambiarlo, debe primero desseleccionar este monto y modificar el mismo</li>
                    <li>Para colocar los montos tenga en cuenta que los decimales seran con coma (,)</li>
                </ul>
            </strong>
        </div-->
        <div align="center">
            <input type="button" onclick="history.go(-1)" value="Regresar" class="btn btn-primary" />
        </div>
    </div>
{!! Form::close() !!}

    <!-- /page content -->
@include('layaout.footer_admin')