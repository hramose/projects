<?php

use App\Http\Controllers\FuncionesControllers;

use App\paciente;
use App\datos_cirugia;

/*
|--------------------------------------------------------------------------
| Routes file(filename)
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

    Route::get('/', function () {
        return view('inicio.inicio')->with('mensaje','');
    });

    Route::get('test', function () {
        return view('test');
    });

    Route::get('index', function () {
        return View::make('dashboard.index');
    });

    Route::get('cerrar_session', array(
        'as' => 'cerrar_session',
        'uses' => 'UserControllers@logout'
    ));    

    /*MEDICOS*/

    Route::post('verificar_usuario', array(
        'as' => 'verificar_usuario',
        'uses' => 'UserControllers@verificar_usuario'
    ));

    Route::post('olvido_contrasena/{email}', array(
        'as' => 'olvido_contrasena',
        'uses' => 'UserControllers@olvido_contrasena'
    ));    

    Route::get('nuevo_medico', array(
        'as' => 'nuevo_medico',
        'uses' => 'UserControllers@nuevo_medico'
    ));

    Route::post('guardar_usuario_nuevo', array(
        'as' => 'guardar_usuario_nuevo',
        'uses' => 'UserControllers@guardar_usuario_nuevo'
    ));

    Route::put('guardar_usuario_edicion', array(
        'as' => 'guardar_usuario_edicion',
        'uses' => 'UserControllers@guardar_usuario_edicion'
    ));

    Route::get('consulta_medicos', array(
        'as' => 'consulta_medicos',
        'uses' => 'UserControllers@index'
    ));

    Route::get('consultarmedico/{id}', array(
        'as' => 'consultarmedico',
        'uses' => 'UserControllers@consultarmedico'
    ));

    /*USUARIOS*/

    Route::get('nuevo_usuario_sist', array(
        'as' => 'nuevo_usuario_sist',
        'uses' => 'UserControllers@nuevo_usuario_sist'
    ));

    Route::post('guardar_usuario_nuevo_sist', array(
        'as' => 'guardar_usuario_nuevo_sist',
        'uses' => 'UserControllers@guardar_usuario_nuevo_sist'
    ));

    Route::put('guardar_usuario_nuevo_sist', array(
        'as' => 'guardar_usuario_nuevo_sist',
        'uses' => 'UserControllers@guardar_usuario_nuevo_sist'
    ));

    Route::get('consulta_usuario_sist', array(
        'as' => 'consulta_usuario_sist',
        'uses' => 'UserControllers@consulta_usuario_sist'
    ));

    Route::get('consultarusuariosist/{id}', array(
        'as' => 'consultarusuariosist',
        'uses' => 'UserControllers@consultarusuariosist'
    ));    

    /*PACIENTE*/

    Route::post('guardar_paciente_nuevo', array(
        'as' => 'guardar_paciente_nuevo',
        'uses' => 'PacienteControllers@guardar_paciente_nuevo'
    ));

    Route::put('guardar_paciente_edicion', array(
        'as' => 'guardar_paciente_edicion',
        'uses' => 'PacienteControllers@guardar_paciente_edicion'
    ));

    Route::get('consulta_paciente', array(
        'as' => 'consulta_paciente',
        'uses' => 'PacienteControllers@index'
    ));

    Route::get('consultarpaciente/{id}', array(
        'as' => 'consultarpaciente',
        'uses' => 'PacienteControllers@consultarpaciente'
    ));    
    
    Route::get('nuevo_paciente', array(
        'as' => 'nuevo_paciente',
        'uses' => 'PacienteControllers@nuevo_paciente'
    ));

    /*CLINICA*/

    Route::post('guardar_clinica_nuevo', array(
        'as' => 'guardar_clinica_nuevo',
        'uses' => 'ClinicaControllers@guardar_clinica_nuevo'
    ));

    Route::put('guardar_clinica_edicion', array(
        'as' => 'guardar_clinica_edicion',
        'uses' => 'ClinicaControllers@guardar_clinica_edicion'
    ));

    Route::get('consulta_clinica', array(
        'as' => 'consulta_clinica',
        'uses' => 'ClinicaControllers@index'
    ));

    Route::get('consultarclinicas/{id}', array(
        'as' => 'consultarclinicas',
        'uses' => 'ClinicaControllers@consultarclinicas'
    ));    
    
    Route::get('nuevo_clinica', array(
        'as' => 'nuevo_clinica',
        'uses' => 'ClinicaControllers@nuevo_clinica'
    ));    

    /*SEGUROS*/

    Route::post('guardar_seguro_nuevo', array(
        'as' => 'guardar_seguro_nuevo',
        'uses' => 'SeguroControllers@guardar_seguro_nuevo'
    ));

    Route::put('guardar_seguro_edicion', array(
        'as' => 'guardar_seguro_edicion',
        'uses' => 'SeguroControllers@guardar_seguro_edicion'
    ));

    Route::get('consulta_seguro', array(
        'as' => 'consulta_seguro',
        'uses' => 'SeguroControllers@index'
    ));

    Route::get('consultarseguro/{id}', array(
        'as' => 'consultarseguro',
        'uses' => 'SeguroControllers@consultarseguro'
    ));    
    
    Route::get('nuevo_seguro', array(
        'as' => 'nuevo_seguro',
        'uses' => 'SeguroControllers@nuevo_seguro'
    ));

    /*MONEDA*/

    Route::post('guardar_moneda_nuevo', array(
        'as' => 'guardar_moneda_nuevo',
        'uses' => 'MonedaControllers@guardar_moneda_nuevo'
    ));

    Route::put('guardar_moneda_edicion', array(
        'as' => 'guardar_moneda_edicion',
        'uses' => 'MonedaControllers@guardar_moneda_edicion'
    ));

    Route::get('consulta_moneda', array(
        'as' => 'consulta_moneda',
        'uses' => 'MonedaControllers@index'
    ));

    Route::get('consultarmoneda/{id}', array(
        'as' => 'consultarmoneda',
        'uses' => 'MonedaControllers@consultarmoneda'
    ));    
    
    Route::get('nuevo_moneda', array(
        'as' => 'nuevo_moneda',
        'uses' => 'MonedaControllers@nuevo_moneda'
    ));

   /*ESPECIALIDAD*/

    Route::post('guardar_especialidad_nuevo', array(
        'as' => 'guardar_especialidad_nuevo',
        'uses' => 'EspecialidadControllers@guardar_especialidad_nuevo'
    ));

    Route::put('guardar_especialidad_edicion', array(
        'as' => 'guardar_especialidad_edicion',
        'uses' => 'EspecialidadControllers@guardar_especialidad_edicion'
    ));

    Route::get('consulta_especialidad', array(
        'as' => 'consulta_especialidad',
        'uses' => 'EspecialidadControllers@index'
    ));

    Route::get('consultarespecialidad/{id}', array(
        'as' => 'consultarespecialidad',
        'uses' => 'EspecialidadControllers@consultarespecialidad'
    ));    
    
    Route::get('nuevo_especialidad', array(
        'as' => 'nuevo_especialidad',
        'uses' => 'EspecialidadControllers@nuevo_especialidad'
    ));

    /*CIRUGIAS*/

    Route::get('nuevo_cirugia', array(
        'as' => 'nuevo_cirugia',
        'uses' => 'CirugiasControllers@nuevo_cirugia'
    ));

    Route::post('guardar_cirugia_nuevo', array(
        'as' => 'guardar_cirugia_nuevo',
        'uses' => 'CirugiasControllers@guardar_cirugia_nuevo'
    ));

    Route::post('guardar_cirugia_edicion', array(
        'as' => 'guardar_cirugia_edicion',
        'uses' => 'CirugiasControllers@guardar_cirugia_edicion'
    ));    

    Route::get('consulta_cirugia', array(
        'as' => 'consulta_cirugia',
        'uses' => 'CirugiasControllers@index'
    ));

    Route::post('consulta_cirugia_2', array(
        'as' => 'consulta_cirugia_2',
        'uses' => 'CirugiasControllers@consulta_cirugia_2'
    ));

    Route::get('consulta_cirugia_3', array(
        'as' => 'consulta_cirugia_3',
        'uses' => 'CirugiasControllers@consulta_cirugia_3'
    ));

    Route::get('consultarcirugia/{id}', array(
        'as' => 'consultarcirugia',
        'uses' => 'CirugiasControllers@consultarcirugia'
    ));

    Route::get('eliminarcirugia/{id}', array(
        'as' => 'eliminarcirugia',
        'uses' => 'CirugiasControllers@eliminarcirugia'
    ));    

    Route::get('solo_cirugia', array(
        'as' => 'solo_cirugia',
        'uses' => 'CirugiasControllers@solo_cirugia'
    ));

    Route::post('guardar_edicion_solo_cirugia', array(
        'as' => 'guardar_edicion_solo_cirugia',
        'uses' => 'CirugiasControllers@guardar_edicion_solo_cirugia'
    ));

    Route::post('guardar_solo_cirugia', array(
        'as' => 'guardar_solo_cirugia',
        'uses' => 'CirugiasControllers@guardar_solo_cirugia'
    ));


    Route::get('alta_cirugia', array(
        'as' => 'alta_cirugia',
        'uses' => 'CirugiasControllers@alta_cirugia'
    ));

    /*PAGOS*/

    Route::get('nuevo_pago', array(
        'as' => 'nuevo_pago',
        'uses' => 'PagosControllers@nuevo_pago'
    ));

    Route::get('nuevo_pago_deudas', array(
        'as' => 'nuevo_pago_deudas',
        'uses' => 'PagosControllers@nuevo_pago_deudas'
    ));


    Route::get('nuevo_pago_deudas_2', array(
        'as' => 'nuevo_pago_deudas_2',
        'uses' => 'PagosControllers@nuevo_pago_deudas_2'
    ));    

    Route::get('consultarclinica/{id}', array(
        'as' => 'consultarclinica',
        'uses' => 'PagosControllers@consultarclinica'
    ));

    Route::post('guardar_pago_nuevo', array(
        'as' => 'guardar_pago_nuevo',
        'uses' => 'PagosControllers@guardar_pago_nuevo'
    ));

    Route::post('guardar_pago_nuevo_factura', array(
        'as' => 'guardar_pago_nuevo_factura',
        'uses' => 'PagosControllers@guardar_pago_nuevo_factura'
    ));

    Route::get('consulta_pago', array(
        'as' => 'consulta_pago',
        'uses' => 'PagosControllers@index'
    ));

    Route::post('consulta_pago_2', array(
        'as' => 'consulta_pago_2',
        'uses' => 'PagosControllers@consulta_pago_2'
    ));

    Route::post('buscar_consultas_pagos', array(
        'as' => 'buscar_consultas_pagos',
        'uses' => 'PagosControllers@buscar_consultas_pagos'
    ));  

    Route::post('buscar_consultas_pagos_2', array(
        'as' => 'buscar_consultas_pagos_2',
        'uses' => 'PagosControllers@buscar_consultas_pagos_2'
    ));

    Route::get('cargarfactura/{datos}', array(
        'as' => 'cargarfactura',
        'uses' => 'PagosControllers@cargarfactura'
    ));

    Route::get('cargarpago/{datos}', array(
        'as' => 'cargarpago',
        'uses' => 'PagosControllers@cargarpago'
    ));     

    /*REPORTES*/

    Route::get('rpts/{ruta}', array(
        'as' => 'reportes',
        'uses' => 'ReportesControllers@rpts'
    ));

