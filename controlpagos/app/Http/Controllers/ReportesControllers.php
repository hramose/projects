<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\SessionusuarioControllers;

use App\cirugias;
use App\paciente;
use App\nro_historia;
use App\clinica_medico;
use App\cirugia_seguro;
use App\seguros_medicos;
use App\medico_cirugia;
use App\datos_cirugia;

use App\Http\Controllers\FuncionesControllers;

class ReportesControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /periodicos
     *
     * @return Response
     */
    public function index()
    {       
        $today = @getdate();
        
        $dia = $today["mday"];
        $mes = $today["mon"];
        $ano = $today["year"];
        $fecha_act = $ano."-".$mes."-".$dia;

        $fecha = $fecha_act;
        $nuevafecha = strtotime ( '-30 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );

        $fecha_act = $fecha;
        $fecha2=FuncionesControllers::fecha_normal($fecha_act);
        $fecha1=FuncionesControllers::fecha_normal($nuevafecha);

        Session::put("fecha",$fecha_act);

        $consulta=0;

        $id_medico=Session::get("id_medico");

        $consulta=1;
        return view::make('cirugias.pacientes',["fecha1"=>$fecha1, "fecha2"=>$fecha2, "consulta"=>$consulta,"id_medico"=>$id_medico]);
    }

    public static function rpts ($ruta) {
        // ARREGLO DE VISTAS
        $array_rutas=array(
                "rpt_med_pac"=>"v_med_pac_q01",
                "rpt_med_pac_xcli"=>"v_med_pac_q02",
                "rpt_med_pac_xAte"=>"v_med_pac_q03",
                "rpt_med_pac_xRol"=>"v_med_pac_q04",
                "rpt_med_pac_xRolxCir"=>"v_med_pac_q05",
                "rpt_med_pac_xDia"=>"v_med_pac_q06",
                "rpt_med_pac_xSegxAte"=>"v_med_pac_q07",
                "rpt_med_pac_xAtexCir"=>"v_med_pac_q08"
            );

        // ARREGLO DE CAMPOS
        $array_campos=array(
                "rpt_med_pac"=>"medico_nombres, medico_apellidos, paciente_nombres, paciente_apellidos",
                "rpt_med_pac_xcli"=>"v_med_pac_q02",
                "rpt_med_pac_xAte"=>"v_med_pac_q03",
                "rpt_med_pac_xRol"=>"v_med_pac_q04",
                "rpt_med_pac_xRolxCir"=>"v_med_pac_q05",
                "rpt_med_pac_xDia"=>"v_med_pac_q06",
                "rpt_med_pac_xSegxAte"=>"v_med_pac_q07",
                "rpt_med_pac_xAtexCir"=>"v_med_pac_q08"            
            );

        $sql = "select * from ".$array_rutas[$ruta];

        $data = DB::select($sql);
        Session::put("ruta",$ruta);
        return view::make('reportes.vistas', compact('data'), compact ('array_campos'));
    }

    public static function consulta($data, $array_campos)
    {
        //
        $strDatos="[";
        $end_data = count($data);
        $campos="";
        $i=0;
        $strColumnas="";
        $strtfoot="";
        foreach ($data as $key=>$data) {
            $strDatos.="[";
            foreach ($data as $key=>$value) {
                if (strpos($key,"_id") === false) {
                    $strDatos.="'".strtoupper($value)."',";
                    if ($i==0) {
                        $strColumnas.="{ title: \"".strtoupper(str_replace("_", " ", $key))."\" },";
                        $strtfoot.="<th>".strtoupper(str_replace("_", " ", $key))."</th>";
                    }
                }
            }
            $i++;
            $strDatos=substr($strDatos,0,strlen($strDatos)-1);
            $strDatos.="]";
            $strDatos.=",";
        }
       
        $strColumnas=substr($strColumnas,0,strlen($strColumnas)-1);
        $strDatos=substr($strDatos,0,strlen($strDatos)-1)."]";

        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strTabla="vistas";        
        $strNombreArchivo="";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
}