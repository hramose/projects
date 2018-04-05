<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\FoldersControllers;

?>

@include ('layaout.header_admin')

    <h2>Consulta de Pago</h2> <hr />
	
	<span class="msj">{{ Session::get("mensaje") }}</span>

{!! Form::open(array('url' => 'buscar_consultas_pagos_2', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}    
    <div class="item form-group">
        <label class="control-label col-md-2 col-sm-3 col-xs-3">Dias Alta:</label>
        <div class="col-md-2 col-sm-1 col-xs-1">
            <input type="number" name="dias_alta" class="form-control" placeholder="Dias de Alta" value="<?=$dias_alta?>" />
        </div>
        <label class="control-label col-md-3 col-sm-3 col-xs-3">Dias de Factura</label>
        <div class="col-md-2 col-sm-1 col-xs-1">
            <input required="required" id="dias_factura" name="dias_factura" type="number" maxlength="3" class="form-control" placeholder="Dias de Factura" value="<?=$dias_factura?>">
        </div>     
        <button id="send" type="submit" class="btn btn-success">Buscar</button>
    </div>   
{!! Form::close() !!}
    <!-- page content -->
        <div class="x_content">
            <span class="section">Informacion de las Clinicas</span>
            {{ PagosControllers::consulta_clinicas_2($dias_alta,$dias_factura) }}
        </div>
    <!-- /page content -->

    <!--DATE FORMAT-->

    <link rel="stylesheet" href="js/datepicker/jquery-ui.css">
    <!--script src="js/datepicker/jquery-1.10.2.js"></script-->
    <script src="js/datepicker/jquery-ui.js"></script>

    <script type="text/javascript">
        $(function() {
            $('input[name="fecha_alta"]').daterangepicker();
        });
    </script>      

@include ('layaout.footer_admin')