/**********************************AJAX***************************/

Route::post('index_proceso_autorizar', function () {
    if(Request::ajax()) {
        $datos = Input::all();
        $sql = "select activo from medico where id=".$datos['id'];
        $data=DB::select($sql);
        foreach ($data as $data) {
            if ($data->activo==1) {
                $sql = "update medico set activo=0 ";
                $tipo="Inactivo";
                $clase="danger";
            } else {
                $sql = "update medico set activo=1 ";
                $tipo="Activo";
                $clase="primary";
            }
        }

        $sql .= "where id=".$datos["id"];
        DB::update($sql);
    }
    $resultado = '<a href="javascript:;" onclick="activarmedico('.$datos['id'].')"><button class="btn btn-'.$clase.'" style="margin-right: 5px;">'.$tipo.'</button></a>';
    //$resultado = '<button class="btn btn-'.$clase.'" style="margin-right: 5px;">'.$tipo.'</button>';
    return Response::json(array(
        'resultado' => $resultado,
    ));
    die;
});

Route::post('index_seteo_contrasena', function () {
    if(Request::ajax()) {
        $datos = Input::all();
        $sql = "select email from medico where id=".$datos["id"];
        $data=DB::select($sql);
        foreach ($data as $data)
            $email=$data->email;
        $clave=FuncionesControllers::generarClave();
        $sql = "update medico set contrasena='".hash('ripemd160', $clave)."' ";
        $sql .= "where id=".$datos["id"];
        DB::update($sql);
    }
    $resultado = $clave;
    //FuncionesControllers::enviar_email('contrasena',$datos,'Reenvio de Contraseña',$email,$clave);
    return Response::json(array(
        'resultado' => $resultado,
    ));
    die;
});

