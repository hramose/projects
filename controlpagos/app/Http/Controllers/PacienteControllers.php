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
use App\paciente;
use App\Http\Controllers\FuncionesControllers;

class PacienteControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /periodicos
     *
     * @return Response
     */
    public function index()
    {
        return view::make('pacientes.consulta');
    }

    public function nuevo_paciente() {
        Session::put("mensaje","");
        return view('pacientes.nuevo',["mensaje"=>"", "id"=>0, "nombres"=>"", "apellidos"=>"", "cedula"=>"", "edad"=>0]);
    }

    public function consultarpaciente($id)
    {
        $paciente=paciente::findOrFail($id);
        return view::make('pacientes.edit', compact('paciente'));
    }        

    public function guardar_paciente_edicion (Request $request) {
        //dd($request->all());
        //return;
        $id=$request->id;
        $paciente=paciente::findOrFail($id);
        $paciente->fill($request->all());
        $paciente->save();
/************************* EMAIL A ENVIAR ***************************/
               /* Mail::send('correo.usuario', $request->all(), function($message)
                {
                    $message->to('jeleicy@gmail.com', $request->nombres." ".$request->apellidos)->subject('Usuario Nuevo!');
                });  

                Mail::send('correo.usuario', $request->all(), function($message)
                {
                    $message->to($request->email, $request->nombres." ".$request->apellidos)->subject('Usuario Nuevo!');
                });*/
/************************* EMAIL A ENVIAR ***************************/

                return view('generica.formainsertada', ["tipo"=>"paciente"]);        
    }

    public function guardar_paciente_nuevo (Request $request) {
        $paciente = new paciente($request->all());

        Session::put("mensaje","");

        $fileName = "";
        $sql = "select * from paciente where cedula='".$request->cedula."'";
        $data=DB::select($sql);
        if (empty($data)) {
            $paciente->save();
            return view('generica.formainsertada', ["tipo"=>"paciente"]);
        } else {
            Session::put("mensaje", "Hay otro paciente con la misma cedula");
            return view('pacientes.nuevo', ["mensaje" => "guardado", "id" => 0, "nombres"=>$request->nombres, "apellidos"=>$request->apellidos, "cedula"=>$request->cedula, "edad"=>$request->edad]);
        }
    }

    public static function consulta()
    {
        //
        $paciente = paciente::all();
        
        $strDatos="[";
        $end_data = paciente::count();

        foreach ($paciente as $key=>$paciente) {
            $strDatos.="['".$paciente->nombres." ".$paciente->apellidos."',";
            $strDatos.="'".$paciente->cedula."',";
            $strDatos.="'".$paciente->edad."','<a href=consultarpaciente/".$paciente->id.">Consultar</a> | <a href=eliminarpaciente/".$paciente->id.">Eliminar</a>']";
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="paciente";
        $strColumnas="{ title: \"Nombre\" },{ title: \"Cedula\" },{ title: \"Edad\" },{ title: \"-\" }";
        $strtfoot="<th>Nombre</th><th>Cedula</th><th>Edad</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}"; 
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de paciente";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
}