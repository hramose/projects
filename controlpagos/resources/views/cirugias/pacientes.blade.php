<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;
use App\Http\Controllers\CirugiaControllers;
use Session;
use DB;
use View;
use Form;
use Illuminate\Support\Facades\URL;

if ($consulta==1) $estatus="ACTIVO";
elseif ($consulta==2) $estatus="ALTA";
else $estatus="";

$sql = "select sum(dc.monto) as monto, dc.id_cirugia
        from datos_cirugia dc, cirugias c";
        if ($id_seguro>0)
            $sql .= ", cirugia_seguro cs ";
        $sql .= " where c.id_medico=".Session::get("id_medico")." and c.id=dc.id_cirugia ";

        if ($id_clinica>0)
            $sql .= " and c.id_clinica=".$id_clinica;
        if ($id_seguro>0)
            $sql .= " and cs.id_cirugia=c.id and cs.id_seguro=".$id_seguro;

        $sql .= " group by dc.id_cirugia";
$data = DB::select($sql);

foreach ($data as $data) {
    $sql = "update cirugias set monto='".$data->monto."' where id=".$data->id_cirugia;
    DB::update($sql);
}

FuncionesControllers::actualizar_rol();

if (strpos($fecha1,"-") !== false) {
    $fecha1=FuncionesControllers::fecha_normal($fecha1);
    $fecha2=FuncionesControllers::fecha_normal($fecha2);
}

?>

@include('layaout.header_admin')

<style type="text/css">
    td.highlight {
        font-weight: bold;
        color: blue;
    }
</style>