Route::post('index_buscar_clinica', function () {
    if(Request::ajax()) {
        $datos = Input::all();
        $sql = "select * from clinica where id=".$datos["id_clinica"];
        $data=DB::select($sql);
        $resultado="";
        foreach ($data as $data) {
             $resultado.= '<div class="item form-group">    
                <label class="control-label col-xs-3">Nombre:</span></label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input readonly id="item1" name="item1" type="text" class="form-control"value="'.$data->nombre.'">
                    </div>
            </div>';
             $resultado.= '<div class="item form-group">    
                <label class="control-label col-xs-3">Dirección:</span></label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <textarea readonly id="item1" name="item1">'.$data->direccion.'</textarea>
                    </div>
            </div>';
             $resultado.= '<div class="item form-group">    
                <label class="control-label col-xs-3">Ciudad:</span></label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input readonly id="item1" name="item1" type="text" class="form-control"value="'.$data->ciudad.'">
                    </div>
            </div>';
            $resultado.= '<div class="item form-group">    
                <label class="control-label col-xs-3">Pais:</span></label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input readonly id="item1" name="item1" type="text" class="form-control"value="'.FuncionesControllers::buscar_pais($data->pais).'">
                    </div>
            </div>';
        }
    }
    return Response::json(array(
        'resultado' => $resultado,
    ));
    die;
});

