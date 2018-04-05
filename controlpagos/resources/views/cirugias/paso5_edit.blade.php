<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>
    <!--script src="../datatables/js/jquery-1.12.0.min.js"></script-->
    <script src="../datatables/js/jquery.dataTables.min.js"></script> 
    <link rel="stylesheet" href="../datatables/css/jquery.dataTables.min.css">
    
    <!--CLASES-->
    
    <script src="../datatables/js/dataTables.buttons.min.js"></script>
    <script src="../datatables/js/buttons.flash.min.js"></script>
    <script src="../datatables/js/jszip.min.js"></script>
    <script src="../datatables/js/pdfmake.min.js"></script>
    <script src="../datatables/js/vfs_fonts.js"></script>
    <script src="../datatables/js/buttons.html5.min.js"></script>
    <script src="../datatables/js/buttons.print.min.js"></script>
    
    <link rel="stylesheet" href="../datatables/css/buttons.dataTables.min.css">

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({
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
            } );
        } );    
    </script>
<div id="step-5">
    <h2 class="StepTitle">Datos Cirugia</h2>

    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de Carga / Alta<span class="msj">(*)</span></label>
        <div class="col-xs-3">
            <input readonly value="{{  Session::get('fecha') }}" data-inputmask="'mask': '99/99/9999'" id="fecha_carga_edit" name="fecha_carga_edit" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
        </div>
        <div class="col-xs-3">
            <input readonly data-inputmask="'mask': '99/99/9999'" id="fecha_alta_edit" name="fecha_alta_edit" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
        </div>                
    </div>   
       
    <div class="item form-group">
        <label class="control-label col-xs-3">Observaciones / Referencia:</label>
        <div class="col-xs-3">
            <textarea id="observaciones" name="observaciones" class="form-control"></textarea>
        </div>
        <div class="col-xs-3">
            <textarea id="referencias" name="referencias" class="form-control"></textarea>
        </div>
    </div> 
    <div class="item form-group">
        <label class="control-label col-xs-3">Habitacion</label>
        <div class="col-xs-3">
            <input id="habitacion" name="habitacion" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Habitacion" value="">
        </div>
    </div>
    <br />
    <div align="center"><input type="button" class="btn btn-primary" value="Guardar Detalle" onclick="guardar_detalle(<?=$id?>)" /></div>
    <br />
    <div id="datos_tabla">
        <?php echo FuncionesControllers::crear_tabla_detalle_cirugia($id); ?>
    </div>
</div>