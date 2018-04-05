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

use App\pagosclinica;
use App\cirugias;
use App\datos_cirugia;
use App\facturas;

use App\Http\Controllers\FuncionesControllers;

class PagosControllers extends Controller {

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

        return view::make('pagos.consulta_2',["fecha1"=>$fecha1, "fecha2"=>$fecha2, "consulta"=>1, "id_clinica"=>0]);
    }

    public function consulta_pago_2(Request $request)
    {
        $fecha=$request->fecha;
        $fecha1=FuncionesControllers::fecha_mysql(substr($fecha,0,strpos($fecha,"-")-1));
        $fecha2=FuncionesControllers::fecha_mysql(substr($fecha,strpos($fecha,"-")+2));

        return view::make('pagos.consulta_2',["fecha1"=>$fecha1, "fecha2"=>$fecha2, "consulta"=>$request->consulta, "id_clinica"=>$request->id_clinica]);
    }

    public function nuevo_pago() {
        Session::put("mensaje","");
        return view('pagos.nuevo',["mensaje"=>"", "id"=>0, "id_clinica"=>0, "cedula_medico"=>"", "direccion"=>"", "color"=>"", "pais"=>"", "ciudad"=>"", "id_pago"=>0,"cedula"=>"", "nro_historia"=>"","cedula_paciente"=>"","monto"=>0, "id_moneda"=>0,"nro_caso"=>"","observaciones"=>"","referencias"=>"","seguro"=>0]);
    }

    public function cargarfactura($datos) {
        $id_clinica=substr($datos,0,strpos($datos,","));
        $id_medico=substr($datos,strpos($datos,",")+1);
        Session::put("mensaje","");
        $today = @getdate();
        
        $dia = $today["mday"];
        $mes = $today["mon"];
        $ano = $today["year"];

        //if ($dia<10) $dia.="0";
        //if ($mes<10) $mes.="0";

        $fecha = $dia."/".$mes."/".$ano;            
        return view('pagos.cargarfactura',["mensaje"=>"", "id"=>0, "id_clinica"=>$id_clinica, "id_medico"=>$id_medico,"fecha"=>$fecha]);
    }


    public function cargarpago($datos) {
        $id_clinica=substr($datos,0,strpos($datos,","));
        $id_medico=substr($datos,strpos($datos,",")+1);
        Session::put("mensaje","");
        $today = @getdate();
        
        $dia = $today["mday"];
        $mes = $today["mon"];
        $ano = $today["year"];

        $fecha = $dia."/".$mes."/".$ano;       
        return view('pagos.cargarpago',["mensaje"=>"", "id"=>0, "id_clinica"=>$id_clinica, "id_medico"=>$id_medico,"fecha"=>$fecha]);
    }     

    public function nuevo_pago_deudas() {
        Session::put("mensaje","");
        $today = @getdate();
        
        $dia = $today["mday"];
        $mes = $today["mon"];
        $ano = $today["year"];

        $fecha_act = $ano."-".$mes."-".$dia;

        $fecha = $fecha_act;
        $nuevafecha = strtotime ( '-365 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );

        $fecha_act = $fecha;
        $fecha2=FuncionesControllers::fecha_normal($fecha_act);
        $fecha1=FuncionesControllers::fecha_normal($nuevafecha);

        return view('pagos.nuevo_pago_deudas',["mensaje"=>"", "id"=>0, "id_clinica"=>0, "cedula_medico"=>"", "direccion"=>"", "color"=>"", "pais"=>"", "ciudad"=>"", "id_pago"=>0,"cedula"=>"", "nro_historia"=>"","cedula_paciente"=>"","monto"=>0, "id_moneda"=>0,"nro_caso"=>"","observaciones"=>"","referencias"=>"","seguro"=>0,"fecha1"=>$fecha1,"fecha2"=>$fecha2]);
    }

    public function nuevo_pago_deudas_2() {
        return view('pagos.nuevo_pago_deudas_2',["mensaje"=>"","dias_alta"=>0,"dias_factura"=>0]);
    }    

    public function buscar_consultas_pagos (Request $request) {
        //dd($request->all());
        $fecha_alta=$request->fecha_alta;
        $fecha1=substr($fecha_alta,0,strpos($fecha_alta,"-")-1);
        $fecha2=substr($fecha_alta,strpos($fecha_alta,"-")+2);
        return view('pagos.nuevo_pago_deudas',["mensaje"=>"", "id"=>0, "id_clinica"=>0, "cedula_medico"=>"", "direccion"=>"", "color"=>"", "pais"=>"", "ciudad"=>"", "id_pago"=>0,"cedula"=>"", "nro_historia"=>"","cedula_paciente"=>"","monto"=>0, "id_moneda"=>0,"nro_caso"=>"","observaciones"=>"","referencias"=>"","seguro"=>0,"fecha1"=>$fecha1,"fecha2"=>$fecha2]);
    }

    public function buscar_consultas_pagos_2 (Request $request) {
        //dd($request->all());
        $dias_alta=$request->dias_alta;
        $dias_factura=$request->dias_factura;        
        return view('pagos.nuevo_pago_deudas_2',["mensaje"=>"","dias_alta"=>$dias_alta,"dias_factura"=>$dias_factura]);
    }    

    public function consultarpago($id)
    {
        $pago=pago::findOrFail($id);
        return view::make('pagos.edit', compact('pago'));
    }

    public function consultarclinica($valor)
    {
        $id_clinica=substr($valor,0,strpos($valor,","));
        $id_medico=substr($valor,strpos($valor,",")+1);
        return view::make('pagos.consultarclinica', ["id_clinica"=>$id_clinica,"id_medico"=>$id_medico]);
    }

    public function guardar_pago_nuevo_factura (Request $request) {
        //dd($request->all());
        $today = @getdate();
        
        $dia = $today["mday"];
        $mes = $today["mon"];
        $ano = $today["year"];

        $fecha_act = $ano."-".$mes."-".$dia;

        $fecha = $fecha_act;
        $nuevafecha = strtotime ( '-365 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );

        $fecha_act = $fecha;
        $fecha2=FuncionesControllers::fecha_normal($fecha_act);
        $fecha1=FuncionesControllers::fecha_normal($nuevafecha);

        $montos=$request->montos;
        //$montos=substr($montos,0,strlen($montos)-1);
        
        $nro_factura = $request->nro_factura;
        $fecha_factura = FuncionesControllers::fecha_mysql($request->fecha_factura);

        $datos = Input::all();
        $res="";
        $id_cirugia=0;
        foreach ($datos as $key=>$value) {
            if (strpos($key,"chk_") !== false) {
                $id_cirugia=substr($value,0,strpos($value,"_"));
                $value=substr($value,strpos($value,"_")+1);
                $id_clinica=substr($value,0,strpos($value,"_"));
                $value=substr($value,strpos($value,"_")+1);
                $id_datos_cirugia=$value;

                $facturas = new facturas($request->all());

                $facturas->id_cirugia=$id_cirugia;
                $cirugias = Cirugias::where('id', $id_cirugia)
                                ->take(10)
                                ->get();

                $facturas->id_datos_cirugia=$id_datos_cirugia;                             

                foreach ($cirugias as $cirugias) {
                    $facturas->id_clinica=$cirugias->id_clinica;
                    $facturas->id_paciente=$cirugias->id_paciente;                    
                    $facturas->id_moneda=$cirugias->id_moneda;
                }
            }

            if (strpos($key,"nro_factura_".$id_cirugia) !== false)
                $facturas->nro_factura_clinica=$value;
            if (strpos($key,"nro_control_".$id_cirugia) !== false)
                $facturas->nro_control=$value;
            if (strpos($key,"fecha_factura_".$id_cirugia) !== false)
                $facturas->fecha_factura=FuncionesControllers::fecha_mysql($value);
            if (strpos($key,"monto_".$id_cirugia) !== false) {
                $facturas->monto=$value;
                $facturas->save();
            }

                /*$datos_cirugia = datos_cirugia::where('id_cirugia', $id_cirugia)
                                ->where('id',$id_datos_cirugia)
                                ->take(10)
                                ->get();*/

                /*foreach ($datos_cirugia as $datos_cirugia) {
                    $monto_datos_cirugia=substr($montos,strpos($montos,"=")+1,strpos($montos,","));
                    $montos=substr($montos,strpos($montos,",")+1);*/
                    
                //}
        }
        //return view('generica.formainsertada', ["tipo"=>"pago_medico"]);
        return view('pagos.nuevo_pago_deudas',["mensaje"=>"", "id"=>0, "id_clinica"=>0, "cedula_medico"=>"", "direccion"=>"", "color"=>"", "pais"=>"", "ciudad"=>"", "id_pago"=>0,"cedula"=>"", "nro_historia"=>"","cedula_paciente"=>"","monto"=>0, "id_moneda"=>0,"nro_caso"=>"","observaciones"=>"","referencias"=>"","seguro"=>0,"fecha1"=>$fecha1,"fecha2"=>$fecha2]);
    }

    public function guardar_pago_nuevo (Request $request) {
        //dd($request->all());
        
        $nro_factura = $request->nro_factura;
        $nro_control = $request->nro_control;
        $fecha_pago = FuncionesControllers::fecha_mysql($request->fecha_pago);

        $datos = Input::all();
        $res="";
        $id_cirugia=0;
        //'id_cirugia', 'id_clinica','id_paciente','monto','nro_factura_clinica', 'nro_control', 'fecha_pago','id_moneda','tipo_pago','id_datos_cirugia'
        foreach ($datos as $key=>$value) {
            if (strpos($key,"chk_") !== false) {
                $id_cirugia=substr($value,0,strpos($value,"_"));
                $value=substr($value,strpos($value,"_")+1);
                $id_clinica=substr($value,0,strpos($value,"_"));
                $value=substr($value,strpos($value,"_")+1);
                $id_datos_cirugia=$value;

                $pagosclinica = new pagosclinica($request->all());

                $pagosclinica->id_cirugia=$id_cirugia;
                $cirugias = Cirugias::where('id', $id_cirugia)
                                ->take(10)
                                ->get();

                $pagosclinica->id_datos_cirugia=$id_datos_cirugia;                             

                foreach ($cirugias as $cirugias) {
                    $pagosclinica->id_clinica=$cirugias->id_clinica;
                    $pagosclinica->id_paciente=$cirugias->id_paciente;                    
                    $pagosclinica->id_moneda=$cirugias->id_moneda;
                }

                $pagosclinica->nro_factura_clinica=$nro_factura;
                $pagosclinica->nro_control=$nro_control;
                $pagosclinica->fecha_pago=$fecha_pago;
                $pagosclinica->tipo_pago=1;                
            }

            if (strpos($key,"monto_".$id_cirugia) !== false) {
                $pagosclinica->monto=$value;
                $pagosclinica->save();
            }


               /* $datos_cirugia = datos_cirugia::where('id_cirugia', $id_cirugia)
                                ->where('id',$id_datos_cirugia)
                                ->take(10)
                                ->get();    

                foreach ($datos_cirugia as $datos_cirugia) {
                    //monto_5=160000.00,monto_4=2500.00
                    $monto_datos_cirugia=substr($montos,strpos($montos,"=")+1,strpos($montos,","));
                    $montos=substr($montos,strpos($montos,",")+1);*/
                    
                    
                //}             
            }
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
        return view('generica.formainsertada', ["tipo"=>"pago_medico"]);
    }


    public static function consulta_clinicas($fecha1,$fecha2)
    {
        $sql = "select * from (
            (select cm.id_clinica, cm.nombre as clinica, sum(c.monto) as Total_de_casos, dc.id as id_datos_cirugia,
                c.id as id_cirugia
            from clinica_medico cm, cirugias c, datos_cirugia dc
            where dc.id_cirugia=c.id and 
            cm.id_medico=c.id_medico and c.id_clinica=cm.id_clinica and 
            c.id in (select id_cirugia from alta) and 
            dc.fecha_alta between '".trim($fecha1)."' and '".trim($fecha2)."' ";
            if (Session::get("tipo")==2)
                $sql .= " and c.id_medico=".Session::get("id_medico");

            $sql .= " group by cm.id_clinica, cm.nombre)
            union
            (select cm.id_clinica, cm.nombre as Clinica, sum(c.monto) as Total_de_casos, dc.id as id_datos_cirugia,
                c.id as id_cirugia
            from clinica_medico cm, cirugias c, pagosclinicas pc, datos_cirugia dc
            where  dc.id_cirugia=c.id and 
            cm.id_medico=c.id_medico and c.id_clinica=cm.id_clinica and pc.id_cirugia=c.id and 
            c.id in (select id_cirugia from alta) and 
            dc.fecha_alta between '".trim($fecha1)."' and '".trim($fecha2)."' ";
            if (Session::get("tipo")==2)
                $sql .= " and c.id_medico=".Session::get("id_medico");
            $sql .= " group by cm.id_clinica, cm.nombre)) as tabla_resultado group by id_clinica order by id_clinica
        ";

        //echo $sql;return;

        $data = DB::select($sql);
        $end_data = count($data);
        $strDatos="[";
        $i=0;
        $id_clinica_ant=0;
        $clinica_ant="";
        $cantidad=0;     
        $entro=0;
        if (!empty($data)) {
            foreach ($data as $data) {
                $monto_factura=FuncionesControllers::buscar_monto_factura_clinica($data->id_clinica);
                $total_pagado=FuncionesControllers::total_pagado_clinica($data->id_clinica);
                $total_adeudado=$data->Total_de_casos-$total_pagado;
                $strDatos.="['".$data->clinica."',";
                $strDatos.="'Bs. ".number_format($data->Total_de_casos,2,",",".")."',";
                $strDatos.="'Bs. ".number_format($monto_factura,2,",",".")."',";
                $strDatos.="'Bs. ".number_format($total_pagado,2,",",".")."',";
                $strDatos.="'<span style=\"color:red\"><strong>Bs. ".number_format($total_adeudado,2,",",".")."</strong></span>','";
                $strDatos.='<div class="btn-group"><a href="consultarclinica/'.$data->id_clinica.','.Session::get("id_medico").'"><button class="btn btn-default" type="button">Consultar</button></a><a href="cargarfactura/'.$data->id_clinica.','.Session::get("id_medico").'"><button class="btn btn-default" type="button">Cargar Facturas</button></a><a href="cargarpago/'.$data->id_clinica.','.Session::get("id_medico").'"><button class="btn btn-default" type="button">Cargar Pagos</button></a></div>';
                $strDatos.="'],";            

            }
        }
        if ($strDatos!="[")
            $strDatos=substr($strDatos,0,strlen($strDatos)-1);
        $strDatos.="]";
        //echo $strDatos;
        //return;
        $strTabla="pago";
        $strColumnas="{ title: \"Clinica\" },{ title: \"Total de casos (Bs)\" },{ title: \"Total de Facturas (Bs)\" },{ title: \"Total Pagado (Bs)\" },{ title: \"Total Adeudado (Bs)\" },{ title: \"-\" }";
        $strtfoot="<th>Clinica</th><th>Total de casos (Bs)</th><th>Total de Facturas (Bs)</th><th>Total Pagado (Bs)</th><th>Total Adeudado (Bs)</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de pagos";
        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }

    public static function consulta_clinicas_2($dias_alta,$dias_factura)
    {
        $sql = "select * from (
            (select cm.id_clinica, cm.nombre as clinica, count(c.id) as nro_casos_pendientes, sum(c.monto)-sum(pc.monto) as monto_x_cobrar
            from cirugias c, clinica_medico cm, pagosclinicas pc ";
            if ($dias_alta>0)
                $sql.= ", datos_cirugia dc ";
            if ($dias_factura>0)
                $sql .= ",facturas f ";
            $sql.="where c.id_medico=cm.id_medico and c.id_clinica=cm.id_clinica ";
            if ($dias_alta>0)
                $sql .= " and dc.id_cirugia=c.id ";
            $sql.=" and pc.id_cirugia=c.id
            and c.id in (select id_cirugia from alta) ";            
            if (Session::get("tipo")==2)
                $sql .= " and c.id_medico=".Session::get("id_medico");
            if ($dias_alta>0)
                $sql .= " and DATEDIFF(now(),dc.fecha_alta)>=".$dias_alta." ";
            if ($dias_factura>0)
                $sql .= " and f.id_cirugia=c.id and DATEDIFF(now(),f.fecha_factura)>=".$dias_factura." ";

        $sql .= "
            group by cm.id_clinica, cm.nombre)
            union
            (select cm.id_clinica, cm.nombre as clinica, count(c.id) as nro_casos_pendientes, sum(c.monto) as monto_x_cobrar
            from cirugias c, clinica_medico cm ";
            if ($dias_alta>0)
                $sql .= ", datos_cirugia dc ";
            if ($dias_factura>0)
                $sql .= ",facturas f ";            
            $sql.="where c.id_medico=cm.id_medico and c.id_clinica=cm.id_clinica ";
            if ($dias_alta>0)
                $sql.= " and dc.id_cirugia=c.id ";
            
            $sql.= " and c.id not in (select id_cirugia from pagosclinicas) 
            and c.id in (select id_cirugia from alta) ";
            if (Session::get("tipo")==2)
                $sql .= " and c.id_medico=".Session::get("id_medico");
            if ($dias_alta>0)
                $sql .= " and DATEDIFF(now(),dc.fecha_alta)>=".$dias_alta." ";
            if ($dias_factura>0)
                $sql .= " and f.id_cirugia=c.id and DATEDIFF(now(),f.fecha_factura)>=".$dias_factura." ";
            $sql.=" group by cm.id_clinica, cm.nombre)) as tabla_resultado having monto_x_cobrar>0
        ";
        //echo $sql; return;
        $data = DB::select($sql);
        $end_data = count($data);
        $strDatos="[";
        $i=0;
        $id_clinica_ant=0;
        $clinica_ant="";
        $cantidad=0;     
        $entro=0;
        if (!empty($data)) {
            foreach ($data as $data) {    
                $strDatos.="['".$data->clinica."',";
                $strDatos.="'".$data->nro_casos_pendientes."',";
                $strDatos.="'Bs. ".number_format($data->monto_x_cobrar,2,",",".")."','";
                $strDatos.='<div class="btn-group"><a href="consultarclinica/'.$data->id_clinica.','.Session::get("id_medico").'"><button class="btn btn-default" type="button">Consultar</button></a><a href="cargarfactura/'.$data->id_clinica.','.Session::get("id_medico").'"><button class="btn btn-default" type="button">Cargar Facturas</button></a><a href="cargarpago/'.$data->id_clinica.','.Session::get("id_medico").'"><button class="btn btn-default" type="button">Cargar Pagos</button></a></div>';
                //$strDatos.='<div class="btn-group"><a href="consultarclinica/'.$data->id_clinica.','.Session::get("id_medico").'"><button class="btn btn-default" type="button">Consultar</button></a></div>';
                $strDatos.="'],";                

            }
        }
        if ($strDatos!="[")
            $strDatos=substr($strDatos,0,strlen($strDatos)-1);
        $strDatos.="]";
        $strTabla="pago";
        $strColumnas="{ title: \"Clinica\" },{ title: \"Numero de Casos Pendientes\" },{ title: \"Monto x Cobrar (Bs)\" },{ title: \"-\" }";
        $strtfoot="<th>Clinica</th><th>Numero de Casos Pendientes</th><th>Monto x Cobrar (Bs)</th><th>-</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de pagos";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }

    public static function consulta_facturas($id_clinica, $id_medico)
    {
        $sql = "(select sum(pc.monto) as monto_pagado, c.monto as monto_total,
                    m.nombres as medico, 
                    p.nombres as nombre_paciente, p.apellidos as apellido_paciente, p.id as id_paciente,
                    c.nombre as diagnostico, c.id as id_cirugia, 
                    cm.id_clinica as id_clinica, c.seguros, 
                    cm.nombre as clinica, c.nro_historia, p.cedula
                from 
                    paciente p, cirugias c, medico m, clinica_medico cm, pagosclinicas pc 
                where
                    c.id=pc.id_cirugia and 
                    m.id=c.id_medico and p.id=c.id_paciente and 
                    c.id_clinica=$id_clinica and c.id_medico=$id_medico and
                    cm.id_medico=c.id_medico and cm.id_clinica=c.id_clinica and
                    p.id_medico=$id_medico and
                    p.id_medico=c.id_medico and   
                    c.id in (select id_cirugia from alta) ";
            //$sql.= "and c.id not in (select id_cirugia from facturas) ";
                if (Session::get("tipo")==2)
                    $sql .= " and c.id_medico=".Session::get("id_medico");                    
                $sql .= " group by m.nombres, p.nombres, p.apellidos, p.id,
                    c.nombre, c.id, cm.id_clinica, c.seguros
                having sum(pc.monto) < c.monto)

                union

                (select 0 as monto_pagado, c.monto as monto_total,
                    m.nombres as medico, 
                    p.nombres as nombre_paciente, p.apellidos as apellido_paciente, p.id as id_paciente,
                    c.nombre as diagnostico, c.id as id_cirugia, 
                    cm.id_clinica as id_clinica, c.seguros, 
                    cm.nombre as clinica,
                    c.nro_historia, p.cedula
                from 
                    paciente p, cirugias c, medico m, clinica_medico cm
                where
                    m.id=c.id_medico and p.id=c.id_paciente and 
                    c.id_clinica=$id_clinica and c.id_medico=$id_medico and
                    cm.id_medico=c.id_medico and cm.id_clinica=c.id_clinica and
                    p.id_medico=$id_medico and
                    p.id_medico=c.id_medico and                    
                    c.id in (select id_cirugia from alta) and 
                    c.id not in (select id_cirugia from pagosclinicas) ";
            //$sql .= "and c.id not in (select id_cirugia from facturas) ";
                if (Session::get("tipo")==2)
                    $sql .= " and c.id_medico=".Session::get("id_medico");
                $sql .= " group by m.nombres, p.nombres, p.apellidos, p.id,
                    c.nombre, c.id, cm.id_clinica, c.seguros, cm.nombre)";
        
        //echo $sql;return;

        $today = @getdate();
        
        $dia = $today["mday"];
        $mes = $today["mon"];
        $ano = $today["year"];
        $fecha_act = $dia."/".$mes."/".$ano;

        $data = DB::select($sql);
        $end_data = count($data);
        $strDatos="[";
        $i=0;
        foreach ($data as $data) {
            $monto_deuda=$data->monto_total-$data->monto_pagado;
            $monto_factura=FuncionesControllers::buscar_monto_factura($data->id_cirugia);
            if ($monto_factura==0)
                $monto_factura=$data->monto_total;
            $strDatos.="['";
            $strDatos.='<input onclick="total_pagar_factura('.$monto_factura.','.$data->id_cirugia.','.$data->id_paciente.',0)" value="'.$data->id_cirugia.'_'.$data->id_paciente.'_0" id="chk_'.$data->id_cirugia.'_'.$data->id_paciente.'_0" name="chk_'.$data->id_cirugia.'_'.$data->id_paciente.'_0" type="checkbox">';
            $strDatos.="',";
            $strDatos.="'".$data->nro_historia."',";
            $strDatos.="'".$data->nombre_paciente." ".$data->apellido_paciente."',";
            $strDatos.="'".number_format($data->cedula,0,"",".")."',";
            $strDatos.="'Bs. ".number_format($monto_factura,2,",",".")."',";

            $fecha_alta=FuncionesControllers::buscar_fecha_alta_dc($data->id_cirugia);

            $strDatos.="'".number_format(FuncionesControllers::dias_desde_fecha($fecha_alta),0,"",".")." dias',";
            $strDatos.="'";            
            $strDatos.='<input id="nro_factura_'.$data->id_cirugia.'" class="col-xs-12" maxlength="12" name="nro_factura_'.$data->id_cirugia.'" type="text" data-validate-length-range="10" data-validate-words="1" placeholder="Nro de Factura" value="">';
            $strDatos.="','";
            $strDatos.='<input id="nro_control_'.$data->id_cirugia.'" maxlength="12" name="nro_control_'.$data->id_cirugia.'" type="text" data-validate-length-range="10" data-validate-words="1" class="col-xs-12" placeholder="Nro de Control" value="">';
            $strDatos.="','";
            $strDatos.='<input id="fecha_factura_'.$data->id_cirugia.'" name="fecha_factura_'.$data->id_cirugia.'" class="date-picker col-xs-12" required="required" type="text" value="'.$fecha_act.'">';
            $strDatos.="','";
            $strDatos.='<input id="monto_'.$data->id_cirugia.'" class="col-xs-12" name="monto_'.$data->id_cirugia.'" type="text" data-validate-length-range="10" data-validate-words="1" required="required" placeholder="Monto" value="'.$monto_factura.'">';
            $strDatos.="']";
            if (! ($i == $end_data-1)==true) {
                $strDatos.=",";
            }
            $i++;            
        }
        $strDatos.="]";
        //echo $strDatos;return;
        $strTabla="pago";
        $strColumnas="{ title: \"\" },{ title: \"Historia\" },{ title: \"Paciente\" },{ title: \"Cedula\" },{ title: \"Monto<br>Caso\" },{ title: \"Dias Fecha Alta\" },{ title: \"Factura\" },{ title: \"Control\" },{ title: \"Fecha\" },{ title: \"Monto Factura\" }";
        $strtfoot="<th></th><th>Historia</th><th>Paciente</th><th>Cedula</th><th>Monto<br>Caso</th><th>Dias Fecha Alta</th><th>Factura</th><th>Control</th><th>Fecha</th><th>Monto Factura</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]";
        $intCantidad=10;
        $strNombreArchivo="Listado de pagos";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }

    public static function consulta_pago_factura($id_clinica, $id_medico)
    {
        $sql = "(select sum(pc.monto) as monto_pagado, c.monto as monto_total,
                    m.nombres as medico, 
                    p.nombres as nombre_paciente, p.apellidos as apellido_paciente, p.id as id_paciente,
                    c.nombre as diagnostico, c.id as id_cirugia, 
                    cm.id_clinica as id_clinica, c.seguros,                    
                    cm.nombre as clinica, c.nro_historia, p.cedula, c.monto
                from 
                    paciente p, cirugias c, medico m, clinica_medico cm, pagosclinicas pc
                where
                    c.id=pc.id_cirugia and 
                    m.id=c.id_medico and p.id=c.id_paciente and 
                    c.id_clinica=$id_clinica and c.id_medico=$id_medico and
                    cm.id_medico=c.id_medico and cm.id_clinica=c.id_clinica and
                    p.id_medico=$id_medico and
                    p.id_medico=c.id_medico and   
                    c.id=pc.id_cirugia and       
                    c.id in (select id_cirugia from alta) ";
                if (Session::get("tipo")==2)
                    $sql .= " and c.id_medico=".Session::get("id_medico");                    
                $sql .= " group by m.nombres, p.nombres, p.apellidos, p.id,
                    c.nombre, c.id, cm.id_clinica, c.seguros, 
                    cm.nombre
                having sum(pc.monto) < c.monto)

                union

                (select 0 as monto_pagado, c.monto as monto_total,
                    m.nombres as medico, 
                    p.nombres as nombre_paciente, p.apellidos as apellido_paciente, p.id as id_paciente,
                    c.nombre as diagnostico, c.id as id_cirugia, 
                    cm.id_clinica as id_clinica, c.seguros, 
                    cm.nombre as clinica,
                    c.nro_historia, p.cedula, c.monto
                from 
                    paciente p, cirugias c, medico m, clinica_medico cm
                where
                    m.id=c.id_medico and p.id=c.id_paciente and 
                    c.id_clinica=$id_clinica and c.id_medico=$id_medico and
                    cm.id_medico=c.id_medico and cm.id_clinica=c.id_clinica and
                    p.id_medico=$id_medico and
                    p.id_medico=c.id_medico and                    
                    c.id in (select id_cirugia from alta) and 
                    c.id not in (select id_cirugia from pagosclinicas) ";
                if (Session::get("tipo")==2)
                    $sql .= " and c.id_medico=".Session::get("id_medico");
                $sql .= " group by m.nombres, p.nombres, p.apellidos, p.id,
                    c.nombre, c.id, cm.id_clinica, c.seguros, 
                    cm.nombre)";
        //echo $sql;return;

        $data = DB::select($sql);
        $end_data = count($data);
        $strDatos="[";
        $i=0;
        foreach ($data as $data) {
            $id_cirugia=$data->id_cirugia;
            $monto_pagado=FuncionesControllers::total_pagado($id_cirugia);
            $monto_deuda=$data->monto_total-$monto_pagado;            
            if ($monto_deuda>0) {
                $strDatos.="['";
                $strDatos.='<input onclick="total_pagar('.$data->monto.','.$data->id_cirugia.','.$data->id_paciente.',0)" value="'.$data->id_cirugia.'_'.$data->id_paciente.'_0" id="chk_'.$data->id_cirugia.'_'.$data->id_paciente.'_0" name="chk_'.$data->id_cirugia.'_'.$data->id_paciente.'_0" type="checkbox">';
                $strDatos.="',";
                $strDatos.="'".$data->nro_historia."',";
                $strDatos.="'".$data->nombre_paciente." ".$data->apellido_paciente."',";

                $strDatos.="'".FuncionesControllers::buscar_factura_tipo("numero",$data->id_cirugia)."',";
                $strDatos.="'".FuncionesControllers::buscar_factura_tipo("fecha",$data->id_cirugia)."',";

                $strDatos.="'".number_format($data->monto_total,2,",",".")."',";
                $strDatos.="'".number_format($monto_pagado,2,",",".")."',";
                $strDatos.="'".number_format($monto_deuda,2,",",".")."',";

                $fecha_alta=FuncionesControllers::buscar_fecha_alta_dc($data->id_cirugia);

                $strDatos.="'".number_format(FuncionesControllers::dias_desde_fecha($fecha_alta),0,"",".")." dias',";
                //$strDatos.="'".number_format(FuncionesControllers::dias_desde_fecha($data->fecha_factura),0,"",".")." dias',";
                $strDatos.="'".$data->seguros."',";
                $strDatos.="'<input class=\"form-control col-md-7\" type=\"text\" name=\"monto_".$data->id_cirugia."\" id=\"monto_".$data->id_cirugia."\" value=\"".$monto_deuda."\">',";            
                //$strDatos.="'".FuncionesControllers::buscar_estatus_pago($data->id_cirugia, $data->id_clinica, $data->id_paciente);
                $strDatos.="]";
                if (! ($i == $end_data-1)==true) {
                    $strDatos.=",";
                }
                $i++;
            }
        }
        $strDatos.="]";
        //echo $strDatos; return;
        $strTabla="pago";
        $strColumnas="{ title: \"\" },{ title: \"Nro Historia\" },{ title: \"Paciente\" },{ title: \"Factura\" },{ title: \"Fecha Factura\" },{ title: \"Monto Abonado\" },{ title: \"Deuda\" },{ title: \"Dias Fecha Alta\" },{ title: \"Seguro(s)\" },{ title: \"Pago Bs.\" }";
        $strtfoot="<th></th><th>Nro Historia</th><th>Paciente</th><th>Factura</th><th>Fecha Factura</th><th>Monto Atencion</th><th>Monto Abonado</th><th>Deuda</th><th>Dias Fecha Alta</th><th>Seguro(s)</th><th>Pago Bs.</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]";
        $intCantidad=10;
        $strNombreArchivo="Listado de pagos";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }

    public static function consulta_pagos($id_clinica, $id_medico)
    {
        $sql = "(select sum(pc.monto) as monto_pagado, c.monto as monto_total,
                    m.nombres as medico, 
                    p.nombres as nombre_paciente, p.apellidos as apellido_paciente, p.id as id_paciente,
                    c.nombre as diagnostico, c.id as id_cirugia, 
                    cm.id_clinica as id_clinica, c.seguros, 
                    cm.nombre as clinica, c.nro_historia
                from 
                    paciente p, cirugias c, medico m, datos_cirugia dc, clinica_medico cm, pagosclinicas pc 
                where
                    c.id=pc.id_cirugia and 
                    m.id=c.id_medico and p.id=c.id_paciente and 
                    c.id_clinica=$id_clinica and c.id_medico=$id_medico and
                    c.id=dc.id_cirugia and
                    cm.id_medico=c.id_medico and cm.id_clinica=c.id_clinica and
                    p.id_medico=$id_medico and
                    p.id_medico=c.id_medico and   
                    dc.id_tipo_atencion!=7 and                 
                    dc.id_cirugia in (select id_cirugia from alta) ";
                if (Session::get("tipo")==2)
                    $sql .= " and c.id_medico=".Session::get("id_medico");                    
                $sql .= " group by m.nombres, p.nombres, p.apellidos, p.id,
                    c.nombre, c.id, cm.id_clinica, c.seguros, 
                    dc.tipo_atencion, dc.monto, dc.id, cm.nombre
                having sum(pc.monto) < c.monto)

                union

                (select 0 as monto_pagado, c.monto as monto_total,
                    m.nombres as medico, 
                    p.nombres as nombre_paciente, p.apellidos as apellido_paciente, p.id as id_paciente,
                    c.nombre as diagnostico, c.id as id_cirugia, 
                    cm.id_clinica as id_clinica, c.seguros, 
                    cm.nombre as clinica,
                    c.nro_historia
                from 
                    paciente p, cirugias c, medico m, datos_cirugia dc, clinica_medico cm
                where
                    m.id=c.id_medico and p.id=c.id_paciente and 
                    c.id_clinica=$id_clinica and c.id_medico=$id_medico and
                    c.id=dc.id_cirugia and
                    cm.id_medico=c.id_medico and cm.id_clinica=c.id_clinica and
                    p.id_medico=$id_medico and
                    p.id_medico=c.id_medico and                    
                    dc.id_cirugia in (select id_cirugia from alta) and 
                    dc.id_tipo_atencion!=7 and
                    c.id not in (select id_cirugia from pagosclinicas) ";
                if (Session::get("tipo")==2)
                    $sql .= " and c.id_medico=".Session::get("id_medico");
                $sql .= " group by m.nombres, p.nombres, p.apellidos, p.id,
                    c.nombre, c.id, cm.id_clinica, c.seguros, 
                    dc.tipo_atencion, dc.monto, dc.id, cm.nombre)";
        
        //echo $sql; return;

        $data = DB::select($sql);
        $end_data = count($data);
        $strDatos="[";
        $i=0;
        foreach ($data as $data) {
            $monto_deuda=$data->monto_total-$data->monto_pagado;
            $strDatos.="[";
            //$strDatos.='<input onclick="total_pagar('.$data->monto_atencion.','.$data->id_cirugia.','.$data->id_paciente.','.$data->id_datos_cirugia.')" value="'.$data->id_cirugia.'_'.$data->id_paciente.'_'.$data->id_datos_cirugia.'" id="chk_'.$data->id_cirugia.'_'.$data->id_paciente.'_'.$data->id_datos_cirugia.'" name="chk_'.$data->id_cirugia.'_'.$data->id_paciente.'_'.$data->id_datos_cirugia.'" type="checkbox">';
            //$strDatos.="',";
            $strDatos.="'".$data->nro_historia."',";
            $strDatos.="'".$data->nombre_paciente." ".$data->apellido_paciente."',";
            $strDatos.="'".number_format($data->monto_total,2,",",".")."',";
            $strDatos.="'".number_format($data->monto_pagado,2,",",".")."',";
            $strDatos.="'".number_format($monto_deuda,2,",",".")."',";

            $fecha_alta=FuncionesControllers::buscar_fecha_alta_dc($data->id_cirugia);

            $strDatos.="'".number_format(FuncionesControllers::dias_desde_fecha($fecha_alta),0,"",".")." dias',";
            $strDatos.="'".number_format(FuncionesControllers::dias_desde_fecha(FuncionesControllers::buscar_factura($data->id_cirugia, 'fecha_factura')),0,"",".")." dias',";
            $strDatos.="'".FuncionesControllers::buscar_factura($data->id_cirugia, 'nro_factura_clinica')."',";
            $strDatos.="'".FuncionesControllers::buscar_factura($data->id_cirugia, 'fecha_factura')."',";
            $strDatos.="'".number_format(FuncionesControllers::buscar_factura($data->id_cirugia, 'monto'),2,",",".")."',";
            $strDatos.="'".substr($data->seguros,0,strlen($data->seguros)-1)."";
            //$strDatos.="'<input class=\"form-control col-md-7\" type=\"text\" name=\"monto_".$data->id_datos_cirugia."\" id=\"monto_".$data->id_datos_cirugia."\" value=\"".number_format($monto_deuda,2,",",".")."\">',";            
            //$strDatos.="'".FuncionesControllers::buscar_estatus_pago($data->id_cirugia, $data->id_clinica, $data->id_paciente);
            $strDatos.="']";
            if (! ($i == $end_data-1)==true) {
                $strDatos.=",";
            }
            $i++;
        }
        $strDatos.="]";
        //echo $strDatos; return;
        $strTabla="pago";
        $strColumnas="{ title: \"Historia\" },{ title: \"Paciente\" },{ title: \"Monto Registrado\" },{ title: \"Pago Parcial\" },{ title: \"Monto Deuda\" },{ title: \"Dias Fecha Alta\" },{ title: \"Dias Fecha Factura\" },{ title: \"Nro Factura\" },{ title: \"Fecha Factura\" },{ title: \"Monto Facturado\" },{ title: \"Seguro(s)\" }";
        $strtfoot="<th>Historia</th><th>Paciente</th><th>Monto Registrado</th><th>Pago Parcial</th><th>Monto Deuda</th><th>Dias Fecha Alta</th><th>Dias Fecha Factura</th><th>Nro Factura</th><th>Fecha Factura</th><th>Monto Facturado</th><th>Seguro(s)</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]";
        $intCantidad=10;
        $strNombreArchivo="Listado de pagos";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }

    public static function consulta()
    {
        $sql = "select 
                    m.nombres as medico, p.nombres as nombre_paciente, p.apellidos as apellido_paciente, 
                    c.nombre as cirugia, s.nombre as seguro, cs.monto,
                    c.id as id_cirugia, s.id as id_seguro, c.id as id_clinica, 
                    mc.id_rol, mc.id_especialidad, cli.nombre as clinica
                from 
                    paciente p, cirugias c, seguros s, cirugia_seguro cs, medico m, medico_cirugia mc,
                    clinica cli
                where
                    m.id=c.id_medico and p.id=c.id_paciente and 
                    c.id=cs.id_cirugia and cs.id_seguro=s.id and 
                    mc.id_cirugia=c.id and cli.id=c.id_clinica
                ";
        if (Session::get("tipo")==2)
            $sql .= " and c.id_medico=".Session::get("id_medico");

        $sql .= " order by m.nombres,c.nombre";  

        $data = DB::select($sql);
        $end_data = count($data);
        $strDatos="[";
        $i=0;
        foreach ($data as $data) {
            $strDatos.="['".$data->medico."',";
            $strDatos.="'".$data->clinica."',";
            $strDatos.="'".$data->nombre_paciente." ".$data->apellido_paciente."',";
            $strDatos.="'".$data->cirugia."',";
            $strDatos.="'".$data->seguro."',";
            $strDatos.="'".FuncionesControllers::buscar_rol($data->id_rol)."',";
            $strDatos.="'".FuncionesControllers::buscar_nombre("especialidad",$data->id_especialidad)."',";
            $strDatos.="'Bs. ".number_format($data->monto,2,",",".")."',";
            $strDatos.="'".FuncionesControllers::buscar_estatus_pago($data->id_cirugia, $data->id_seguro, $data->id_clinica);
            $strDatos.="']";
            if (! ($i == $end_data-1)==true) {
                $strDatos.=",";
            }
            $i++;
        }
        $strDatos.="]";
        $strTabla="pago";
        $strColumnas="{ title: \"Medico\" },{ title: \"Clinica\" },{ title: \"Paciente\" },{ title: \"Cirugia\" },{ title: \"Seguro\" },{ title: \"Rol\" },{ title: \"Especialidad\" },{ title: \"Monto\" },{ title: \"Estatus\" }";
        $strtfoot="<th>Medico</th><th>Clinica</th><th>Paciente</th><th>Cirugia</th><th>Seguro</th><th>Rol</th><th>Especialidad</th><th>Monto</th><th>Estatus</th>";
        $strOpciones="{'copy','csv','excel','pdf','print','colvis'}";
        $strOrden="[ 0, \"desc\" ]"; 
        $intCantidad=10;
        $strNombreArchivo="Listado de pagos";

        echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, 'SI', $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
    }      
}