Route::post('index_buscar_especialidad', function () {
    if(Request::ajax()) {
        $datos = Input::all();
        $sql = "select id_especialidad from medico where cedula='".$datos["cedula"]."' and id_tipo_medico=2";
        $data=DB::select($sql);
        $resultado="";
        foreach ($data as $data)
            $especialidad=$data->id_especialidad;

        $especialidad=substr($especialidad,0,strlen($especialidad)-1);

        if (is_null($especialidad))
            $resultado.="Este medico no posee especialidades";
        else {
            $id_especialidad=explode(",",$especialidad);            
            for ($i=0; $i<count($id_especialidad); $i++) {
                $sql = "select * from especialidad where id=".$id_especialidad[$i];
                $data = DB::select($sql);
                foreach ($data as $data)
                     /*$resultado.= '<div class="checkbox">
                      <label><input name="id_especialidad" type="radio" value="'.$id_especialidad[$i].'">'.$data->nombre.'</label>
                    </div>';*/

                    $resultado.='
                        <input class="styled" name="id_especialidad" id="id_especialidad" type="radio" value="'.$id_especialidad[$i].'"> <label>'.$data->nombre.'</label>
                    <br />';

            }
        }
    }
    return Response::json(array(
        'resultado' => $resultado,
    ));
    die;
});

Route::post('index_buscar_medico', function () {
    if(Request::ajax()) {
        $datos = Input::all();
        $sql = "select * from medico where cedula='".$datos["cedula"]."' and id_tipo_medico=2";
        $data=DB::select($sql);
        $resultado="";
        if (empty($data))
            $resultado="El número de colegio introducido no pertenece a ningun medico";
        else {
            foreach ($data as $data) {
                Session::put("id_medico",$data->id);
                $resultado.= '<div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre:</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input readonly id="item1" name="item1" type="text" class="form-control"value="'.strtoupper($data->nombres." ".$data->apellidos).'">
                        </div>
                </div>';
                 $resultado.= '<div class="item form-group">    
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nro Colegio:</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input readonly id="item1" name="item1" type="text" class="form-control"value="'.$data->cedula.'">
                        </div>
                </div>';
                $resultado.= '<div class="item form-group">    
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Foto:</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">';
                        if ($data->foto!="")
                            $resultado .= '<img height="50" width="50" src="users/'.$data->id.'/'.$data->foto.'">';
                        else
                            $resultado .= '<img src="users/generico.jpg">';
                $resultado .= '</div>
                </div>';
            }
        }
    }
    return Response::json(array(
        'resultado' => $resultado,
    ));
    die;
});

Route::post('index_guardar_paciente', function () {
    if(Request::ajax()) {
        //$datos = Input::all();

        $paciente = new paciente(Input::all());
        $paciente->save();
        $resultado="Paciente insertado satisfactoriamente";

    }
    return Response::json(array(
        'resultado' => $resultado,
    ));
    die;
});

