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
use App\Medicos;
use App\Http\Controllers\FuncionesControllers;

class UserControllers extends Controller {

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

    public function logout() {
        $sql = "update sesiones set active=0 where user='".Session::get("usuario")."'";
        DB::update($sql);

        Session::put("usuario","");
        Session::put("nombre","");
        Session::put("foto","");

        return view('inicio.inicio');
    }

    public function verificar_usuario(Request $request) {
        $username=$request->username;
        $contrasena=$request->password;

        $validador = Validator::make(
            array('username' => $username, 'pass' => $contrasena),
            array('username' => 'required', 'pass' => 'required')
        );

        if ($validador->passes()) {
            $sql = "select * from medico where email='".$username."'";
            $sql .= " and contrasena='".hash('ripemd160', $contrasena)."'";
            $data = DB::select($sql);

            if (empty($data)) {
                echo "<script>alert('Usuario y/o password incorrectos');</script>";
                return view('inicio.inicio');
            } else {
                foreach ($data as $data) {
                    SessionusuarioControllers::store($data->nombres,$data->apellidos,$data->id,$data->id_tipo_medico,$username,$data->foto);
                    return View::make('dashboard.index');
                }
            }
        } else {
            echo "<script>alert('Debe indicar su usuario y contraseña');</script>";
            return view('inicio.inicio');
        }
    }

    public function nuevo_medico() {
        Session::put("mensaje","");
        return view('medicos.nuevo',["mensaje"=>"", "id"=>0, "nombres"=>"", "apellidos"=>"", "cedula"=>"", "especialidad"=>0, "telefono_hab"=>0, "telefono_cel"=>0, "sexo"=>0, "fecha_nacimiento"=>"", "email"=>"", "direccion"=>"", "pregunta_secreta"=>"", "respuesta_secreta"=>"", "tipo_recepcion"=>0]);
    }

    public function guardar_usuario_edicion ($id) {
        $medicos = new Medicos($request->all());
        $medicos->fill(Request::all());
        $medicos->save();
    }

    public function guardar_usuario_nuevo (Request $request) {
        $medicos = new Medicos($request->all());

        Session::put("mensaje","");
        
        $foto=Input::file('foto');        
        $especialidad=$request->id_especialidad;
        $especialidad=substr($especialidad,0,strlen($especialidad)-1);

        $fileName = "";
        if ($request->contrasena != $request->contrasena2) {
            Session::put("mensaje", "Los password deben ser iguales");
            return view('medicos.nuevo', ["mensaje" => "guardado", "id" => 0, "nombres"=>$request->nombres, "apellidos"=>$request->apellidos, "cedula"=>$request->cedula, "especialidad"=>$request->especialidad, "telefono_hab"=>$request->telefono_hab, "telefono_cel"=>$request->telefono_cel, "sexo"=>$request->sexo, "fecha_nacimiento"=>$request->fecha_nacimiento, "email"=>$request->email, "direccion"=>$request->direccion, "pregunta_secreta"=>$request->pregunta_secreta, "respuesta_secreta"=>$request->respuesta_secreta, "tipo_recepcion"=>$request->tipo_recepcion]);
        } else {
            if ($foto) {
                $sql = "select max(id) as id from medico";
                $data=DB::select($sql);
                if (empty($data))
                    $carpeta=1;
                else {
                    foreach ($data as $data)
                        $carpeta=$data->id+1;
                }
                if (Input::file('foto')->isValid()) {
                    $destinationPath = 'users/' . $carpeta; // upload path
                    $extension = Input::file('foto')->getClientOriginalExtension(); // getting image extension
                    if (!is_dir($destinationPath))
                        mkdir($destinationPath);

                    $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                    Input::file('foto')->move($destinationPath, $fileName); // uploading file to given path
                }
            }
            $sql = "select * from medico where email='".$request->email."'";
            $data=DB::select($sql);
            if (empty($data)) {
                $medicos->id_tipo_medico='2';
                $medicos->activo='0';
                $medicos->foto=$fileName;
                $medicos->id_especialidad=$especialidad;
                $medicos->save();
                Session::put("mensaje", "Usuario insertado satisfactoriamente");

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

                return view('generica.formainsertada', ["tipo"=>"medico"]);
                //, ["mensaje" => "guardado", "id" => 0, "nombres"=>$request->nombres, "apellidos"=>$request->apellidos, "cedula"=>$request->cedula, "especialidad"=>$request->especialidad, "telefono_hab"=>$request->telefono_hab, "telefono_cel"=>$request->telefono_cel, "sexo"=>$request->sexo, "fecha_nacimiento"=>$request->fecha_nacimiento, "email"=>$request->email, "direccion"=>$request->direccion, "pregunta_secreta"=>$request->pregunta_secreta, "respuesta_secreta"=>$request->respuesta_secreta, "tipo_recepcion"=>$request->tipo_recepcion]);
            } else {
                Session::put("mensaje", "Hay otro usuario con el mismo email");
                //return view('generica.formainsertada', ["tipo"=>"medico"]);
                return view('medicos.nuevo', ["mensaje" => "guardado", "id" => 0, "nombres"=>$request->nombres, "apellidos"=>$request->apellidos, "cedula"=>$request->cedula, "especialidad"=>$request->especialidad, "telefono_hab"=>$request->telefono_hab, "telefono_cel"=>$request->telefono_cel, "sexo"=>$request->sexo, "fecha_nacimiento"=>$request->fecha_nacimiento, "email"=>$request->email, "direccion"=>$request->direccion, "pregunta_secreta"=>$request->pregunta_secreta, "respuesta_secreta"=>$request->respuesta_secreta, "tipo_recepcion"=>$request->tipo_recepcion]);
            }
        }
    }