{!! Form::open(array('url' => 'consulta_cirugia_2', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
    <input type="hidden" name="indice" value="-1" />

    @include('cirugias.consulta')

    <div class="form-group" align="center">
        <button id="send" type="button" onclick="history.go(-1)" class="btn btn-success">Regresar</button>
        <button id="send" type="button" onclick="ver_consulta_3(<?php echo $id_medico; ?>,'<?php echo $fecha1; ?>','<?php echo $fecha2; ?>',<?php echo $consulta; ?>)" class="btn btn-success">Detalle Casos</button>
    </div>    

    <!-- page content -->

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.1.2/css/select.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('editor/css/editor.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('editor/resources/syntax/shCore.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('editor/resources/demo.css') }}">
    <style type="text/css" class="init">
    
    td.editable {
        font-weight: bold;
    }

    </style>
    <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.0.2/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{ URL::asset('editor/js/dataTables.editor.min.js') }}"></script>
    <script type="text/javascript" language="javascript" src="{{ URL::asset('editor/resources/syntax/shCore.js') }}"></script>
    <script type="text/javascript" language="javascript" src="{{ URL::asset('editor/resources/demo.js') }}"></script>
    <script type="text/javascript" language="javascript" src="{{ URL::asset('editor/resources/editor-demo.js') }}"></script>
    <script type="text/javascript" language="javascript" class="init"></script>
    <?php
    if (strpos($fecha1,"/") !== false) {
        $fecha1=FuncionesControllers::fecha_mysql($fecha1);
        $fecha2=FuncionesControllers::fecha_mysql($fecha2);
    }
?>
    <script type="text/javascript" language="javascript" class="init">
        var editor; // use a global for the submit and return data rendering in the examples
        $(document).ready(function() {
            editor = new $.fn.dataTable.Editor( {
                ajax: "editor/php/pacientes.php?format=custom&id_medico=<?php echo $id_medico; ?>&fecha1=<?php echo $fecha1; ?>&fecha2=<?php echo $fecha2; ?>&consulta=<?php echo $consulta; ?>&id_clinica=<?php echo $id_clinica; ?>&id_seguro=<?php echo $id_seguro; ?>",
                table: "#example",
                fields: [
                    {
                        label: "Nombres Paciente:",
                        name: "paciente.nombres"
                    }, {
                        label: "Apellidos Paciente:",
                        name: "paciente.apellidos"
                    }, {
                        label: "Edad:",
                        name: "paciente.edad"
                    }, {
                        label: "Cedula:",
                        name: "paciente.cedula"
                    }
                ], 
                i18n: {
                    edit: {
                        button: "Editar Paciente",
                        title:  "Editar Paciente",
                        submit: "Actualizar Paciente"
                    }
                }              
            } );

            // Activate an inline edit on click of a table cell
            $('#example').on( 'click', 'tbody td.editable', function (e) {
                editor.inline( this );
            } );

            $('#example').DataTable( {
                language: {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: "Bfrtip",
                ajax: "editor/php/pacientes.php?format=custom&id_medico=<?php echo $id_medico; ?>&fecha1=<?php echo $fecha1; ?>&fecha2=<?php echo $fecha2; ?>&consulta=<?php echo $consulta; ?>&id_clinica=<?php echo $id_clinica; ?>&id_seguro=<?php echo $id_seguro; ?>",
                columns: [
                    {
                        data: null,
                        defaultContent: '',
                        className: 'select-checkbox',
                        orderable: false,
                        name: "cirugias.id"
                    },                
                    { data: "paciente.nombres", width: "10%" },
                    { data: "paciente.apellidos", width: "10%" },
                    { data: "paciente.edad", width: "4%" },
                    { data: "paciente.cedula", width: "6%" },
                    { data: "cirugias.nombre", width: "35%" },
                    { data: "cirugias.fecha_cirugia", width: "5%" },
                    { data: "clinica_medico.nombre", width: "10%" },
                    { data: "cirugias.seguros", width: "10%" },
                    { data: "cirugias.monto", render: $.fn.dataTable.render.number( '.', ',', 2, 'Bs. ' ), width: "5%"  },
                    { data: null, defaultContent: '<?php echo $estatus; ?>', orderable: false }                  
                ],
                select: {
                    style:    'os',
                    selector: 'td:first-child'
                },
                createdRow:
                    function ( row, data, index ) {
                        $('td', row).eq(9).addClass('highlight');
                    },
                buttons: [
                    //{ extend: "create", editor: editor },                 
                    { extend: "edit", editor: editor },
                    //{ extend: "remove", editor: editor }
                ],
                order: [[ 5, "desc" ]],
                iDisplayLength: 10,
            } );
            $('#example tbody').on( 'click', 'tr', function () {
                var table = $('#example').DataTable();
                 
                var rows = table.rows( '.selected' ).indexes();
                var data = table.rows( rows ).data();
                var f=eval("document.forms[0]");
                if (table.row( this ).index()==0)
                    f.indice.value=0;
                else
                    f.indice.value=table.row( this ).index();
                //alert("1) Indice 1:"+f.indice.value);
                //alert( 'Row index: '+table.row( this ).index() );
                //alert("2) Indice 2:"+f.indice.value);
            } );

        } );
    </script>

    <div class="container">
            <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
                <thead>

                    <tr>
                        <th></th>                         
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Edad</th>
                        <th>CI</th>                      
                        <th>Diagnostico</th> 
                        <th>Fecha Diagnostico</th> 
                        <th>Clinica</th>
                        <th>Seguro</th>
                        <th>Monto</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Edad</th>
                        <th>CI</th>                      
                        <th>Diagnostico</th> 
                        <th>Fecha Diagnostico</th> 
                        <th>Clinica</th>
                        <th>Seguro</th>
                        <th>Monto</th>
                        <th>Estatus</th>
                    </tr>
                </tfoot>
            </table>
            <div class="form-group" align="center">
                <button id="send" type="button" onclick="history.go(-1)" class="btn btn-success">Regresar</button>
                <button id="send" type="button" onclick="ver_consulta_3(<?php echo $id_medico; ?>,'<?php echo $fecha1; ?>','<?php echo $fecha2; ?>',<?php echo $consulta; ?>)" class="btn btn-success">Detalle Casos</button>
            </div>            
    </div>
{!! Form::close() !!} 
    <!-- /page content -->
@include('layaout.footer_admin')