Route::post('index_buscar_paciente_medico', function () {
    if(Request::ajax()) {
        $datos = Input::all();
        $resultado="";
        $cedula=$datos["cedula"];

        if (empty($data)) {
            // ¿EXISTE PACIENTE?
            $sql = "select * from paciente where cedula='".$cedula."'";
            $data = DB::select($sql);
            if (empty($data))
                // NO EXISTE
                $resultado="sale 1";
            else {
                // SI EXISTE
                // ¿TIENE CIRUGIA?
                foreach ($data as $data) $id_paciente=$data->id;
                $sql = "select * from cirugias where id_paciente=".$id_paciente;
                $data = DB::select($sql);
                if (empty($data))
                    //NO TIENE CIRUGIA
                    $resultado="sale 2";
                else {
                    $cantidad_cirugia=count($data);
                    // SI TIENE CIRUGIA
                    // ¿TIENE ALTA?
                    $sql = "select c.id_paciente 
                        from alta a, cirugias c, paciente p
                        where c.id in (select id_cirugia from alta) and 
                            c.id=a.id_cirugia and p.id=c.id_paciente and p.cedula='".$cedula."' and 
                            c.id_medico=".Session::get("id_medico")." and p.id_medico=".Session::get("id_medico");
                    $data = DB::select($sql);
                    $cantidad_altas=count($data);
                    //echo "cantidad_cirugia=$cantidad_cirugia....cantidad_altas=$cantidad_altas";
                    if (!empty($data) && $cantidad_cirugia==$cantidad_altas)
                        // SI TIENE ALTA
                        $resultado="sale 3";
                    else {
                        // NO TIENE ALTA
                        $resultado="no sale";
                        /*$sql = "select c.id_paciente 
                            from alta a, cirugias c, paciente p
                            where c.id not in (select id_cirugia from alta) and 
                                c.id=a.id_cirugia and p.id=c.id_paciente and p.cedula='".$cedula."' and 
                                c.id_medico=".Session::get("id_medico")." and p.id_medico=".Session::get("id_medico");
                        $data = DB::select($sql);
                        if (empty($data))
                            $resultado="Este paciente aun no ha sido dado de alta";*/
                    }
                }
            }
        }
    }
    return Response::json(array(
        'resultado' => $resultado,
    ));
    die;
});

