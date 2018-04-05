<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;
use App\Http\Controllers\CirugiaControllers;
use Session;
use DB;
use View;
use Form;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

$campo='id_tipo_atencion';
$valor=7;
$operador="=";

if ($consulta==1)
    $operador="!=";
elseif ($consulta==2)
    $operador="=";
else {
    $valor="null";
    $operador="!=";
}

if (strpos($fecha1,"/") !== false) {
    $fecha1=FuncionesControllers::fecha_mysql($fecha1);
    $fecha2=FuncionesControllers::fecha_mysql($fecha2);
}

$sql_fecha="";
$sql_alt="";

$sql_alt = 'select id from cirugias where ';

if ($fecha1!='0')
    $sql_fecha = ' and fecha_cirugia between \''.$fecha1.'\' and  \''.$fecha2.'\'';

if ($consulta==2)
    $sql_alt.=" id in (select id_cirugia from alta) ".$sql_fecha;
elseif ($consulta==1)
    $sql_alt.=" id not in (select id_cirugia from alta) ".$sql_fecha;
else
    $sql_alt.= substr($sql_fecha,5);

//echo "cedula=".$cedula;
//return;

$sql = "select
            paciente.nombres,paciente.apellidos,
            paciente.edad,paciente.cedula,
            cirugias.nro_historia,cirugias.cirujano,
            cirugias.id as id_cirugia,
            clinica_medico.nombre as clinica,
            cirugias.seguros,cirugias.nombre as diagnostico,
            cirugias.id_paciente, cirugias.id as id_cirugia, cirugias.id_clinica
        from
            paciente,cirugias,clinica_medico, cirugia_seguro 
        where
            cirugias.id_paciente=paciente.id and
            paciente.id_medico=".$id_medico." and
            clinica_medico.id_clinica = cirugias.id_clinica and 
            cirugias.id in ( ".$sql_alt." ) and
            cirugias.id_clinica is not null and
            cirugia_seguro.id_cirugia=cirugias.id        
        ";
        if ($id_clinica!=0)
            $sql.=" and cirugias.id_clinica=".$id_clinica;
        if ($id_seguro!=0)
            $sql.=" and cirugia_seguro.id_seguro=".$id_seguro;
        if ($indice==-1)
            $sql .= " and paciente.cedula='".$cedula."'";
        $sql.= " group by paciente.nombres,paciente.apellidos, paciente.edad,paciente.cedula, 
        cirugias.nro_historia,cirugias.cirujano, 
        cirugias.id, clinica_medico.nombre, 
        cirugias.seguros,cirugias.nombre, cirugias.id_paciente, 
        cirugias.id, cirugias.id_clinica order by cirugias.id";
    //echo $sql;
    //echo "<h1>clinica=$id_clinica</h1>";
    //echo "<h1>indice=$indice</h1>";
    //return;
    $data=DB::select($sql);
    $id_cirugia_array="";
    $i=0;
    $id_cirugia=0;
    $id_paciente=0;
    foreach ($data as $data) {
        if ($indice==-1) {
            $id_paciente=$data->id_paciente;
            $id_cirugia=$data->id_cirugia;
            $id_clinica=$data->id_clinica;

            $nombres=$data->nombres;
            $apellidos=$data->apellidos;
            $edad=$data->edad;
            $cedula=$data->cedula;
            $nro_historia=$data->nro_historia;
            $clinica=$data->clinica;
            $seguros=$data->seguros;     
            $diagnostico=$data->diagnostico;               
        } else {
            if ($data->id_cirugia!=null) {
                if ($i==$indice) {
                    $id_paciente=$data->id_paciente;
                    $id_cirugia=$data->id_cirugia;
                    $id_clinica=$data->id_clinica;

                    $nombres=$data->nombres;
                    $apellidos=$data->apellidos;
                    $edad=$data->edad;
                    $cedula=$data->cedula;
                    $nro_historia=$data->nro_historia;
                    $clinica=$data->clinica;
                    $seguros=$data->seguros;     
                    $diagnostico=$data->diagnostico;
                    $id_cirugia_array[$indice]=$data->id_cirugia;                
                }
                $i++;
            }
        }
    }    

    //echo "id=".$id_paciente;
    //return;

    if ($indice>-1)
        $id_cirugia=$id_cirugia_array[$indice];

    //print_r ($id_cirugia_array);

    $sql = "select sum(monto) as monto from datos_cirugia where id_cirugia=".$id_cirugia;
    $data = DB::select($sql);
    foreach ($data as $data)
        $monto_total=$data->monto;

