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
use App\seguro;
use App\Http\Controllers\FuncionesControllers;

class seguroControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /periodicos
     *
     * @return Response
     */
    public function index()
    {
        return view::make('seguro.consulta');
    }

    public function nuevo_seguro() {
        Session::put("mensaje","");
        return view('seguro.nuevo',["mensaje"=>"", "id"=>0, "nombre"=>"", "direccion"=>"", "color"=>"", "pais"=>"", "ciudad"=>""]);
    }

    public function consultarseguro($id)
    {
        $seguro=seguro::findOrFail($id);
        return view::make('seguro.edit', compact('seguro'));
    }        

    public function guardar_seguro_edicion (Request $request) {
        //dd($request->all());
        //return;
        $id=$request->id;
        $seguro=seguro::findOrFail($id);
        $seguro->fill($request->all());
        $seguro->save();
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

                return view('generica.formainsertada', ["tipo"=>"seguro"]);        
    }

    public function guardar_seguro_nuevo (Request $request) {
        $seguro = new seguro($request->all());

        Session::put("mensaje","");

        $fileName = "";
        $sql = "select * from seguros where nombre='".$request->nombre."'";
        $data=DB::select($sql);
        if (empty($data)) {
            $seguro->save();

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

            return view('generica.formainsertada', ["tipo"=>"seguro"]);
        } else {
            Session::put("mensaje", "Hay otro seguro con la misma cedula");
            return view('seguro.nuevo', ["mensaje" => "guardado", "id" => 0, "nombre"=>$request->nombre, "direccion"=>$request->direccion, "color"=>$request->color, "pais"=>$request->pais, "ciudad"=>$request->ciudad]);
        }
    }

    public static function consulta()
    {
        //
        $seguro = seguro::all();
        
        $strDatos="[";
        $end_data = seguro::count();

        foreach ($seguro as $key=>$seguro) {
            $strDatos.="['".$seguro->nombre."',";
            $strDatos.="'".$seguro->direccion."',";
            $strDatos.="'<a href=consultarseguro/".$seguro->id.">Consultar</a> | <a href=eliminarseguro/".$seguro->id.">Eliminar</a>']";
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="seguro";
        $strColumnas="{ title: \"Nombre\" },{ title: \"Direccion\" },{ title: \"-\" }";
        $strtfoot="<th>Nombre</th><th>Direccion</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de seguro";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
}