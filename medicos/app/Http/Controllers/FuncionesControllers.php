<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Redirect;

class FuncionesControllers extends Controller
{

    /**
     * Display a listing of the resource.
     * GET /periodicos
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * GET /periodicos/create
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    public static function find_iduser($user) {
        $sql = "select * from medico where email='$user'";
        $data = DB::select($sql);
        foreach ($data as $data)
            return $data->id;
    }    

    public static function buscar_dato($table,$field) {
        $sql = "select ".$field." as field from ".$table;
        $data = DB::select($sql);
        foreach ($data as $data)
            return $data->field;
    }

    public static function crear_combo($tabla, $valor) {
        $sql = "select * from ".$tabla." order by nombre";
        $data = DB::select($sql);
        $res="";
        foreach ($data as $data) {
            if ($valor == $data->id)
                $res .= "<option value=".$data->id." selected>".$data->nombre."</option>";
            else
                $res .= "<option value=".$data->id.">".$data->nombre."</option>";
        }
        echo $res;
    }

    public static function crear_combo_maestro($tabla, $valor) {
        $sql = "select * from maestro where padre='".$tabla."' order by id_campo";
        $data = DB::select($sql);
        $res="";
        foreach ($data as $data) {
            if ($valor == $data->id_campo)
                $res .= "<option value=".$data->id_campo." selected>".$data->campo."</option>";
            else
                $res .= "<option value=".$data->id_campo.">".$data->campo."</option>";
        }
        echo $res;
    }    
    
    public static function datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo) {
        $strDatatable="";

        $strDatatable.="<script type=\"text/javascript\">";
        $strDatatable.="$(document).ready(function() {";
        $strDatatable.="var dataSet = ".$strDatos.";";
        $strDatatable.="$('#".$strTabla."').DataTable( {";
        $strDatatable.="initComplete: function () {";
        $strDatatable.="this.api().columns().every( function () {";
        $strDatatable.="var column = this;";
        $strDatatable.="var select = $('<select><option value=\"\"></option></select>')";
        $strDatatable.=".appendTo( $(column.footer()).empty() )";
        $strDatatable.=".on( 'change', function () {";
        $strDatatable.="var val = $.fn.dataTable.util.escapeRegex(";
        $strDatatable.="$(this).val() );";
        $strDatatable.="column";
        $strDatatable.=".search( val ? '^'+val+'$' : '', true, false )";
        $strDatatable.=".draw();";
        $strDatatable.="} );";
        $strDatatable.="column.data().unique().sort().each( function ( d, j ) {";
        $strDatatable.="select.append( '<option value=\"'+d+'\">'+d+'</option>' )";
        $strDatatable.="} );";
        $strDatatable.="} );";
        $strDatatable.="},";
        $strDatatable.="data: dataSet,";
        $strDatatable.="columns: [";
        $strDatatable.=$strColumnas;
        $strDatatable.="],";
        $strDatatable.="order: [".$strOrden."],";
        $strDatatable.="iDisplayLength: ".$intCantidad.",";
        $strDatatable.="dom: 'Bfrtip',";
        $strDatatable.="buttons: [";

        if (strpos($strOpciones,'copy') !== false) {
            $strDatatable.="{";
            $strDatatable.="extend:'copy',";
            $strDatatable.="text:'<i class=\"fa fa-3x fa-files-o\"></i>',";
            $strDatatable.="titleAttr: 'Copiar',";
            $strDatatable.="title:'".$strNombreArchivo."'";
            $strDatatable.="},";
        }

        if (strpos($strOpciones,'csv') !== false) {
            $strDatatable.="{";
            $strDatatable.="extend:'csv',";
            $strDatatable.="text:'<i class=\"fa fa-3x fa-file-text-o\"></i>',";
            $strDatatable.="titleAttr: 'Archivo CSV',";
            $strDatatable.="title:'".$strNombreArchivo."'";
            $strDatatable.="},";
        }
        
        if (strpos($strOpciones,'excel') !== false) {
            $strDatatable.="{";
            $strDatatable.="extend:'excel',";
            $strDatatable.="text:'<i class=\"fa fa-3x fa-file-excel-o\"></i>',";
            $strDatatable.="titleAttr: 'Excel',";
            $strDatatable.="title:'".$strNombreArchivo."'";
            $strDatatable.="},";
        }

        if (strpos($strOpciones,'pdf') !== false) {
            $strDatatable.="{";
            $strDatatable.="extend:'pdf',";
            $strDatatable.="text:'<i class=\"fa fa-3x fa-file-pdf-o\"></i>',";
            $strDatatable.="titleAttr: 'PDF',";
            $strDatatable.="title:'".$strNombreArchivo."'";
            $strDatatable.="},";
        }

        if (strpos($strOpciones,'print') !== false) {
            $strDatatable.="{";
            $strDatatable.="extend:'print',";
            $strDatatable.="text:'<i class=\"fa fa-3x fa-print\"></i>',";
            $strDatatable.="titleAttr: 'Imprimir',";
            $strDatatable.="title:'".$strNombreArchivo."'";
            $strDatatable.="},";
        }

        if (strpos($strOpciones,'colvis') !== false) {
            $strDatatable.="{";
            $strDatatable.="extend:'colvis',";
            $strDatatable.="text:'<i class=\"fa fa-3x fa-eye\"></i>',";
            $strDatatable.="titleAttr: 'Visibilidad de Columna',";
            $strDatatable.="}";
        }

        $strDatatable.="]";
        $strDatatable.="} );";
        $strDatatable.="} );";
        $strDatatable.="</script>";
        
        $strDatatable.="</div>";

        $strDatatable.="<table id=\"".$strTabla."\" class=\"display\" width=\"100%\">";
        $strDatatable.="<tfoot>";
        $strDatatable.="<tr>";
        $strDatatable.=$strtfoot;
        $strDatatable.="</tr>";
        $strDatatable.="</tfoot>";
        $strDatatable.="</table>";
        $strDatatable.="<script type=\"text/javascript\">";
        $strDatatable.="$('#".$strTabla."')";
        $strDatatable.=".removeClass('display')";
        $strDatatable.=".addClass('table table-striped table-bordered');";
        $strDatatable.="</script>";

        echo $strDatatable;
    }
}