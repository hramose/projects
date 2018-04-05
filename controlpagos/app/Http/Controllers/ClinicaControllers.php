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
use App\clinica_medico;
use App\Http\Controllers\FuncionesControllers;

class ClinicaControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /periodicos
     *
     * @return Response
     */
    public function index()
    {
        return view::make('clinica.consulta');
    }

    public function nuevo_clinica() {
        Session::put("mensaje","");
        return view('clinica.nuevo',["mensaje"=>"", "id"=>0, "nombre"=>"", "direccion"=>"", "color"=>"", "pais"=>"", "ciudad"=>""]);
    }

    public function consultarclinicas($id)
    {
        return view::make('clinica.edit', ["id"=>$id]);
    }        

    public function guardar_clinica_edicion (Request $request) {
        $id=$request->id;

        //dd($request->all());

        $sql = "select * from clinica_medico where id_clinica=$id and id_medico=".Session::get("id_usuario");
        $data=DB::select($sql);
        if (empty($data)) {
            $clinica_medico = new clinica_medico($request->all());

            $clinica_medico->id_clinica=$id;
            $clinica_medico->nombre=$request->nombre;
            $clinica_medico->color=$request->color;
            $clinica_medico->direccion=$request->direccion;
            $clinica_medico->pais=$request->pais;
            $clinica_medico->ciudad=$request->ciudad;
            $clinica_medico->id_medico=Session::get("id_usuario");
            echo "dir=".$request->direccion;
            $clinica_medico->color=$request->color;

            $clinica_medico->save();
        } else {
            $sql = "update clinica_medico set nombre='".$request->nombre."', direccion='".$request->direccion."', pais='".$request->pais."', ciudad='".$request->ciudad."', color='".$request->color."' where id_clinica=$id and id_medico=".Session::get("id_usuario");
            DB::update($sql);
        }
        return view('generica.formainsertada', ["tipo"=>"clinica"]);        
    }

    public function guardar_clinica_nuevo (Request $request) {
        $clinica_medico = new clinica_medico($request->all());

        Session::put("mensaje","");

        $fileName = "";
        $sql = "select * from clinica where nombre='".$request->nombre."'";
        $data=DB::select($sql);
        if (empty($data)) {
            $clinica->save();

            $sql = "select max(id) as id from clinica";
            $data=DB::select($sql);
            foreach ($data as $data)
                $id=$data->id;

            $clinica_medico->id_clinica=$id;
            $clinica_medico->id_medico=Session::get("id_usuario");
            $clinica_medico->color=$request->color;

            $clinica_medico->save();
            return view('generica.formainsertada', ["tipo"=>"clinica"]);
        } else {
            Session::put("mensaje", "Hay otro clinica con el mismo nombre");
            return view('clinica.nuevo', ["mensaje" => "guardado", "id" => 0, "nombre"=>$request->nombre, "direccion"=>$request->direccion, "color"=>$request->color, "pais"=>$request->pais, "ciudad"=>$request->ciudad]);
        }
    }

    public static function consulta()
    {
        //
        $clinica = clinica_medico::where('id_medico',Session::get("id_medico"))
               ->take(10)
               ->get();
        
        $strDatos="[";
        $end_data = clinica_medico::count();

        foreach ($clinica as $key=>$clinica) {
            $strDatos.="['".$clinica->nombre."',";
            $strDatos.="'".$clinica->direccion."',";
            $strDatos.="'".$clinica->color."',";
            $strDatos.="'".FuncionesControllers::buscar_pais($clinica->pais)."',";
            $strDatos.="'".$clinica->ciudad."','";
            //,'<a href=consultarclinica/".$clinica->id.">Consultar</a> | <a href=eliminarclinica/".$clinica->id.">Eliminar</a>']";
            $strDatos.='<div class="btn-group"><a href="consultarclinicas/'.$clinica->id_clinica.'"><button class="btn btn-default" type="button">Consultar</button></a>';
            $strDatos.='<a href="javascript:;" onclick="eliminarclinica('.$clinica->id_clinica.')"><button class="btn btn-default" type="button">Eliminar</button></a></div>\']';
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="clinica";
        $strColumnas="{ title: \"Nombre\" },{ title: \"Direccion\" },{ title: \"Color\" },{ title: \"Pais\" },{ title: \"Ciudad\" },{ title: \"-\" }";
        $strtfoot="<th>Nombre</th><th>Direccion</th><th>Color</th><th>Pais</th><th>Ciudad</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de clinica";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
}