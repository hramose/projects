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
use App\especialidad;
use App\Http\Controllers\FuncionesControllers;

class EspecialidadControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /
     *
     * @return Response
     */
    public function index()
    {
        return view::make('especialidad.consulta');
    }

    public function nuevo_especialidad() {
        Session::put("mensaje","");
        return view('especialidad.nuevo',["mensaje"=>"", "id"=>0, "nombre"=>""]);
    }

    public function consultarespecialidad($id)
    {
        $especialidad=especialidad::findOrFail($id);
        return view::make('especialidad.edit', compact('especialidad'));
    }        

    public function guardar_especialidad_edicion (Request $request) {
        //dd($request->all());
        //return;
        $id=$request->id;        
        $especialidad=especialidad::findOrFail($id);
        $especialidad->fill($request->all());
        $especialidad->nombre=strtoupper($request->nombre);
        $especialidad->save();
        return view('generica.formainsertada', ["tipo"=>"especialidad"]);
    }

    public function guardar_especialidad_nuevo (Request $request) {
        $especialidad = new especialidad($request->all());

        Session::put("mensaje","");

        $especialidad->nombre=strtoupper($request->nombre);
        $sql = "select * from especialidad where nombre='".$request->nombre."'";
        $data=DB::select($sql);
        if (empty($data)) {
            $especialidad->save();
            return view('generica.formainsertada', ["tipo"=>"especialidad"]);
        } else {
            Session::put("mensaje", "Existe la especialidad");
            return view('especialidad.nuevo', ["mensaje" => "guardado", "id" => 0, "nombre"=>$request->nombre]);
        }
    }

    public static function consulta()
    {
        //
        $especialidad = especialidad::all();
        
        $strDatos="[";
        $end_data = especialidad::count();

        foreach ($especialidad as $key=>$especialidad) {
            $strDatos.="['".$especialidad->nombre."',";
            $strDatos.="'<a href=consultarespecialidad/".$especialidad->id.">Consultar</a> | <a href=eliminarespecialidad/".$especialidad->id.">Eliminar</a>']";
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="especialidad";
        $strColumnas="{ title: \"Nombre\" },{ title: \"-\" }";
        $strtfoot="<th>Nombre</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de especialidads";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
}