?>

@include('layaout.header_admin')
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
        $fecha=Session::get('fecha');
        $fecha=FuncionesControllers::fecha_normal($fecha);
        $fecha=str_replace("/", "-", $fecha);
    ?>

    <div class="form-group" align="center">
        <button id="send" type="button" onclick="location.href='consulta_cirugia'" class="btn btn-success">Regresar</button>
        <?php if (FuncionesControllers::verificar_alta($id_cirugia)==1) { ?>
        <button id="send" type="button" onclick="ver_consulta_4(<?php echo $id_cirugia; ?>)" class="btn btn-success">Agregar Cirugia</button>
        <?php } ?>
        <?php if (FuncionesControllers::verificar_alta($id_cirugia) == 1) { ?>
            <!--button id="send" type="button" onclick="ver_consulta_5(<?php echo $id_cirugia; ?>)" class="btn btn-success">Dar de alta</button-->

            <!-- Small modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Dar de alta</button>

            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form name="forma2" method="post" action="">
                            <input type="hidden" name="id_cirugia" value="<?=$id_cirugia?>" />
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title" id="myModalLabel2">Fecha de Alta</h4>
                            </div>                        

                            <div class="modal-body">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input readonly value="{{ $fecha }}" data-inputmask="\'mask\': \'99/99/9999\'" id="fecha_alta" name="fecha_alta" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                                    <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                                </div>    
                                <button onclick="ver_consulta_5(<?php echo $id_cirugia; ?>)" type="button" class="btn btn-primary">Dar de alta</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- /modals -->
        <?php } ?>
    </div>  

    {{ FuncionesControllers::verificar_estatus_paciente($id_paciente, $id_clinica, $id_cirugia) }}

            <h3>Paciente</h3>
            <table id="example2" class="display responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>                    
                        <th>Paciente</th>
                        <th>Edad</th>
                        <th>Cedula</th>
                        <th>Nro Historia</th>
                        <th>Diagnostico</th>
                        <th>Clinica</th>
                        <th>Seguro(s)</th>
                        <th>Monto Total</th>
                    </tr>
                <tbody>
                    <tr>
                        <td><?php echo strtoupper($nombres. " " .$apellidos); ?></td>
                        <td><?php echo $edad; ?></td>
                        <td><?php echo $cedula; ?></td>
                        <td><?php echo $nro_historia; ?></td>
                        <td><?php echo $diagnostico; ?></td>
                        <td><?php echo $clinica; ?></td>
                        <td><?php echo $seguros; ?></td>
                        <td><strong><span class="msj">Bs. <?php echo number_format($monto_total,2,",","."); ?></span></strong></td>
                    </tr>
                </tbody>                    
                </thead>
            </table>

            <div class="ln_solid"></div>
    
    <!--****************************OTROS TIPOS DE ATENCION**************************-->
    
    <h3>Tipo Atencion - Otros</h3>
    <script type="text/javascript" language="javascript" class="init">    
        var editor; // use a global for the submit and return data rendering in the examples
        var id_cirugia=<?php echo $id_cirugia; ?>;
        $(document).ready(function() {
            editor = new $.fn.dataTable.Editor( {
                ajax: "editor/php/join.php?format=custom&id_medico=<?php echo $id_medico; ?>&fecha1=<?php echo $fecha1; ?>&fecha2=<?php echo $fecha2; ?>&consulta=<?php echo $consulta; ?>&id_cirugia=<?php echo $id_cirugia; ?>",
                table: "#example_otros",
                language: {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },                  
                fields: [
                    {
                        label: "id_cirugia",
                        name: "datos_cirugia.id_cirugia",
                        def: id_cirugia,
                        type: "hidden"
                    }, {
                        label: "Tipo Atencion",
                        name: "datos_cirugia.id_tipo_atencion",
                        type: "select"                        
                    }, {
                        label: "Monto (Tipo Atencion)",
                        name: "datos_cirugia.monto"
                    },{
                        label: "Fecha Atencion",
                        name: "datos_cirugia.fecha_carga",
                        type:   'datetime',
                        def:    function () { return new Date(); },
                        format: 'YYYY-MM-DD',
                        fieldInfo: 'Formato AAAA-MM-DD'             
                    }, {
                        label: "Observacion",
                        name: "datos_cirugia.observaciones"
                    }
                ],
                ajaxUrl: "index",
                i18n: {
                    create: {
                        button: "Crear",
                        title:  "Crear",
                        submit: "Crear"
                    },
                    edit: {
                        button: "Modificar",
                        title:  "Modificar",
                        submit: "Modificar"
                    },
                    remove: {
                        button: "Suprimir",
                        title:  "Suprimir",
                        submit: "Suprimir",
                        confirm: {
                            _: "¿Seguro que desea eliminar este registro?",
                            1: "¿Seguro que desea eliminar este registro?"
                        }
                    }
                }                      
            } );


            // Activate an inline edit on click of a table cell
            /*$('#example_otros').on( 'click', 'tbody td.editable', function (e) {
                editor.inline( this );
            } );*/

            // Despues de submit
            $('#example_otros').on( 'postCreate', function ( e, json, data ) {
                alert( 'Nuevo registro insertado' );
            } );              

            $('#example_otros').DataTable( {
                language: {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: "Bfrtip",
                ajax: "editor/php/join.php?format=custom&id_medico=<?php echo $id_medico; ?>&fecha1=<?php echo $fecha1; ?>&fecha2=<?php echo $fecha2; ?>&consulta=<?php echo $consulta; ?>&id_cirugia=<?php echo $id_cirugia; ?>",
                columns: [
                    { 
                        data: "tipos_atencion.nombre", 
                        editField: "datos_cirugia.id_tipo_atencion"
                    },
                    { data: "datos_cirugia.monto", render: $.fn.dataTable.render.number( '.', ',', 2, 'Bs ' ) },
                    { data: "datos_cirugia.fecha_carga" },
                    { data: "datos_cirugia.observaciones" }
                ],
                select: true,                
                buttons: [
                    <?php if (FuncionesControllers::verificar_alta($id_cirugia)==1) { ?>
                    { extend: "create", editor: editor },
                    { extend: "edit",   editor: editor },
                    { extend: "remove", editor: editor }
                    <?php } ?>
                ]                
            } );
        } );
    </script>

    <div class="container_otros">
            <table id="example_otros" class="display responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>                    
                        <th>Tipo <br />Atencion</th>
                        <th>Monto <br />(Tipo Atencion)</th>
                        <th>Fecha <br />Atencion</th>                  
                        <th>Observacion</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>     
                        <th>Tipo<br />Atencion</th>
                        <th>Monto <br />(Tipo Atencion)</th>
                        <th>Fecha <br />Atencion</th>                     
                        <th>Observacion</th> 
                    </tr>
                </tfoot>
            </table>         
    </div>

    <!--****************************TIPOS DE ATENCION - CIRUGIAS**************************-->            
    <form name="forma1" method="post" action="">

            <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>                    
                        <th>Tipo Atencion</th>
                        <th>Rol</th>
                        <th>Monto Rol</th>
                        <th>Monto Tipo Atencion</th>
                        <th>Fecha Atencion</th>
                        <th>Observaciones</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>   

<?php
        $sql = "select cirugias.id,datos_cirugia.tipo_atencion,cirugias.nombre,
                        medico_cirugia.rol,medico_cirugia.monto as monto_rol,
                        datos_cirugia.fecha_carga,datos_cirugia.fecha_alta,
                        cirugias.seguros,clinica_medico.nombre,
                        datos_cirugia.monto as monto_total, datos_cirugia.observaciones,
                        datos_cirugia.id as id_datos_cirugia
                
                from cirugias

                Left JOIN datos_cirugia on datos_cirugia.id_cirugia=cirugias.id
                Left JOIN medico_cirugia on medico_cirugia.id_cirugia=cirugias.id and medico_cirugia.rol!=''
                Left JOIN clinica_medico on clinica_medico.id_clinica=cirugias.id_clinica

                where datos_cirugia.id_cirugia=".$id_cirugia." and datos_cirugia.id_tipo_atencion=3 and
                    medico_cirugia.id_datos_cirugia=datos_cirugia.id

                group by cirugias.id,datos_cirugia.tipo_atencion,cirugias.nombre,
                        medico_cirugia.rol,medico_cirugia.monto,
                        datos_cirugia.fecha_carga,datos_cirugia.fecha_alta,
                        cirugias.seguros,clinica_medico.nombre";
        //echo $sql;
        //return;
        $data = DB::select($sql);
        foreach ($data as $data) {
        ?>               
        <tr>
            <td><?php echo $data->tipo_atencion; ?></td>
            <td><?php echo $data->rol; ?></td>
            <td><?php echo str_replace(",", " / ", $data->monto_rol); ?></td>
            <td><?php echo "Bs. ". number_format($data->monto_total,2,",","."); ?></td>
            <td><?php echo FuncionesControllers::fecha_normal($data->fecha_carga); ?></td>
            <td><?php echo $data->observaciones; ?></td>
            <td><a href=consultarcirugia/<?php echo $data->id_datos_cirugia ?>><button class="btn btn-default" type="button">Consultar</button></a></td>
            <td><a href=eliminarcirugia/<?php echo $data->id_datos_cirugia ?>><button class="btn btn-default" type="button">Eliminar</button></a></td>
        </tr>
        <?php } ?>
                </tbody>
                </thead>
            </table>           

        <div class="form-group" align="center">
            <button id="send" type="button" onclick="location.href='consulta_cirugia'" class="btn btn-success">Regresar</button>
            <?php if (FuncionesControllers::verificar_alta($id_cirugia)==1) { ?>
            <button id="send" type="button" onclick="ver_consulta_4(<?php echo $id_cirugia; ?>)" class="btn btn-success">Agregar Cirugia</button>
            <?php } ?>
        <?php if (FuncionesControllers::verificar_alta($id_cirugia) == 1) { ?>
            <!--button id="send" type="button" onclick="ver_consulta_5(<?php echo $id_cirugia; ?>)" class="btn btn-success">Dar de alta</button-->

            <!-- Small modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Dar de alta</button>
            <!-- /modals -->
        <?php } ?>
        </div>
    </form>

    <!--script src="{{ URL::asset('js/datepicker/jquery-1.10.2.js') }}"></script-->
    <script src="{{ URL::asset('js/datepicker/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('js/datepicker/jquery-ui.css') }}">

    <?php
        $sql="select fecha_cirugia from cirugias where id=".$id_cirugia;
        $data=DB::select($sql);
        foreach ($data as $data)
            $fecha_cirugia=$data->fecha_cirugia;
        $fecha_cirugia=FuncionesControllers::fecha_normal($fecha_cirugia);
        $fecha_cirugia=str_replace("/", "-", $fecha_cirugia);
    ?>

    <script type="text/javascript">
        $(function() {
            var start_date = new Date ('1910-01-01');
            var end_date = new Date();       
            $("#fecha_alta").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy',
                minDate: '<?=$fecha_cirugia?>',
                maxDate: end_date
            }); 
        });
    </script>    

    <!-- /page content -->
@include('layaout.footer_admin')