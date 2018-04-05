<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Redirect;
use App\datos_cirugia;
use Mail;
use App\usuarios;
use DateTime;

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


    public static function buscar_tipo_medico($id) {
        $sql = "select m.campo as tipo_medico from maestro m, medico med where m.padre='tipo_medico' and m.id_campo=med.id_tipo_medico";
        $data = DB::select($sql);
        foreach ($data as $data)
            return $data->tipo_medico;
    }

    public static function crear_combo($tabla, $valor) {
        $sql = "select * from ".$tabla." order by nombre";
        $data = DB::select($sql);
        $res="";
        foreach ($data as $data) {
            if (strpos($valor, $data->id.",") !== false)
                $res .= "<option value=".$data->id." selected>".$data->nombre."</option>";
            elseif ($valor==$data->id)
                $res .= "<option value=".$data->id." selected>".$data->nombre."</option>";
            else
                $res .= "<option value=".$data->id.">".$data->nombre."</option>";
        }
        echo $res;
    }    

    public static function crear_combo_moneda($tabla, $valor) {
        $sql = "select * from ".$tabla." order by tipo";
        $data = DB::select($sql);
        $res="";
        foreach ($data as $data) {
            if ($data->tipo=='VEF')
                $res .= "<option value=".$data->id." selected>".$data->tipo."</option>";
            else
                $res .= "<option value=".$data->id.">".$data->tipo."</option>";
        }
        echo $res;
    }

    public static function buscar_monto_rol($id_rol, $id_datos_cirugia) {
        $sql = "select monto, id_rol from medico_cirugia where id_datos_cirugia=".$id_datos_cirugia;
        $data = DB::select($sql);
        $rol_monto="";
        $rol="";
        $monto="";
        foreach ($data as $data) {
            $rol=$data->id_rol;
            $monto=$data->monto;
        }
        
        $rol=explode(",", $rol);
        $monto=explode(",", $monto);
        
        for ($i=0; $i<count($rol);$i++)
            if ($rol[$i]==$id_rol)
                $rol_monto[$rol[$i]]=$monto[$i];

        //echo "<pre>";
        //print_r ($rol_monto);
        //echo "</pre>";
        //echo "id_rolo=".$id_rol;
        //return;
        if (isset($rol_monto[$id_rol]))
            return $rol_monto[$id_rol];
        else
            return 0;
    }

    public static function opciones_check ($tabla, $valor, $id_datos_cirugia) {
        $sql = "select * from maestro where padre='".$tabla."' order by id_campo";
        $clase=array("primary", "success", "info", "warning", "danger");
        $data = DB::select($sql);
        $res="";
        $selected="";
        $i=0;
        $valor=explode(",",$valor);
        if ($tabla=="rol") $res .= '<table border=0 width="100%">';
        foreach ($data as $data) {
            if (in_array($data->id_campo,$valor))
                $selected="checked";
            else
                $selected="";
            if ($tabla=="rol") $res .= '<tr><td>';
            $res .= '<div class="checkbox checkbox-'.$clase[$i].'">';
            if ($tabla=="rol")
                $res .= '<input onclick="validar_monto('.$data->id_campo.', \''.Session::get("nombre").'\')" value="'.$data->campo.'" id="'.$tabla.'_'.$data->id_campo.'" name="'.$tabla.'_'.$data->id_campo.'" class="styled" type="checkbox" '.$selected.'>';
            else
                $res .= '<input value="'.$data->id_campo.'" id="'.$tabla.'_'.$data->id_campo.'" name="'.$tabla.'_'.$data->id_campo.'" class="styled" type="checkbox" '.$selected.'>';
            $res.='<label for="tipo_recepcion_'.$data->id_campo.'">'.$data->campo.'</label>';        
            $res .= '</div>';

            if ($tabla=="rol") {
                if (self::buscar_monto_rol($data->id_campo, $id_datos_cirugia)>0) {
                    $disabled="";
                } else {
                    $disabled="disabled";
                }
                $res .= '</td><td><input data-validate-minmax="1,999999999" maxlength="11" onblur="sumar_monto(this)" '.$disabled.' placeholder="Monto '.$data->campo.'" type="text" class="form-control" name="monto_'.$data->id_campo.'" id="monto_'.$data->id_campo.'" value="'.self::buscar_monto_rol($data->id_campo, $id_datos_cirugia).'">
                        <script type="text/javascript">$(\'#monto_'.$data->id_campo.'\').priceFormat();</script>
                    </td></tr>';
            }
            $i++;
            if ($i==count($clase))
                $i=0;
        }
        if ($tabla=="rol") {            
            $res .= '</table>';
            return $res;
        } else
            echo $res;
    }

    public static function opciones_radio ($tabla, $valor) {
        $sql = "select * from maestro where padre='".$tabla."' ";
        if ($tabla=="tipo_atencion")
            $sql .= " and campo!='ALTA' and campo!='REVISTA' ";
        $sql .= "order by id_campo";
        $clase=array("primary", "success", "info", "warning", "danger");
        $data = DB::select($sql);
        $res="";
        $selected="";
        $i=0;
        $valor=explode(",",$valor);
        $adicional="";
        foreach ($data as $data) {
            if (in_array($data->id_campo,$valor))
                $selected="checked";
            else
                $selected="";

            if ($tabla=="tipo_atencion")
                $adicional='onchange="mostrar_tipo_atencion(this.id)"';
            
            $res .= '
                <input type="radio" name="'.$tabla.'" id="'.$data->campo.'" value="'.$data->id_campo.'" '.$adicional.' /> '.$data->campo.'<br />
            ';
            $i++;
            if ($i==count($clase))
                $i=0;
        }
        if ($tabla=="tipo_atencion")
            $res .= '
                <input type="radio" name="'.$tabla.'" id="CIRUGIA" value="3" '.$adicional.' /> CIRUGIA<br />
            ';

        echo $res;
    }    

    public static function crear_combo_maestro($tabla, $valor) {
        $sql = "select * from maestro where padre='".$tabla."' order by id_campo";
        $data = DB::select($sql);
        $res="";
        foreach ($data as $data) {
            $adicional="";
            if ($tabla=="color") {
                $adicional="style='background: ".$data->campo."'";
            }
            if ($valor == $data->id_campo)
                $res .= "<option value=".$data->id_campo." selected $adicional>".$data->campo."</option>";
            else
                $res .= "<option value=".$data->id_campo." $adicional>".$data->campo."</option>";
        }
        echo $res;
    }    
    
    public static function datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo, $strFiltro="No") {
        $strDatatable="";

        $strDatatable.="<script type=\"text/javascript\">";
        $strDatatable.="$(document).ready(function() {";
        $strDatatable.="var dataSet = ".$strDatos.";";
        $strDatatable.="$('#".$strTabla."').DataTable( {";
        
        if (strpos($strFiltro,"No") === false) {
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
        }

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
            $strDatatable.="text:'<i class=\"fa fa-1x fa-files-o\"></i>',";
            $strDatatable.="titleAttr: 'Copiar',";
            $strDatatable.="title:'".$strNombreArchivo."'";
            $strDatatable.="},";
        }

        if (strpos($strOpciones,'csv') !== false) {
            $strDatatable.="{";
            $strDatatable.="extend:'csv',";
            $strDatatable.="text:'<i class=\"fa fa-1x fa-file-text-o\"></i>',";
            $strDatatable.="titleAttr: 'Archivo CSV',";
            $strDatatable.="title:'".$strNombreArchivo."'";
            $strDatatable.="},";
        }
        
        if (strpos($strOpciones,'excel') !== false) {
            $strDatatable.="{";
            $strDatatable.="extend:'excel',";
            $strDatatable.="text:'<i class=\"fa fa-1x fa-file-excel-o\"></i>',";
            $strDatatable.="titleAttr: 'Excel',";
            $strDatatable.="title:'".$strNombreArchivo."'";
            $strDatatable.="},";
        }

        if (strpos($strOpciones,'pdf') !== false) {
            $strDatatable.="{";
            $strDatatable.="extend:'pdf',";
            $strDatatable.="text:'<i class=\"fa fa-1x fa-file-pdf-o\"></i>',";
            $strDatatable.="titleAttr: 'PDF',";
            $strDatatable.="title:'".$strNombreArchivo."'";
            $strDatatable.="},";
        }

        if (strpos($strOpciones,'print') !== false) {
            $strDatatable.="{";
            $strDatatable.="extend:'print',";
            $strDatatable.="text:'<i class=\"fa fa-1x fa-print\"></i>',";
            $strDatatable.="titleAttr: 'Imprimir',";
            $strDatatable.="title:'".$strNombreArchivo."'";
            $strDatatable.="},";
        }

        if (strpos($strOpciones,'colvis') !== false) {
            $strDatatable.="{";
            $strDatatable.="extend:'colvis',";
            $strDatatable.="text:'<i class=\"fa fa-1x fa-eye\"></i>',";
            $strDatatable.="titleAttr: 'Visibilidad de Columna',";
            $strDatatable.="}";
        }

        $strDatatable.="]";
        $strDatatable.="} );";
        $strDatatable.="} );";
        $strDatatable.="</script>";
        
        $strDatatable.="</div>";

        $strDatatable.="<table id=\"".$strTabla."\" class=\"display\" width=\"100%\">";

        if (strpos($strFiltro,"No") === false) {
            $strDatatable.="<tfoot>";
            $strDatatable.="<tr>";
            $strDatatable.=$strtfoot;
            $strDatatable.="</tr>";
            $strDatatable.="</tfoot>";
        }
        $strDatatable.="</table>";
        $strDatatable.="<script type=\"text/javascript\">";
        $strDatatable.="$('#".$strTabla."')";
        $strDatatable.=".removeClass('display')";
        //$strDatatable.=".addClass('table table-striped table-bordered');";
        $strDatatable.=".addClass('table table-striped responsive-utilities jambo_table bulk_action');";
        $strDatatable.="</script>";

        echo $strDatatable;
    }

    public static function generarClave() {
        srand(self::crear_semilla());

        // Generamos la clave
        $clave="";
        $max_chars = round(rand(7,10));  // tendr&aacute; entre 7 y 10 caracteres
        $chars = array();
        for ($i="a"; $i<"z"; $i++) $chars[] = $i;  // creamos vector de letras
        $chars[] = "z";
        for ($i=0; $i<$max_chars; $i++) {
          $letra = round(rand(0, 1));  // primero escogemos entre letra y n&uacute;mero
          if ($letra) // es letra
             $clave .= $chars[round(rand(0, count($chars)-1))];
          else // es numero
             $clave .= round(rand(0, 9));
        }
        return $clave;
    }

    // Creamos la semilla para la funci&oacute;n rand()
    public static function crear_semilla() {
        list($usec, $sec) = explode(' ', microtime());
        return (float) $sec + ((float) $usec * 100000);
    }

    public static function enviar_email($tipo,$data,$asunto,$email,$adicional) {        
        //$data->adicional=$adicional;
        $confirmation_code = str_random(30);
        Mail::send('correo.'.$tipo, $data, function($message) use ($email, $asunto)
        {
            $message->to($email, $data->nombres." ".$data->apellidos)->subject($asunto);
        });
    }

    public static function enviar_email_confirmacion($tipo,$codigo_confirmacion,$asunto,$email,$adicional) {        
        $confirmation_code = str_random(30);
        Mail::send('correo.'.$tipo, ['codigo_confirmacion' => $codigo_confirmacion], function($message) use ($email, $asunto)
        {
            $message->to($email, $email)->subject($asunto);
        });
    }    

    public static function buscar_pais($id_pais) {
        $sql = "select * from maestro where padre='pais' and id_campo=".$id_pais;
        $data = DB::select($sql);
        foreach ($data as $data)
            return $data->campo;     
    }

    public static function buscar_clinica($id_clinica) {
        $sql = "select * from clinica where id=".$id_clinica;
        $data = DB::select($sql);
        foreach ($data as $data)
            return $data->nombre;     
    }

    public static function buscar_privilegio($id_medico) {
        $sql = "select id_tipo_medico from medico where id=".$id_medico;
        $data = DB::select($sql);
        foreach ($data as $data)
            return $data->id_tipo_medico;     
    } 

    public static function llenar_paciente($nombres,$apellidos,$cedula,$edad) {
        $resultado="";
        $resultado.= '<div class="form-group">    
        <label class="control-label col-xs-3">Nombre:</span></label>
            <div class="col-xs-3">
                <input readonly id="item1" name="item1" type="text" class="form-control"value="'.strtoupper($nombres." ".$apellidos).'">
            </div>
        </div>';
        $resultado.= '<div class="form-group">    
        <label class="control-label col-xs-3">Cedula:</span></label>
            <div class="col-xs-3">
                <input readonly id="item1" name="item1" type="text" class="form-control"value="'.number_format($cedula,0,"",".").'">
            </div>
        </div>';
        $resultado.= '<div class="form-group">    
        <label class="control-label col-xs-3">Edad:</span></label>
            <div class="col-xs-3">
                <input readonly id="item1" name="item1" type="text" class="form-control"value="'.$edad.' años">
            </div>
        </div>';
        return $resultado;
    }

    public static function obtener_id_especialidad($especialidad) {
        $explode_esp=explode(",",$especialidad);
        $res="";
        for ($i=0; $i<count($explode_esp); $i++) {
            $sql = "select id from especialidad where nombre='".strtoupper($explode_esp[$i])."'";
            $data = DB::select($sql);
            if (empty($data)) {
                $sql = "insert into especialidad (nombre) values ('".strtoupper($explode_esp[$i])."')";
                DB::insert($sql);
                $sql = "select max(id) as id_esp from especialidad";
                $data2 = DB::select($sql);
                foreach ($data2 as $data2)
                    $id=$data2->id_esp;
            } else {
                foreach ($data as $data)
                    $id=$data->id;
            }
            $res.=$id.",";
        }
        $res=substr($res,0,strlen($res)-1);
        return $res;
    }

    public static function buscar_especialidades($id_especialidad) {
        $explode_esp=explode(",",$id_especialidad);
        $res="";
        for ($i=0; $i<count($explode_esp); $i++) {
            $sql = "select nombre from especialidad where id='".strtoupper($explode_esp[$i])."'";
            $data = DB::select($sql);
            foreach ($data as $data)
                $res.=$data->nombre.", ";

        }
        $res=substr($res,0,strlen($res)-2);
        return $res;
    }

    public static function fecha_normal($fecha_nacimiento) {
        if (!is_null($fecha_nacimiento)) {
            $fecha=explode("-",$fecha_nacimiento);
            return $fecha[2]."/".$fecha[1]."/".$fecha[0];
        } else
            return "";
    }

    public static function fecha_mysql($valor) {
        if (!is_null($valor) && strpos($valor,"/") !== false) {
            $fecha=explode("/",$valor);
            return $fecha[2]."-".$fecha[1]."-".$fecha[0];
        } else
            return "";
    }

    public static function capturar_ruta () {
        //echo "...ruta=".$_SERVER['HTTP_HOST']."...";
        //return;
        return "http://".$_SERVER['HTTP_HOST']."/controlpagos/public";
    }

    public static function buscar_color_clinica($id) {
        $sql = "select color from clinica_medico where id_clinica=$id and id_medico=".Session::get("id_usuario");
        $data = DB::select($sql);
        if (empty($data))
            return "#ffffff";
        else {
            foreach ($data as $data)
                return $data->color;          
        }
    }

    public static function buscar_medico($id) {
        $sql = "select * from medico where id=$id";
        $data = DB::select($sql);
        $resultado="";
        foreach ($data as $data) {
            $resultado.= '<div class="form-group">    
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Medico:</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">'.$data->nombres.' '.$data->apellidos.'</div>
            </div>';
            $resultado.= '<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Cedula:</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">'.$data->cedula.'</div>
            </div>';
            $resultado.= '<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Especialidas(es):</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">'.self::buscar_especialidades($data->id_especialidad).'</div>
            </div>';
            if ($data->foto) {
                $resultado.= '<div class="form-group">    
                    <label class="control-label col-xs-3">Foto:</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">';
                    $ruta="";
                    if (strpos($_SERVER['REQUEST_URI'],"consultar") !== false)
                        $ruta="../";

                    if ($data->foto!="")
                        $resultado .= '<img height="100" width="100" src="'.$ruta.'users/'.$data->id.'/'.$data->foto.'">';
                    else
                        $resultado .= '&nbsp';
                    $resultado .= '</div>
                </div>';  
            }
        }
        echo $resultado;
    }

    public static function mostrar_especialidades($medico,$id_especialidad) {
        $sql = "select id_especialidad from medico where ";
        $sql .= "id=".$medico;
        $data = DB::select($sql);
        $resultado="";
        $chk="";        

        foreach ($data as $data) {
            $especialidad=explode(",", $data->id_especialidad);
        }
        if (!empty($especialidad)) {
            for ($i=0; $i<count($especialidad); $i++) {
                if ($especialidad[$i]!="") {
                    $sql = "select * from especialidad where id=".$especialidad[$i];
                    $data = DB::select($sql);
                    foreach ($data as $data) {
                        $id_esp=$data->id;
                        $nombre=$data->nombre;
                    }
                    if ($id_especialidad==$id_esp)
                        $chk="checked";
                    $resultado.='
                        <input '.$chk.' class="flat" name="id_especialidad" id="id_especialidad" type="radio" value="'.$id_esp.'"> <label>'.$nombre.'</label>
                    <br />';
                }
            }
        } 
        echo $resultado;
    }

    public static function buscar_id($tabla,$nombre) {
        $sql = "select id from ".$tabla." where UPPER(nombre)='".strtoupper($nombre)."'";
        $data=DB::select($sql);
        foreach ($data as $data)
            return $data->id;
    }

    public static function buscar_nombre($tabla,$id) {
        if ($id) {
            $sql = "select nombre from ".$tabla." where id=".$id;
            $data=DB::select($sql);
            foreach ($data as $data)
                return $data->nombre;
        }
    }    

    public static function buscar_rol($id_rol) {        
        $res="";
        if ($id_rol) {
            $rol=explode(",", $id_rol);
            for ($i=0;$i<count($rol); $i++) {
                $sql = "select campo from maestro where padre='rol' and id_campo=".$rol[$i];
                $data=DB::select($sql);
                foreach ($data as $data)
                    $res.=($i+1).".-".$data->campo."<br />";                
            }
            //$res=substr($res,0,strlen($res)-2);
        }
        return $res;
    }    


    public static function buscar_seguro($id_seguro) {
        $sql = "select nombre from seguros where id=$id_seguro";
        $data = DB::select($sql);
        foreach ($data as $data)
            return $data->nombre;
    }

    public static function crear_tabla_detalle_cirugia($id_cirugia) {
        $datos_cirugia = Datos_cirugia::where('id_cirugia', '=', $id_cirugia)->take(10)->get();
        $resultado="";
        $resultado.= '<div class="form-group">
            <table id="example" class="display" cellspacing="0" width="60%">
                <thead>
                    <tr>
                        <th>Fecha Carga</th>
                        <th>Fecha Alta</th>
                        <th>Observaciones</th>
                        <th>Referencia</th>
                        <th>Habitacion</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Fecha Carga</th>
                        <th>Fecha Alta</th>
                        <th>Observaciones</th>
                        <th>Referencia</th>
                        <th>Habitacion</th>
                        <th>&nbsp;</th>                    
                    </tr>
                </tfoot>
                <tbody>
                ';
                    foreach ($datos_cirugia as $key=>$datos_cirugia) {
                        $fecha_alta="Aun sigue en la clinica";
                        if ($datos_cirugia->fecha_alta!='0000-00-00')
                            $fecha_alta=self::fecha_normal($datos_cirugia->fecha_alta);
                        $resultado .= '<tr>
                            <td>'.self::fecha_normal($datos_cirugia->fecha_carga).'</td>
                            <td>'.$fecha_alta.'</td>
                            <td>'.$datos_cirugia->observaciones.'</td>
                            <td>'.$datos_cirugia->referencia.'</td>
                            <td align="center">'.$datos_cirugia->habitacion.'</td>
                            <td><div class="btn-group"><a href="javascript:;" onclick="eliminar_dato_cirugia('.$datos_cirugia->id.','.$id_cirugia.')"><button class="btn btn-default" type="button">Eliminar</button></a></div></td>
                        </tr>';
                    }
                $resultado .= '
                 </tbody>
            </table>
        </div>'; 
        //$resultado="ahora si devuelve";
        return $resultado;
    }

    public static function monto_pagado($id_cirugia) {
        $sql = "select sum(monto) as monto_pagado from pagosclinicas where id_cirugia=".$id_cirugia;
        //echo $sql;
        $data=DB::select($sql);
        if (empty($data))
            return 0;
        else {
            foreach ($data as $data)
                return $data->monto_pagado;
        }
    }

    public static function monto_deudor($id_cirugia) {
        $sql = "select sum(monto) as monto_total from datos_cirugia where id_cirugia=".$id_cirugia;
        $data=DB::select($sql);
        if (empty($data))
            $monto_deudor = 0;
        else {
            foreach ($data as $data)
                $monto_deudor = $data->monto_total-self::monto_pagado($id_cirugia);
        }
        return $monto_deudor;
    }    

    public static function crear_tabla_consulta_pagos($fecha1, $fecha2, $tipo, $consulta, $id_clinica) {
        if (strpos($fecha1,"/")) {
            $fecha1=FuncionesControllers::fecha_mysql($fecha1);
            $fecha2=FuncionesControllers::fecha_mysql($fecha2);
        }
        $sql = "select                     
                    m.nombres as medico, p.nombres as nombre_paciente,
                    p.apellidos as apellido_paciente, c.nombre as cirugia,
                    c.seguros, c.id as id_cirugia, cli.id_clinica, c.monto, ";
                if ($tipo=="cirugia")
                    $sql .= "mc.rol, mc.id_especialidad, ";
        $sql .= "cli.nombre as clinica, p.id as id_paciente
                from 
                    paciente p, cirugias c, 
                    medico m, clinica_medico cli ";
                if ($tipo=="cirugia")
                    $sql.=", medico_cirugia mc ";
        $sql.="where
                    m.id=c.id_medico and p.id=c.id_paciente and ";
                if ($tipo=="cirugia")
                    $sql .= "mc.id_cirugia=c.id and ";
        $sql .= "   cli.id_clinica=c.id_clinica and 
                    cli.id_medico=c.id_medico and
                    c.fecha_cirugia between '".$fecha1."' and '".$fecha2."' ";

                /*if ($tipo=="cirugia")
                    $sql .= " and dc.id_tipo_atencion=3";
                else
                    $sql .= " and dc.id_tipo_atencion!=3";*/

                $sql .= " and c.id in (select id_cirugia from alta)";

                if ($id_clinica>0)
                    $sql .= " and cli.id_clinica=$id_clinica ";
        if (Session::get("tipo")==2)
            $sql .= " and c.id_medico=".Session::get("id_medico");

        $sql .= " order by m.nombres,c.nombre";
        
        //echo $sql; return;

        $data = DB::select($sql);
        $resultado="";
        $resultado.= '<div class="form-group">
            <table id="example_'.$tipo.'" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Clinica</th>
                        <th>Paciente</th>
                        <th>Diagnostico</th>';
                if ($tipo=="cirugia")
                    $resultado.= '  <th>Rol</th>
                                    <th>Especialidad</th>';
        $resultado.= '<th>Monto Total</th>
                        <th>Monto Pagado</th>
                        <th>Saldo Deudor</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Clinica</th>
                        <th>Paciente</th>
                        <th>Diagnostico</th>';
                if ($tipo=="cirugia")
                    $resultado.= '  <th>Rol</th>
                                    <th>Especialidad</th>';
                $resultado.= '<th>Monto Total</th>
                        <th>Monto Pagado</th>
                        <th>Saldo Deudor</th>
                        <th>Estatus</th>               
                    </tr>
                </tfoot>
                <tbody>
                ';
                    foreach ($data as $data) {
                        $sql = "select sum(pc.monto) as monto_pago, c.monto as monto_total from
                                cirugias c, pagosclinicas pc 
                                where c.id=pc.id_cirugia and c.id=".$data->id_cirugia;
                        //echo $sql;
                        $data_pagos=DB::select($sql);

                        foreach ($data_pagos as $data_pagos) {
                            $monto_pago=$data_pagos->monto_pago;
                            $monto_total=$data_pagos->monto_total;
                        }

                        $monto_deuda=$monto_total-$monto_pago;
                        
                        if (($consulta==1 && $monto_deuda>0) || ($consulta==2 && $monto_deuda==0) || ($consulta==3)) {
                            //consulta es 1 Pagos Pendientes
                            //consulta es 2 Pagos Pagados
                            $resultado .= '<tr>
                                <td>'.$data->clinica.'</td>
                                <td>'.$data->nombre_paciente.' '.$data->apellido_paciente.'</td>
                                <td>'.$data->cirugia.'</td>';                                
                                if ($tipo=="cirugia")
                                    $resultado .= '<td>'.$data->rol.'</td>
                                            <td>'.self::buscar_nombre("especialidad",$data->id_especialidad).'</td>';
                            $resultado .= '<td>Bs. '.number_format($data->monto,2,",",".").'</td>
                                            <td>Bs. '.number_format(self::monto_pagado($data->id_cirugia),2,",",".").'</td>
                                            <td><span class="msj">Bs. '.number_format($monto_deuda,2,",",".").'</span></td>';
                            if (($consulta==1 && $monto_deuda>0) || ($consulta==3 && $monto_deuda>0)) //Pagos Pendientes                    
                                $resultado .= '<td align"center">Pago pendiente Parcialmente</td>';    
                            elseif (($consulta==2 && $monto_deuda==0) || ($consulta==3 && $monto_deuda==0)) //Pagos Pagados
                                $resultado .= '<td align"center">Pagado Totalmente</td>';                     
                            
                            $resultado .= '</tr>';
                        }
                    }
                $resultado .= '
                 </tbody>
            </table>
        </div>'; 
        echo $resultado;
    }        

    public static function buscar_estatus_pago($id_cirugia, $id_clinica, $id_paciente) {
        $sql = "select 
                    pc.*
                from
                    pagosclinicas pc, cirugias c
                where
                    pc.id_cirugia=c.id and 
                    pc.id_clinica=c.id_clinica and 
                    c.id=$id_cirugia and 
                    c.id_clinica=$id_clinica and 
                    c.id_paciente=$id_paciente and
                    pc.id_paciente=c.id_paciente
                ";
        //echo $sql;
        //return;
        $data=DB::select($sql);

        if (self::monto_deudor($id_cirugia)-self::monto_pagado($id_cirugia)==0)
            return '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
        else
            return "<span class=\"msj\">Pendiente</span>";
    }

    public static function buscar_medicos() {
        $usuario = Usuarios::where('id_tipo_medico', '=', 2)->take(10)->get();
        
        $strDatos="[";
        $end_data = Usuarios::count();

        foreach ($usuario as $key=>$usuario) {
            $strDatos.="['<input type=\'checkbox\' name=\'chk_".$usuario->id."\' value=".$usuario->id.">',";
            $strDatos.="'".strtoupper($usuario->nombres." ".$usuario->apellidos)."',";
            $strDatos.="'".$usuario->cedula."',";
            $strDatos.="'".strtolower($usuario->email)."']";

            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="medicos";
        $strColumnas="{ title: \"Seleccion\" },{ title: \"Nombre\" },{ title: \"Cedula\" },{ title: \"Email\" }";
        $strtfoot="<th>Seleccion</th><th>Nombre</th><th>Cedula</th><th colspan=3>Email</th>";
        $strOpciones="";
        $strOrden="[ 0, \"desc\" ]";
        $intCantidad=10;
        $strNombreArchivo="Listado de Medicos";
        $strFiltro="No";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo, $strFiltro);

    }

    public static function actualizar_rol() {
        $sql = "select distinct(id_tipo_atencion) as id from datos_cirugia where tipo_atencion=''";
        $data=DB::select($sql);
        foreach ($data as $data) {
            $sql = "select nombre from tipos_atencion where id=".$data->id;
            $data_aten=DB::select($sql);
            foreach ($data_aten as $data_aten) {
                $sql="update datos_cirugia set tipo_atencion='".$data_aten->nombre."' where id_tipo_atencion=".$data->id." and  tipo_atencion=''";
                DB::update($sql);
            }
        }
    }

    public static function verificar_alta($id_cirugia) {
        $sql = "select id from cirugias where id=".$id_cirugia." and id in (select id_cirugia from alta)";
        //echo $sql;
        $data=DB::select($sql);
        if (empty($data))
            return 1;
        else
            return 0;
    }    

    public static function verificar_estatus_paciente($id_paciente, $id_clinica, $id_cirugia) {
        $sql = "select dc.id_cirugia, dc.fecha_alta, c.fecha_cirugia
        from datos_cirugia dc, cirugias c 
        where 
            dc.id_cirugia=c.id and c.id_clinica=$id_clinica and 
            c.id_paciente=$id_paciente and c.id=$id_cirugia and
            c.id in (select id_cirugia from alta)
        ";
        $data=DB::select($sql);
        if (empty($data)) {
            $sql = "select fecha_cirugia from cirugias where id=".$id_cirugia;
            $data=DB::select($sql);
            foreach ($data as $data) {
                $fecha_cirugia=$data->fecha_cirugia;
                $fecha_cirugia=self::fecha_normal($fecha_cirugia);
            }
            echo "<div class='alert alert-warning'><strong>Este paciente se encuentra ACTIVO desde el dia ".$fecha_cirugia."</strong></div>";
        } else {
            foreach ($data as $data)
                $fecha=$data->fecha_alta;
            echo "<div class='alert alert-danger'><strong>Este paciente se encuentra de ALTA el dia ".self::fecha_normal($fecha)."</strong></div>";
        }
    }

    public static function buscar_atenciones () {
        $sql = "select * from tipos_atencion order by nombre";
        $data=DB::select($sql);
        $r="";
        foreach ($data as $data)
            $r.=$data->nombre.", ";
        $r=substr($r,0,strlen($r)-2);
        echo $r;
    }

    public static function contador ($indice) {
        if ($indice==1) {
            //CIRUGIAS REALIZADAS
            $sql = "select count(id) as cantidad
                from cirugias 
                where id_medico=".Session::get("id_medico");
        } elseif ($indice==2) {
            //CIRUGIAS COBRADAS
            $sql = "select count(c.id) as cantidad
                from cirugias c, pagosclinicas pc 
                where pc.id_cirugia=c.id and 
                    c.id_medico=".Session::get("id_medico");
        } elseif ($indice==3) {
            //CIRUGIAS NO COBRADAS
            $sql = "select count(id) as cantidad
                from cirugias 
                where id_medico=".Session::get("id_medico")." and 
                    id not in (select id_cirugia from pagosclinicas)"
            ;
        }
        $data = DB::select($sql);
        if (empty($data))
            return 0;
        else {
            foreach ($data as $data)
                return $data->cantidad;
        }
    }

    public static function buscar_pendientes($tipo) {
        $sql = "select p.nombres, p.apellidos, p.cedula, dc.monto, dc.tipo_atencion, 
            cm.nombre as clinica, dc.fecha_carga, c.id as id_cirugia ";
        if ($tipo=="alta")
            $sql .= ",dc.fecha_alta";

        $sql .= " from paciente p, cirugias c, 
            datos_cirugia dc, clinica_medico cm 
        where p.id=c.id_paciente and p.id_medico=c.id_medico and
            c.id=dc.id_cirugia and c.id_clinica=cm.id_clinica and 
            cm.id_medico=".Session::get("id_medico")." and 
            c.id_medico=cm.id_medico and ";
        if ($tipo=="alta") {
            $sql .= "c.id in (select id_cirugia from alta) and ";
            //$sql .= " c.id not in (select id_cirugia from pagosclinicas) and ";
        } elseif ($tipo=="sin_alta")
            $sql .= "c.id not in (select id_cirugia from alta) and ";
        
        $sql .= "dc.id_tipo_atencion!=7 ";
        $sql .= "order by dc.fecha_carga desc";
        //echo $sql;
        $data = DB::select($sql);
        $resultado="";
        if (empty($data))
            $resultado = "<br />No hubo resultados";
        else {
            foreach ($data as $data) {
                $resultado.='
                    <li class="media event">
                        <a class="pull-left border-aero profile_thumb">
                            <i class="fa fa-user aero"></i>
                        </a>
                        <div class="media-body">
                            <a class="title" href="#">'.strtoupper($data->nombres.' '.$data->apellidos).'</a>
                            <p>CI: '.number_format($data->cedula,0,"",".").'</p>
                            <p> <small>'.$data->clinica.'</small>';
                            $resultado .= '<p> <small>Fecha Atencion:<strong>'.self::fecha_normal($data->fecha_carga).'</strong> </small>
                                <p><strong>Total: Bs. '.number_format($data->monto,2,",",".").'. </strong></p>';
                            if ($tipo=="alta") {
                                $resultado .= '<p> <small>Fecha Alta:<strong>'.self::buscar_fecha_alta($data->id_cirugia).'</strong> </small>';
                                $resultado .= '<p> <small>Pagado:<strong>'.number_format(self::monto_pagado($data->id_cirugia),2,",",".").'</strong> </small>';
                                $resultado .= '<p style="color: red"> <small>Saldo:<strong>'.number_format(self::monto_deudor($data->id_cirugia),2,",",".").'</strong> </small>';
                            }
                            $resultado .= '</p>
                        </div>
                    </li>
                ';
            }
        }
        echo $resultado;
    }

    public static function buscar_fecha_alta($id_cirugia) {
        $sql = "select fecha_alta from datos_cirugia where id_tipo_atencion=7 and id_cirugia=".$id_cirugia;
        $data=DB::select($sql);
        foreach ($data as $data) {
            return self::fecha_normal($data->fecha_alta);
        }
    }

    public static function buscar_fecha_alta_dc($id_cirugia) {
        $sql = "select fecha_alta from datos_cirugia where id_tipo_atencion=7 and id_cirugia=".$id_cirugia;
        $data=DB::select($sql);
        foreach ($data as $data)
            return $data->fecha_alta;
    }

    public static function dias_desde_fecha($fecha) {
        if ($fecha==0)
            return 0;
        else {
            $today = @getdate();
            
            $dia = $today["mday"];
            $mes = $today["mon"];
            $ano = $today["year"];
            $fecha_act = $ano."-".$mes."-".$dia;

            $dias   = (strtotime($fecha)-strtotime($fecha_act))/86400;
            $dias   = abs($dias); $dias = floor($dias); 
            return $dias; 
        }       
    }

    public static function total_pagado_clinica($id_clinica) {
        $sql = "select sum(pc.monto) as monto from pagosclinicas pc, cirugias c 
                where c.id=pc.id_cirugia and c.id_clinica=$id_clinica";
        $data = DB::select($sql);
        if (!empty($data))
            foreach ($data as $data)
                return $data->monto;
        else
            return 0;
    }

    public static function total_pagado($id_cirugia) {
        $sql = "select sum(monto) as monto from pagosclinicas
                where id_cirugia=".$id_cirugia;

        $data = DB::select($sql);
        if (!empty($data))
            foreach ($data as $data)
                return $data->monto;
        else
            return 0;
    }    

    public static function total_adeudado($id_datos_cirugia) {
        echo "id=".$id_datos_cirugia;
        return;
    }    

    public static function buscar_factura($id_cirugia, $tipo) {
        $sql = "select ".$tipo." as valor from facturas where id_cirugia=".$id_cirugia;
        //echo $sql;
        $data = DB::select($sql);
        if (empty($data))
            return 0;
        else {
            foreach ($data as $data)
                return $data->valor;
        }
    }

    public static function buscar_factura_tipo($tipo,$id_cirugia) {
        $sql = "select * from facturas where id_cirugia=".$id_cirugia;
        $data = DB::select($sql);
        if (empty($data))
            return 0;
        else {
            foreach ($data as $data) {
                if ($tipo=="numero")
                    return $data->nro_factura_clinica;
                else
                    return self::fecha_normal($data->fecha_factura);
            }
        }
    }

    public static function buscar_monto_factura($id_cirugia) {
        $sql = "select c.monto as mc, sum(f.monto) as mf from facturas f, cirugias c 
            where f.id_cirugia=".$id_cirugia." and c.id=f.id_cirugia group by c.monto";
            echo $sql;
        $data = DB::select($sql);
        if (empty($data))
            return 0;
        else {
            foreach ($data as $data) {
                $monto_factura=$data->mc-$data->mf;
                return $monto_factura;
            }
        }
    }

    public static function buscar_monto_factura_clinica($id_clinica) {
        $sql = "select c.monto as mc, sum(f.monto) as mf from facturas f, cirugias c 
            where f.id_clinica=".$id_clinica." and c.id=f.id_cirugia group by c.monto";
            //echo "<br>".$sql;
        $data = DB::select($sql);
        if (empty($data))
            return 0;
        else {
            foreach ($data as $data) {
                return $data->mf;
            }
        }
    }

}