Route::post('index_buscar_paciente', function () {
    if(Request::ajax()) {

        $datos = Input::all();
        $resultado="";
        $id_clinica=$datos["id_clinica"];
        $cedula=$datos["cedula"];
        $nro_historia=$datos["nro_historia"];
        $nuevo_ingreso="";

        $sql = "select c.id_paciente from alta a, cirugias c where c.id=a.id_cirugia and c.id_medico=".Session::get("id_medico");
        $data = DB::select($sql);

        if (!empty($data))
            $resultado="Este paciente aun no ha sido dado de alta";

        /*$nuevo_ingreso= "<form name='forma' methos='post' class='form-horizontal'>";
        $nuevo_ingreso.='
            <div class="item form-group">
                <label class="control-label col-xs-3">Nombres <span class="msj">(*)</span>:</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input id="nombres" name="nombres" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombres" value="">
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input id="apellidos" name="apellidos" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Apellidos" value="">
                </div>
            </div>
            <div class="item form-group">
                <label class="control-label col-xs-3">Cedula <span class="msj">(*)</span>:</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input id="cedula" name="cedula" type="text" class="form-control" placeholder="Cedula" readonly required="required" value="'.$cedula.'">
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-xs-3">Edad <span class="msj">(*)</span>:</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input id="edad" name="edad" type="number" class="form-control" data-validate-minmax="0,110" required="required" placeholder="Edad" value="">
                </div>
            </div>
        ';
        $nuevo_ingreso.='<br />
        <div class="ln_solid"></div>
        <div class="form-group" align="center">
            <input type="button" value="Guardar" class="btn btn-primary" onclick="guardar_paciente(this.form)">
        </div>
        </form>';        

        if ($nro_historia=="" && $cedula!="") {
            $sql = "select * from paciente where cedula='".$cedula."'";
            $data1=DB::select($sql);
            if (empty($data1)) {
                $resultado="La Cedula introducida no existe. Debe ingresarlo como nuevo paciente.<br /><br />";
                $resultado.=$nuevo_ingreso;
            } else {
                foreach ($data1 as $data1) {
                    $resultado.= FuncionesControllers::llenar_paciente($data1->nombres,$data1->apellidos,$data1->cedula,$data1->edad);
                    $resultado.= '<div class="item form-group">    
                    <label class="control-label col-xs-3">Clinica:</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">'.FuncionesControllers::buscar_clinica($id_clinica).'</div>
                    </div>';
                    $sql = "select nh.nro_historia from paciente p, nro_historia nh, clinica c ";
                    $sql .= "where p.id=nh.id_paciente and nh.id_clinica=c.id and p.id=".$data1->id;
                    $sql .= " and c.id=".$id_clinica;
                    $data3=DB::select($sql);
                    if (!empty($data3)) {
                        foreach ($data3 as $data3) {
                            $resultado.= '<div class="item form-group">    
                            <label class="control-label col-xs-3">Nro de Historia:</span></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input readonly id="item1" name="item1" type="text" class="form-control"value="'.$data3->nro_historia.'">
                                </div>
                            </div>';
                        }
                    } else {
                        $resultado.= '<div class="item form-group">    
                        <label class="control-label col-xs-3">Nro de Historia:</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                Este paciente no posee historia en esta clinica, para agregarlo debe tipearla en la parte superior.
                            </div>
                        </div>';
                    }
                }
            }
        } elseif ($nro_historia!="" && $cedula=="") {
            $sql = "select * from nro_historia where id_clinica=".$id_clinica;
            $sql .= " and nro_historia='".$nro_historia."'";
            $data2=DB::select($sql);
            if (empty($data2)) {
                $resultado="El nro de historia no existe. ";
                $resultado.=$nuevo_ingreso;
            } else {
                foreach ($data2 as $data2)
                    $id_paciente=$data1->id;
                $sql = "select p.* from paciente p, nro_historia nh, clinica c ";
                $sql .= "where p.id=nh.id_paciente and nh.id_clinica=id_clinica and p.id=".$id_paciente;
                $sql .= " and c.id=".$id_clinica;
                $data3=DB::select($sql);
                if (!empty($data3)) {
                    foreach ($data3 as $data3) {
                        $resultado.= FuncionesControllers::llenar_paciente($data3->nombres,$data3->apellidos,$data3->cedula,$data3->edad);
                        $resultado.= '<div class="item form-group">    
                        <label class="control-label col-xs-3">Nro de Historia:</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input readonly id="item1" name="item1" type="text" class="form-control"value="'.$data3->nro_historia.'">
                            </div>
                        </div>';
                    }
                }
            }
        } else {
            $sql = "select p.* from paciente p, nro_historia nh, clinica c ";
            $sql .= "where p.id=nh.id_paciente and nh.id_clinica=id_clinica and p.cedula='".$cedula."'";
            $sql .= " and nh.nro_historia=".$nro_historia." and c.id=".$id_clinica;
            $data=DB::select($sql);
            foreach ($data as $data)
                $resultado.= FuncionesControllers::llenar_paciente($data->nombres,$data->apellidos,$data->cedula,$data->edad);
        }*/
    }
    return Response::json(array(
        'resultado' => $resultado,
    ));
    die;
});

Route::post('index_proceso_respsec', function () {
    if(Request::ajax()) {
        $datos = Input::all();

        $sql = "select respuesta from medico where id=".$datos['id'];
        $data = DB::select($sql);
        $resultado=$sql;
        /*if (!empty($data)) {
            foreach($data as $data)
                $respuesta=$data->respuesta_secreta;

            if ($respuesta==$datos["respuesta"]) {
                $resultado .= '<div class="item form-group">
                    <label class="control-label col-xs-3">Nueva Contrase&ntilde;a:</label>
                        <div class="col-xs-9">
                            <input name="contrasena1" type="password" class="form-control" placeholder="Nueva Contrasena" value="">
                        </div>
                    </div>
                ';
            }
        } else {
            $mensaje = "La respuesta introducida no es correcta, intente nuevamente...!!!";
            $resultado .= "<br /><br /><div class='error' align='center'>".$mensaje."</div><br /><br />";            
        }*/
    }
    //$resultado = $sql;
    return Response::json(array(
        'resultado' => $resultado,
    ));
    die;
});

