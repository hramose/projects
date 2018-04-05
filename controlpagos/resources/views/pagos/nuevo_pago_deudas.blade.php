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

<input type="hidden" name="id" value="<?=$id?>" />
{!! Form::open(array('url' => 'buscar_consultas_pagos', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}    
    <div class="item form-group">
        <label class="control-label col-md-2 col-sm-3 col-xs-3">Fecha de alta:</label>
        <div class="col-md-3 col-sm-3 col-xs-3">
            <input readonly type="text" name="fecha_alta" required="required" class="form-control" placeholder="Fecha de Alta" value="<?php echo $fecha1; ?> - <?php echo $fecha2; ?>" />
            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
        </div>
        <button id="send" type="submit" class="btn btn-success">Buscar</button>
    </div>   
{!! Form::close() !!}
    <!-- page content -->
        <div class="x_content">
            <span class="section">Informacion de las Clinicas</span>
            <?php
                $fecha1=FuncionesControllers::fecha_mysql($fecha1);
                $fecha2=FuncionesControllers::fecha_mysql($fecha2);
            ?>
            {{ PagosControllers::consulta_clinicas($fecha1,$fecha2) }}
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