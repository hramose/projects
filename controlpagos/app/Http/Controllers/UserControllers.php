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
use App\medicos;
use App\usuarios;
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
        return view::make('medicos.consulta');
    }

        public function olvido_contrasena($email)
    {
        //
        return view::make('medicos.contrasena',["email"=>$email]);
    }

    public function logout() {
        $sql = "update sesiones set activa=0 where usuario='".Session::get("usuario")."'";
        DB::update($sql);

        Session::put("usuario","");
        Session::put("nombre","");
        Session::put("foto","");
        Session::put("id_usuario","");
        Session::put("activo",0);
        Session::put("tipo",0);
        Session::put("id_medico",0);

        return view('inicio.inicio')->with('mensaje','');
    }

    public function verificar_usuario(Request $request) {
        $username=$request->username;
        $contrasena=$request->password;

        $validador = Validator::make(
            array('username' => $username, 'pass' => $contrasena),
            array('username' => 'required', 'pass' => 'required')
        );

        if ($validador->passes()) {
            $sql = "select * from medico where confirmada=1 and email='".$username."'";
            $sql .= " and contrasena='".hash('ripemd160', $contrasena)."'";
            //echo $sql;
            $data = DB::select($sql);

            if (empty($data)) {
                //dd($request->all());
                //echo "<script>alert('Usuario y/o password incorrectos');</script>";
                return View::make('inicio.inicio')->with('mensaje','error_autenticacion');
            } else {
                foreach ($data as $data) {
                    SessionusuarioControllers::store($data->nombres,$data->apellidos,$data->id,$data->id_tipo_medico,$username,$data->foto,$data->activo,$data->id_tipo_medico);
                    return View::make('dashboard.index');
                }
            }
        } else {
            echo "<script>alert('Debe indicar su usuario y contraseña');</script>";
            return view('inicio.inicio');
        }
    }

    /*************COPNTROLLERS MEDICOS*****************/

    public function nuevo_medico() {
        Session::put("mensaje","");
        return view('medicos.nuevo',["mensaje"=>"", "id"=>0, "nombres"=>"", "apellidos"=>"", "cedula"=>"", "especialidad"=>0, "telefono_hab"=>0, "telefono_cel"=>0, "sexo"=>0, "fecha_nacimiento"=>"", "email"=>"", "direccion"=>"", "pregunta_secreta"=>"", "respuesta_secreta"=>"", "tipo_recepcion"=>0, "twitter"=>"", "facebook"=>""]);
    }

    public function consultarmedico($id)
    {
        $medicos=Medicos::findOrFail($id);
        return view::make('medicos.edit', compact('medicos'));
    }        

    public function guardar_usuario_edicion (Request $request) {
        $id=$request->id;
        $medicos=Medicos::findOrFail($id);
        $especialidad=$request->especialidad;
        /*$especialidad=substr($especialidad,0,strlen($especialidad)-1);*/

        $foto=Input::file('foto');
        
        if ($foto) {
            $carpeta=$id;
            if (Input::file('foto')->isValid()) {
                $destinationPath = 'users/' . $carpeta; // upload path
                $extension = Input::file('foto')->getClientOriginalExtension(); // getting image extension
                if (!is_dir($destinationPath))
                    mkdir($destinationPath);

                $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                Input::file('foto')->move($destinationPath, $fileName); // uploading file to given path
            }
        }
        $medicos->fill($request->all());
        $id_especialidad=FuncionesControllers::obtener_id_especialidad($especialidad);

        $id_tipo_recepcion="";
        //dd($request->all());

        $sql = "select * from maestro where padre='tipo_recepcion' order by id_campo";
        $data = DB::select($sql);

        foreach ($data as $data) {
            if ($request->has('tipo_recepcion_'.$data->id_campo))
                $id_tipo_recepcion.=$data->id_campo.",";
        }

        $id_tipo_recepcion=substr($id_tipo_recepcion,0,strlen($id_tipo_recepcion)-1);
        $medicos->id_tipo_recepcion=$id_tipo_recepcion;

        $medicos->fecha_nacimiento=FuncionesControllers::fecha_mysql($request->fecha_nacimiento);
        $medicos->id_especialidad=$id_especialidad;
        if ($foto)
            $medicos->foto=$fileName;
        $medicos->save();
        /************************* EMAIL A ENVIAR ***************************/
        //FuncionesControllers::enviar_email('usuario',$request->all(),'Modificacion Usuario',$request->email,'');
        //FuncionesControllers::enviar_email('usuario',$request->all(),'Modificacion Usuario','jeleicy@gmail.com','');
        /************************* EMAIL A ENVIAR ***************************/
        return view('generica.formainsertada', ["tipo"=>"medico"]);        
    }

    public function guardar_usuario_nuevo (Request $request) {
        //dd($request->all());

        $medicos = new Medicos($request->all());

        Session::put("mensaje","");
        
        $foto=Input::file('foto');
        $especialidad=$request->especialidad;
        /*$especialidad=substr($especialidad,0,strlen($especialidad)-1);*/

        $fileName = "";
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
            $id_especialidad=FuncionesControllers::obtener_id_especialidad($especialidad);

            $id_tipo_recepcion="";

            foreach ($request as $key=>$value) {
                if (strpos($key,"tipo_recepcion_") !== false)
                    $id_tipo_recepcion.=$value.",";
            }
            $id_tipo_recepcion=substr($id_tipo_recepcion,0,strlen($id_tipo_recepcion)-1);

            $medicos->id_tipo_recepcion=$id_tipo_recepcion;            

            $medicos->id_especialidad=$id_especialidad;
            $medicos->fecha_nacimiento=FuncionesControllers::fecha_mysql($request->fecha_nacimiento);
            
            $codigo=0;

            while ($codigo==0) {
                $codigo_confirmacion = str_random(30);
                $sql = "select * from medico where codigo_confirmacion='".$codigo_confirmacion."'";
                $data = DB::select($sql);
                if (empty($data))                
                    $codigo=1;
                else
                    $codigo=0;
            }

            $medicos->codigo_confirmacion=$codigo_confirmacion;
            $medicos->save();

            /************************* EMAIL A ENVIAR ***************************/
            //FuncionesControllers::enviar_email_confirmacion('confirmar',$codigo_confirmacion,'Nuevo Usuario',$request->email,'');
            //FuncionesControllers::enviar_email_confirmacion('confirmar',$codigo_confirmacion,'Nuevo Usuario','jeleicy@gmail.com','');
            /************************* EMAIL A ENVIAR ***************************/
            return view('generica.formainsertada', ["tipo"=>"medico"]);
        } else {
            Session::put("mensaje", "Hay otro usuario con el mismo email o cedula");
            return view('medicos.nuevo', ["mensaje" => "guardado", "id" => 0, "nombres"=>$request->nombres, "apellidos"=>$request->apellidos, "cedula"=>$request->cedula, "especialidad"=>$request->especialidad, "telefono_hab"=>$request->telefono_hab, "telefono_cel"=>$request->telefono_cel, "sexo"=>$request->sexo, "fecha_nacimiento"=>$request->fecha_nacimiento, "email"=>$request->email, "direccion"=>$request->direccion, "pregunta_secreta"=>$request->pregunta_secreta, "respuesta_secreta"=>$request->respuesta_secreta, "tipo_recepcion"=>$request->tipo_recepcion, "twitter"=>$request->twitter, "facebook"=>$request->facebook]);
        }
    }

    public static function consulta()
    {
        //
        $medicos = medicos::where('id_tipo_medico', '=', 2)->take(10)->get();
        
        $strDatos="[";
        $end_data = medicos::count();

        //'','','','id_especialidad','telefono_hab','telefono_cel','sexo','fecha_nacimiento','','direccion','contrasena','pregunta_secreta','respuesta_secreta','foto','id_tipo_recepcion','id_tipo_medico','activo'

        foreach ($medicos as $key=>$medicos) {
            $activo="<div id=\'autorizado_".$medicos->id."\'>";
            if ($medicos->activo==1) $activo.='<a href="javascript:;" onclick="activarmedico('.$medicos->id.')"><button class="btn btn-primary" style="margin-right: 5px;">Activo</button></a>';
            else $activo.='<a href="javascript:;" onclick="activarmedico('.$medicos->id.')"><button class="btn btn-danger" style="margin-right: 5px;">Inactivo</button></a>';
            $activo.="</div>";

            $strDatos.="['".$medicos->nombres." ".$medicos->apellidos."',";
            $strDatos.="'".$medicos->cedula."',";
            $strDatos.="'".$medicos->email."',";
            $strDatos.="'".$activo."','";
            //$strDatos.="'<a href=consultarmedico/".$medicos->id.">Consultar</a> | <a href=eliminarmedico/".$medicos->id.">Eliminar</a> | <a href=\'javascript:;\' onclick=\'activarmedico(".$medicos->id.")\'>Activar</a> | <a href=\'javascript:;\' onclick=\'setearclavemedico(".$medicos->id.")\'>Setear Clave</a>']";
            $strDatos.='<div class="btn-group"><a href="consultarmedico/'.$medicos->id.'"><button class="btn btn-default" type="button">Consultar</button></a><a href="javascript:;" onclick="eliminarmedico('.$medicos->id.')"><button class="btn btn-default" type="button">Eliminar</button></a><a href="javascript:;" onclick="setearclavemedico('.$medicos->id.')"><button class="btn btn-default" type="button">Setear Clave</button></a></div>\']';
            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="medicos";
        $strColumnas="{ title: \"Nombre\" },{ title: \"Nro de Colegio\" },{ title: \"Email\" },{ title: \"Activo\" },{ title: \"-\" }";
        $strtfoot="<th>Nombre</th><th>Nro de Colegio</th><th colspan=3>Email</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}"; 
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de Medicos";
        $strFiltro="No";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo, $strFiltro);
    }

    /*************COPNTROLLERS USUARIOS*****************/

    public function consulta_usuario_sist()
    {
        //
        return view::make('usuario.consulta');
    }    

    public function nuevo_usuario_sist() {
        Session::put("mensaje","");
        return view('usuario.nuevo',["mensaje"=>"", "id"=>0, "nombres"=>"", "apellidos"=>"", "cedula"=>"", "telefono_hab"=>0, "telefono_cel"=>0, "sexo"=>0, "fecha_nacimiento"=>"", "email"=>"", "direccion"=>"", "pregunta_secreta"=>"", "respuesta_secreta"=>"", "tipo_recepcion"=>0]);
    }

    public function consultarusuariosist($id)
    {
        $medicos=Usuarios::findOrFail($id);
        return view::make('usuario.edit', compact('usuario'));
    }        

    public function guardar_usuario_edicion_sist (Request $request) {
        $id=$request->id;
        $usuario=Usuarios::findOrFail($id);

        $foto=Input::file('foto');
        
        if ($foto) {
            $carpeta=$id;
            if (Input::file('foto')->isValid()) {
                $destinationPath = 'users/' . $carpeta; // upload path
                $extension = Input::file('foto')->getClientOriginalExtension(); // getting image extension
                if (!is_dir($destinationPath))
                    mkdir($destinationPath);

                $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                Input::file('foto')->move($destinationPath, $fileName); // uploading file to given path
            }
        }
        echo "file=".$medicos->foto;         
        $medicos->fill($request->all());
        if ($foto)
            $medicos->foto=$fileName;
        $medicos->save();        
    
        /************************* EMAIL A ENVIAR ***************************/
        //FuncionesControllers::enviar_email('usuario',request->all(),'Nuevo Usuario',$request->email,'');
        //FuncionesControllers::enviar_email('usuario',request->all(),'Nuevo Usuario','jeleicy@gmail.com','');
        /************************* EMAIL A ENVIAR ***************************/
        return view('generica.formainsertada', ["tipo"=>"usuario"]);        
    }

    public function guardar_usuario_nuevo_sist (Request $request) {
        $usuario = new Usuarios($request->all());

        Session::put("mensaje","");
        
        $foto=Input::file('foto');        

        $fileName = "";
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
            $usuario->id_tipo_medico='1';
            $usuario->activo='0';
            $usuario->foto=$fileName;
            $usuario->save();
            /************************* EMAIL A ENVIAR ***************************/
            //FuncionesControllers::enviar_email('usuario',request->all(),'Nuevo Usuario',$request->email,'');
            //FuncionesControllers::enviar_email('usuario',request->all(),'Nuevo Usuario','jeleicy@gmail.com','');
            /************************* EMAIL A ENVIAR ***************************/
            return view('generica.formainsertada', ["tipo"=>"usuario"]);
        } else {
            Session::put("mensaje", "Hay otro usuario con el mismo email o cédula");
            return view('usuario.nuevo', ["mensaje" => "guardado", "id" => 0, "nombres"=>$request->nombres, "apellidos"=>$request->apellidos, "cedula"=>$request->cedula, "telefono_hab"=>$request->telefono_hab, "telefono_cel"=>$request->telefono_cel, "sexo"=>$request->sexo, "fecha_nacimiento"=>$request->fecha_nacimiento, "email"=>$request->email, "direccion"=>$request->direccion, "pregunta_secreta"=>$request->pregunta_secreta, "respuesta_secreta"=>$request->respuesta_secreta, "tipo_recepcion"=>$request->tipo_recepcion]);
        }
    }

    public static function consulta_usuario()
    {
        //
        $usuario = Usuarios::where('id_tipo_medico', '=', 1)->take(10)->get();
        
        $strDatos="[";
        $end_data = Usuarios::count();

        //'','','','id_especialidad','telefono_hab','telefono_cel','sexo','fecha_nacimiento','','direccion','contrasena','pregunta_secreta','respuesta_secreta','foto','id_tipo_recepcion','id_tipo_medico','activo'

        foreach ($usuario as $key=>$usuario) {
            $activo="<div id=\'autorizado_".$usuario->id."\'>";
            if ($usuario->activo==1) $activo.='<a href="javascript:;" onclick="activarmedico('.$usuario->id.')"><button class="btn btn-primary" style="margin-right: 5px;">Activo</button></a>';
            else $activo.='<a href="javascript:;" onclick="activarmedico('.$usuario->id.')"><button class="btn btn-danger" style="margin-right: 5px;">Inactivo</button></a>';
            $activo.="</div>";

            $strDatos.="['".$usuario->nombres." ".$usuario->apellidos."',";
            $strDatos.="'".$usuario->cedula."',";
            $strDatos.="'".$usuario->email."',";
            $strDatos.="'".$activo."','";
            //<a href=consultarmedico/".$usuario->id.">Consultar</a> | <a href=eliminarmedico/".$usuario->id.">Eliminar</a> | <a href=\'javascript:;\' onclick=\'activarmedico(".$usuario->id.")\'>Activar</a> | <a href=\'javascript:;\' onclick=\'setearclavemedico(".$usuario->id.")\''>Setear Clave</a>']";
            $strDatos.='<div class="btn-group"><a href="consultarmedico/'.$usuario->id.'"><button class="btn btn-default" type="button">Consultar</button></a><a href="javascript:;" onclick="eliminarmedico('.$usuario->id.')"><button class="btn btn-default" type="button">Eliminar</button></a><a href="javascript:;" onclick="setearclavemedico('.$usuario->id.')"><button class="btn btn-default" type="button">Setear Clave</button></a></div>\']';

            if (! ($key == $end_data-1)==true) {
                $strDatos.=",";
            };
        }
        $strDatos.="]";
        $strTabla="medicos";
        $strColumnas="{ title: \"Nombre\" },{ title: \"Cedula\" },{ title: \"Email\" },{ title: \"Activo\" },{ title: \"-\" }";
        $strtfoot="<th>Nombre</th><th>Cedula</th><th colspan=3>Email</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]";
        $intCantidad=10;
        $strNombreArchivo="Listado de Usuarios";
        $strFiltro="No";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo, $strFiltro);
    }
}