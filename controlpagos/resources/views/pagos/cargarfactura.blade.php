<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;
use App\Http\Controllers\monedaControllers;
use Session;
use DB;
use View;
use Form;
use Illuminate\Support\Facades\URL;

?>

@include('layaout.header_admin')
    <!-- page content -->
    {!! Form::open(array('url' => 'guardar_pago_nuevo_factura', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
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
                                    <h2>Consulta de Facturas</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="item form-group">
                                    <!--div class="col-xs-3">
                                        <input id="nro_factura" name="nro_factura" type="text" data-validate-length-range="10" data-validate-words="1" required="required" class="form-control" placeholder="Nro de Factura" value="">
                                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                                    </div>
                                    <div class="col-xs-3">
                                        <input id="nro_control" name="nro_control" type="text" data-validate-length-range="10" data-validate-words="1" required="required" class="form-control" placeholder="Nro de Control" value="">
                                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                                    </div>
                                    <div class="col-md-3">
                                        <input readonly id="fecha_factura" name="fecha_factura" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" value="{{ $fecha }}">
                                    </div-->
                                    <!--div class="col-md-3">
                                        <input value="{{ $fecha }}" type="text" class="form-control" data-inputmask="'mask': '99/99/9999'" id="fecha_factura" name="fecha_factura">
                                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                                    </div-->               
                                </div>                                   
                                <div class="x_content">
                                    {{ PagosControllers::consulta_facturas($id_clinica, $id_medico) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <label class="control-label col-xs-3" id="total_pagar">Total a pagar: </label>   
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
            <input type="submit" name="send" id="send" value="Guardar Factura" class="btn btn-primary" />
        </div>
    </div>

    <?php
        $sql = "(select sum(pc.monto) as monto_pagado, c.monto as monto_total,
                    m.nombres as medico, 
                    p.nombres as nombre_paciente, p.apellidos as apellido_paciente, p.id as id_paciente,
                    c.nombre as diagnostico, c.id as id_cirugia, 
                    cm.id_clinica as id_clinica, c.seguros, 
                    cm.nombre as clinica, c.nro_historia, p.cedula
                from 
                    paciente p, cirugias c, medico m, clinica_medico cm, pagosclinicas pc 
                where
                    c.id=pc.id_cirugia and 
                    m.id=c.id_medico and p.id=c.id_paciente and 
                    c.id_clinica=$id_clinica and c.id_medico=$id_medico and
                    cm.id_medico=c.id_medico and cm.id_clinica=c.id_clinica and
                    p.id_medico=$id_medico and
                    p.id_medico=c.id_medico and   
                    c.id in (select id_cirugia from alta) and 
                    c.id not in (select id_cirugia from facturas) ";
                if (Session::get("tipo")==2)
                    $sql .= " and c.id_medico=".Session::get("id_medico");                    
                $sql .= " group by m.nombres, p.nombres, p.apellidos, p.id,
                    c.nombre, c.id, cm.id_clinica, c.seguros
                having sum(pc.monto) < c.monto)

                union

                (select 0 as monto_pagado, c.monto as monto_total,
                    m.nombres as medico, 
                    p.nombres as nombre_paciente, p.apellidos as apellido_paciente, p.id as id_paciente,
                    c.nombre as diagnostico, c.id as id_cirugia, 
                    cm.id_clinica as id_clinica, c.seguros, 
                    cm.nombre as clinica,
                    c.nro_historia, p.cedula
                from 
                    paciente p, cirugias c, medico m, clinica_medico cm
                where
                    m.id=c.id_medico and p.id=c.id_paciente and 
                    c.id_clinica=$id_clinica and c.id_medico=$id_medico and
                    cm.id_medico=c.id_medico and cm.id_clinica=c.id_clinica and
                    p.id_medico=$id_medico and
                    p.id_medico=c.id_medico and                    
                    c.id in (select id_cirugia from alta) and 
                    c.id not in (select id_cirugia from pagosclinicas) and 
                    c.id not in (select id_cirugia from facturas) ";
                if (Session::get("tipo")==2)
                    $sql .= " and c.id_medico=".Session::get("id_medico");
                $sql .= " group by m.nombres, p.nombres, p.apellidos, p.id,
                    c.nombre, c.id, cm.id_clinica, c.seguros, cm.nombre)";
                
                $data = DB::select($sql);
                echo '<script type="text/javascript">';
                foreach ($data as $data) {
                    echo '                        
                        $(document).ready(function () {
                            var end_date = new Date();  
                            $(\'#fecha_factura_'.$data->id_cirugia.'\').daterangepicker({
                                singleDatePicker: true,
                                calender_style: "picker_4",
                                dateFormat: \'dd-mm-yy\',
                                maxDate: end_date
                            }, function (start, end, label) {
                                console.log(start.toISOString(), end.toISOString(), label);
                            });
                        });
                        $(function(){               
                            //Para escribir solo numeros    
                            $(\'#monto_'.$data->id_cirugia.'\').validCampoFranz(\'0123456789\'); 
                        });                                              
                    ';
                }
                echo "</script>";
    ?>

{!! Form::close() !!}

    <!-- /page content -->
@include('layaout.footer_admin')