Route::post('ya_no_va', function () {
    if(Request::ajax()) {
        /*$datos = Input::all();

        $sql = "select respuesta from medico where id=".$datos["id"];
        $data = DB::select($sql);
        $resultado="";
        foreach($data as $data)
            $respuesta=$data->respuesta;
        if ($respuesta==$datos["respuesta"]) {
            $resultado .= '<div class="item form-group">
                <label class="control-label col-xs-3">Nueva Contrase&ntilde;a:</label>
                    <div class="col-xs-9">
                        <input name="contrasena1" type="password" class="form-control" placeholder="Nueva Contrasena" value="">
                    </div>
                </div>
            ';
            $resultado .= '<div class="item form-group">
                <label class="control-label col-xs-3">Nuevamente su Contrase&ntilde;a:</label>
                    <div class="col-xs-9">
                        <input name="contrasena2" type="password" class="form-control" placeholder="Nuevamente su Contrasena" value="">
                    </div>
                </div>
            ';

            $resultado .= '<div class="item form-group">
                    <div class="col-xs-offset-3 col-xs-9">
                        <input  class="btn btn-primary" type="button" name="Validar2" value="Validar Contrasena" onclick="validar_contrasena(this.form)" />
                    </div>
                </div>
            ';
        } else {
            $mensaje = "La respuesta introducida no es correcta, intente nuevamente...!!!";
            $resultado .= "<br /><br /><div class='error' align='center'>".$mensaje."</div><br /><br />";
        }*/
        //$resultado=$sql;
        return Response::json(array(
            'resultado' => 'listo',
        ));
        die;
    }
});

Route::post('index_agregar_seguro', function () {
    if(Request::ajax()) {
        $datos = Input::all();

        $id=$datos["id"];

        $resultado="";
        $resultado.= '<div class="form-group" id="seguromonto_'.$id.'">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Seguro / Monto</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <input required="required" type="text" name="seguro'.$id.'" id="seguro'.$id.'" class="form-control col-md-10" style="float: left;" />
                <div id="autocomplete-seguro'.$id.'" style="position: relative; float: left; width: 400px; margin: 10px;"></div>
                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
            </div>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <input placeholder="Monto" type="text" class="form-control col-md-10" name="monto'.$id.'" id="monto'.$id.'" value="0">
                <span class="fa fa-money form-control-feedback right" aria-hidden="true"></span>            
                <script type="text/javascript">$(\'#monto'.$id.'\').priceFormat();</script>
            </div>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <a href="javascript:;" onclick="agregar_seguro('.$id.')"><i class="fa fa-plus-square"></i></a>            
                <a href="javascript:;" onclick="quitar_seguro('.$id.')"><i class="fa fa-minus-square"></i></a>
            </div>
        </div>';

        $resultado.= '
            <script type="text/javascript">
                $(function () {
                    \'use strict\';
                    var segurosArray = $.map(seguros, function (value, key) {
                        return {
                            value: value,
                            data: key
                        };
                    });
                    // Initialize autocomplete with custom appendTo:
                    $(\'#seguro'.$id.'\').autocomplete({
                        lookup: segurosArray,
                        appendTo: \'#autocomplete-seguro'.$id.'\'
                    });
                });
            </script>   
        ';
    }

    $id++;
    Session::put("id",$id);

    return Response::json(array(
        'resultado' => $resultado,
    ));
    die;
});

Route::post('index_eliminar_detalle', function () {
    if(Request::ajax()) {
        $datos = Input::all();
        $resultado="";

        $id_datos_cirugia=$datos["id"];
        $id_cirugia=$datos["id_cirugia"];

        $sql = "delete from datos_cirugia where id_datos_cirugia=".$id_datos_cirugia;
        DB::delete($sql);

        $resultado=FuncionesControllers::crear_tabla_detalle_cirugia($id_cirugia);
        //$resultado="listo eliminar...";
    }

    return Response::json(array(
        'resultado' => $resultado,
    ));
    die;
});

Route::post('index_guardar_detalle', function () {
    if(Request::ajax()) {
        $datos = Input::all();
        $resultado="";
        $id_cirugia=$datos["id_cirugia"];

        $datos_cirugia = new datos_cirugia($datos);
        $datos_cirugia->id_cirugia=$id_cirugia;
        $datos_cirugia->observaciones=$datos["observaciones"];
        $datos_cirugia->referencias=$datos["referencias"];
        $datos_cirugia->habitacion=$datos["habitacion"];
        $datos_cirugia->fecha_carga=FuncionesControllers::fecha_mysql($datos["fecha_carga"]);
        if ($datos["fecha_alta"]!="")
            $datos_cirugia->fecha_alta=FuncionesControllers::fecha_mysql($datos["fecha_alta"]);

        $datos_cirugia->save();

        $resultado=FuncionesControllers::crear_tabla_detalle_cirugia($id_cirugia);
        //$resultado="listo guardar...";
    }

    return Response::json(array(
        'resultado' => $resultado,
    ));
    die;
});

