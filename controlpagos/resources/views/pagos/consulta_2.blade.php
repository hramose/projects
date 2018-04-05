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

{!! Form::open(array('url' => 'consulta_pago_2', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
    <?php
    if (strpos($fecha1,"-") !== false) {
        $fecha1=FuncionesControllers::fecha_normal($fecha1);
        $fecha2=FuncionesControllers::fecha_normal($fecha2);
    }
    ?>
    @include('pagos.consulta')

    <script src="datatables/js/jquery.dataTables.min.js"></script> 
    <link rel="stylesheet" href="datatables/css/jquery.dataTables.min.css">
    
    <!--CLASES-->
    
    <script src="datatables/js/dataTables.buttons.min.js"></script>
    <script src="datatables/js/buttons.flash.min.js"></script>
    <script src="datatables/js/jszip.min.js"></script>
    <script src="datatables/js/pdfmake.min.js"></script>
    <script src="datatables/js/vfs_fonts.js"></script>
    <script src="datatables/js/buttons.html5.min.js"></script>
    <script src="datatables/js/buttons.print.min.js"></script>
    
    <link rel="stylesheet" href="datatables/css/buttons.dataTables.min.css">

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example_otros').DataTable({
                    dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            $('#example_cirugia').DataTable({
                    dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });            
        //});
            
            $('input.global_filter').on( 'keyup click', function () {
                filterGlobal();
            } );
         
            $('input.column_filter').on( 'keyup click', function () {
                filterColumn( $(this).parents('tr').attr('data-column') );
            });
        });    
    </script>

    <!-- page content -->
    <div class="x_content">
        <hr style="border-color:#000" />
        {{ FuncionesControllers::crear_tabla_consulta_pagos($fecha1, $fecha2, "otros", $consulta, $id_clinica) }}
        <hr style="border-color:#000" />
        <!--h2><strong>Tipo Atencion: Cirugias por Casos</strong></h2>
        {{ FuncionesControllers::crear_tabla_consulta_pagos($fecha1, $fecha2, "cirugia", $consulta, $id_clinica) }}
        -->
    </div>

{!! Form::close() !!} 

@include('layaout.footer_admin')