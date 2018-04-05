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
use App\moneda;
use App\Http\Controllers\FuncionesControllers;

class monedaControllers extends Controller {

    /**
     * Display a listing of the resource.
     * GET /
     *
     * @return Response
     */
    public function index()
    {
        return view::make('moneda.consulta');
    }

    public function nuevo_moneda() {
        Session::put("mensaje","");
        return view('moneda.nuevo',["mensaje"=>"", "id"=>0, "tipo"=>""]);
    }

    public function consultarmoneda($id)
    {
        $moneda=moneda::findOrFail($id);
        return view::make('moneda.edit', compact('moneda'));
    }        

    public function guardar_moneda_edicion (Request $request) {
        //dd($request->all());
        //return;
        $id=$request->id;
        $moneda=moneda::findOrFail($id);
        $moneda->fill($request->all());
        $moneda->save();
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

                return view('generica.formainsertada', ["tipo"=>"moneda"]);
    }

    public function guardar_moneda_nuevo (Request $request) {
        $moneda = new moneda($request->all());

        Session::put("mensaje","");

        $fileName = "";
        $sql = "select * from moneda where tipo='".$request->tipo."'";
        $data=DB::select($sql);
        if (empty($data)) {
            $moneda->save();

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

            return view('generica.formainsertada', ["tipo"=>"moneda"]);
        } else {
            Session::put("mensaje", "Existe la moneda");
            return view('moneda.nuevo', ["mensaje" => "guardado", "id" => 0, "tipo"=>$request->tipo]);
        }
    }

    public static function consulta()
    {
        //
        $moneda = moneda::all();
        
        $strDatos="[";
        $end_data = moneda::count();

        foreach ($moneda as $key=>$moneda) {
            $strDatos.="['".$moneda->tipo."',";
            $strDatos.="'<a href=consultarmoneda/".$moneda->id.">Consultar</a> | <a href=eliminarmoneda/".$moneda->id.">Eliminar</a>']";
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="moneda";
        $strColumnas="{ title: \"Tipo\" },{ title: \"-\" }";
        $strtfoot="<th>Tipo</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de Monedas";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
}