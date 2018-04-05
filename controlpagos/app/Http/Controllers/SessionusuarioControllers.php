<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Redirect;
use App\Http\Controllers\FuncionesControllers;

class SessionusuarioControllers extends Controller
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

    /**
     * Store a newly created resource in storage.
     * POST /periodicos
     *
     * @return Response
     */
    public static function store($names,$lastnames,$id_usuario,$privilegio,$user,$pic,$activo,$id_tipo_medico)
    {
        //
        //$request = Request::create('http://localhost/medicos/public');
        //$ip=$request->ip();
        //echo "ip=".$ip;
        $ip = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);

        $request = Request::create('http://localhost/medicos/public');
        //id,fecha,hora,activa,nombre,apellido,id_usuario,privilegio,ip,usuario
        $sql = "insert into sesiones (fecha,hora,activa,nombre,apellido,id_usuario,privilegio,ip,usuario,token) ";
        $sql .= "values (current_date,now(),1,'$names','$lastnames',$id_usuario,'$privilegio',";
        $sql .= "'".$ip."','$user','".csrf_token()."')";
        
        Session::put("usuario",$user);
        Session::put("nombre",$names." ".$lastnames);
        Session::put("id_usuario",$id_usuario);
        Session::put("foto",$pic);
        Session::put("activo",$activo);
        Session::put("tipo",$id_tipo_medico);
        Session::put("id_medico",0);
        if ($id_tipo_medico==2)
            Session::put("id_medico",$id_usuario);

        DB::insert($sql);
    }

    /**
     * Display the specified resource.
     * GET /periodicos/{id}
     *
     * @param  int $id
     * @return Response
     */
    public static function show($campo)
    {
        //
        //$request = Request::create('http://localhost/medicos/public');
        //$sql = "select ".$campo." as valor from sesiones where ip='".$request->ip()."' and activa=1";
        $sql = "select ".$campo." as valor from sesiones where usuario='".Session::get("usuario")."' and activa=1";

        //echo $sql;
        $data=DB::select($sql);
        $dato=0;
        foreach ($data as $data)
            $dato = $data->valor;

        if ($dato=="0") {
            Redirect::to('dashboard/inicio');
        } else {
            return $dato;
        }
    }

    public static function validar_session($email) {
        $request = Request::create('http://localhost/medicos/public');
        $sql = "select * from sesiones where usuario='".$email."' and activa=1";
        $data=DB::select($sql);
        $dato=0;
        foreach ($data as $data)
            $dato = 1;

        if ($dato!=0)
            return 1;
        else
            return 0;
    }

    /**
     * Show the form for editing the specified resource.
     * GET /periodicos/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT /periodicos/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /periodicos/{id}
     *
     * @param  int $id
     * @return Response
     */
    public static function destroy()
    {
        //

        $request = Request::create('http://localhost/medicos/public');
        //$sql = "update sesiones set activa=0 where ip='".$request->ip()."'";
        $sql = "update sesiones set activa=0 where usuario='".Session::get("usuario")."'";

        DB::update($sql);
        Session::put('mensaje',"");
        //Redirect::to('dashboard/inicio');
        //return view('dashboard.inicio');
    }

}