    public function finduser() {
        return view('users.finduser',["cod_emp"=>0,"id_folder"=>0,"id_folder_doc"=>0]);
    }

    public function find_user_old(Request $request) {
        return view('users.finduser',["cod_emp"=>$request->cod_emp,"id_folder"=>$request->id_folder,"id_folder_doc"=>$request->id_folder_doc]);
    }

    public function finduserfolder($id) {
        Session::put("mensaje","");
        return view('users.register',["mensaje"=>"", "id"=>$id]);
    }

    public function findfoldersuser($id) {
        Session::put("mensaje", "");
        return view('users.viewfoldersreg', ["mensaje" => "", "id" => $id]);
    }

    public function changepassword($id) {
        Session::put("mensaje", "");
        return view('users.changepassword', ["mensaje" => "", "id" => $id]);
    }

    public function sevepassword(Request $request)
    {
        $sql = "update usuario set pass='" . md5($request->contrasena1) . "' where id=" . $request->id;
        DB::update($sql);
        //echo $sql;
        $mensaje = "Your password had been changed";

        return View::make('users.changepassword', ["mensaje" => $mensaje]);
    }

    public static function consulta()
    {
        //
        $medicos = medicos::all();
        
        $strDatos="[";
        $end_data = medicos::count();

        foreach ($medicos as $key=>$medicos) {
            $strDatos.="['".$medicos->proveedor_id."',";
            $strDatos.="'".$medicos->tipo_rif."',";
            $strDatos.="'".$medicos->rif."',";
            $strDatos.="'".$medicos->razon_social."',";
            $strDatos.="'".$medicos->tipo."',";
            $strDatos.="'".$medicos->usuario_id."',";
            $strDatos.="'".$medicos->fecha_ingreso."']";
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="medicos";
        $strColumnas="{ title: \"proveedor_id\" },{ title: \"tipo_rif\" },{ title: \"rif\" },{ title: \"razon_social\" },{ title: \"tipo\" },{ title: \"usuario_id\" },{ title: \"fecha_ingreso\" }";
        $strtfoot="<th>proveedor_id</th><th>tipo_rif</th><th>rif</th><th>razon_social</th><th>tipo</th><th>usuario_id</th><th>fecha_ingreso</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}"; 
        $strOrden="[ 1, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de Medicos";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }
}