Route::post('index_generar_atencion', function () {
    if(Request::ajax()) {
        $datos = Input::all();
        $resultado="";
        $valor=$datos["valor"];
        $tipo="";

        if ($valor=="CIRUGIA") {
            $resultado .= '
                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Rol:</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div id="datos_rol">'.FuncionesControllers::opciones_check('rol', 0, 0).'</div>
                    </div>
                </div>
                ';
                $tipo="readonly";
        }
        $resultado .= '
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3">Monto del Tipo de Atencion:</label>
                <div class="col-md-6 col-sm-6 col-xs-9">                    
                    <input data-validate-minmax="1,999999999" maxlength="11" '.$tipo.' placeholder="Monto" type="text" class="form-control col-md-10" name="monto" id="monto" value="0">                    
                    <script type="text/javascript">$(\'#monto\').priceFormat();</script>
                </div>
            </div>
        ';
        if ($valor=="CIRUGIA") {
            $resultado .= '
                <div id="observ_otro_rol" style="display: none">
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Observaciones de Otro Rol</label>
                        <div class="col-md-6 col-sm-6 col-xs-9">
                            <input maxlength="100" disabled id="otro_rol" name="otro_rol" type="text" data-validate-words="1" class="form-control" placeholder="Observaciones de Otro Rol" value="">
                        </div> 
                    </div>
                </div>

                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Nombre Cirugia <span class="msj">(*)</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-9">
                        <input maxlength="100" id="nombre_cirugia" name="nombre_cirugia" type="text" data-validate-words="1" required="required" class="form-control" placeholder="Nombre Cirugia" value="">
                    </div>
                </div>

                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Cirujano <span class="msj">(*)</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-9">
                        <input id="cirujano" maxlength="60" name="cirujano" type="text" data-validate-words="1" required="required" class="form-control" placeholder="Cirujano" value="">
                    </div>
                </div>

                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Nro Historia Paciente</label>
                    <div class="col-md-6 col-sm-6 col-xs-9">
                        <input id="nro_historia" maxlength="10" name="nro_historia" type="text" data-validate-words="1" class="form-control" placeholder="Nro Historia Paciente" value="">
                    </div> 
                </div>
            ';            
        }
        
        $resultado .= '
                <div class="form-group" id="clinicamonto">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Clinica</label>
                    <div class="col-md-6 col-sm-6 col-xs-9">
                        <input required="required" maxlength="100" type="text" name="clinica" id="clinica" class="form-control col-md-10" style="float: left;" />
                        <div id="autocomplete-clinica" style="position: relative; float: left; width: 400px; margin: 10px;"></div>
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>

                <script type="text/javascript">
                    $(function () {
                        \'use strict\';
                        var segurosArray = $.map(clinicas, function (value, key) {
                            return {
                                value: value,
                                data: key
                            };
                        });
                        // Initialize autocomplete with custom appendTo:
                        $(\'#clinica\').autocomplete({
                            lookup: segurosArray,
                            appendTo: \'#autocomplete-clinica\'
                        });
                    });
                </script>

               <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Seguros (Ya cargados)</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <select id="seguro" name="seguro" class="select2_multiple form-control" multiple="multiple">
                        ';
                        $sql = "select * from seguros_medicos where id_medico=".Session::get("id_medico")." order by nombre";
                        $data=DB::select($sql);
                        foreach ($data as $data)
                            $resultado .= "<option value='".$data->id."'>".$data->nombre."</option>";
                        $resultado.='
                        </select>
                    </div>
                </div>                  

                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Seguro(s)</label>
                    <div class="col-md-6 col-sm-6 col-xs-9">
                        <input id="seguro_nuevo" name="seguro_nuevo" type="text" class="tags form-control" value="" />
                        <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                        Nota: Para agregar el seguro, debe colocar el nombre del mismo y para agregar otro, debe presionar la tecla enter.
                    </div>
                </div> 

                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Observacion:</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea maxlength="120" id="observaciones" name="observaciones" class="form-control"></textarea>
                    </div>
                </div> ';

        $resultado .= "<script>
            $(function () {
                $('#seguro_nuevo').tagsInput({
                    width: 'auto'
                });
            });
        </script>

        <!-- select2 -->
            <script>
                $(document).ready(function () {
                    $('.select2_single').select2({
                        placeholder: 'Select a state',
                        allowClear: true
                    });
                    $('.select2_group').select2({});
                    $('.select2_multiple').select2({
                        maximumSelectionLength: 10,
                        placeholder: 'Maximo 10 seguros a seleccionar',
                        allowClear: true
                    });
                });
            </script>
            <!-- /select2 -->        ";
    }

    return Response::json(array(
        'resultado' => $resultado,
    ));
    die;
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});