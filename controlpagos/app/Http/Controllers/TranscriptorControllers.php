<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use App\transcriptor;
use App\Http\Controllers\FuncionesControllers;


class TranscriptorControllers extends Controller {

	/**
	 * Display a listing of the resource.
	 * GET 
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return view::make('admin.transcriptor.nuevo');
	}


	public function create()
	{
		//
		return view::make('admin.transcriptor.crear');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST 
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$transcriptores = new transcriptor();
		$transcriptores->fill(Request::all());
		$transcriptores->save();
		return Redirect::back();
	}

	/**
	 * Display the specified resource.
	 * GET 
	 *
	 * @param  int  $id
	 * @return Response
	 */
	
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET 
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$transcriptores =  transcriptor::findOrFail($id);
		return view::make('admin.transcriptor.editar', compact('transcriptor'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT 
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$transcriptores =  transcriptor::findOrFail($id);
		$transcriptores->fill(Request::all());
		$transcriptores->save();
		return Redirect::route('tr_con');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE 
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public static function consulta()
	{
		//
		$transcriptores = transcriptor::all();
		
		$strDatos="[";
		$end_data = transcriptor::count();

		foreach ($transcriptores as $key=>$transcriptores) {
    		$strDatos.="['".$transcriptores->transcriptor_id."',";
            $strDatos.="'".$transcriptores->medico_id."',";
            $strDatos.="'".$transcriptores->clinica_id."',";
            $strDatos.="'".$transcriptores->imagen_id."',";
            $strDatos.="'".$transcriptores->registro_id."',";
            $strDatos.="'".$transcriptores->historia."',";
            $strDatos.="'".$transcriptores->nombre_completo_paciente."',";
            $strDatos.="'".$transcriptores->factura."',";
            $strDatos.="'".$transcriptores->nro_orden."',";
            $strDatos.="'".$transcriptores->fecha_facturacion."',";
            $strDatos.="'".$transcriptores->fecha_entrega_seguro."',";
            $strDatos.="'".$transcriptores->monto_servicio."',";
            $strDatos.="'".$transcriptores->pago."',";
            $strDatos.="'".$transcriptores->saldo_pendiente."',";
            $strDatos.="'".$transcriptores->tipo_pago."',";
            $strDatos.="'".$transcriptores->estatus."',";
            $strDatos.="'".$transcriptores->id_tabla_atencion."']";
            if (! ($key == $end_data-1)==true) {
           		$strDatos.=",";
           	};
		}
		$strDatos.="]";
		$strTabla="transcriptores";
		$strColumnas="{ title: \"transcriptor_id\" },{ title: \"medico_id\" },{ title: \"clinica_id\" },{ title: \"imagen_id\" },{ title: \"registro_id\" },{ title: \"historia\" },{ title: \"nombre_completo_paciente\" },{ title: \"factura\" },{ title: \"nro_orden\" },{ title: \"fecha_facturacion\" },{ title: \"fecha_entrega_seguro\" },{ title: \"monto_servicio\" },{ title: \"pago\" },{ title: \"saldo_pendiente\" },{ title: \"tipo_pago\" },{ title: \"estatus\"},{ title: \"id_tabla_atencion\"}";
		
		$strtfoot="<th>transcriptor_id</th><th>medico_id</th><th>clinica_id</th><th>imagen_id</th><th>registro_id</th><th>historia</th><th>nombre_completo_paciente</th><th>factura</th><th>nro_orden</th><th>fecha_facturacion</th><th>fecha_entrega_seguro</th><th>monto_servicio</th><th>pago</th><th>saldo_pendiente</th><th>tipo_pago</th><th>estatus</th><th>id_tabla_atencion</th>";
		$strOpciones="{'copy','csv','excel','pdf','print','colvis'}"; 
		$strOrden="[ 0, 'asc' ]"; 
		$intCantidad=10;
		$strNombreArchivo="transcriptores";

		echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
	}

	public static function consulta_edicion()
	{
		//
		return view::make('admin.transcriptor.consulta_edicion',compact('transcriptor'));
	}

	public function consulta2()
	{
		//
		return view::make('admin.transcriptor.consultar', compact('transcriptor'));
	}

	public static function edicion()
	{
		//
		$transcriptores = transcriptor::all();
		
		$strDatos="[";
		$end_data = transcriptor::count();

		foreach ($transcriptores as $key=>$transcriptores) {
    		$strDatos.="['".$transcriptores->transcriptor_id."',";
            $strDatos.="'".$transcriptores->medico_id."',";
            $strDatos.="'".$transcriptores->clinica_id."',";
            $strDatos.="'".$transcriptores->imagen_id."',";
            $strDatos.="'".$transcriptores->registro_id."',";
            $strDatos.="'".$transcriptores->historia."',";
            $strDatos.="'".$transcriptores->nombre_completo_paciente."',";
            $strDatos.="'".$transcriptores->factura."',";
            $strDatos.="'".$transcriptores->nro_orden."',";
            $strDatos.="'".$transcriptores->fecha_facturacion."',";
            $strDatos.="'".$transcriptores->fecha_entrega_seguro."',";
            $strDatos.="'".$transcriptores->monto_servicio."',";
            $strDatos.="'".$transcriptores->pago."',";
            $strDatos.="'".$transcriptores->saldo_pendiente."',";
            $strDatos.="'".$transcriptores->tipo_pago."',";
            $strDatos.="'".$transcriptores->estatus."',";
            $strDatos.="'".$transcriptores->id_tabla_atencion."',";
            $strDatos.="'<a href=\"tr_editar/$transcriptores->transcriptor_id\">Editar</a>']";
            if (! ($key == $end_data-1)==true) {
           		$strDatos.=",";
           	};
		}
		$strDatos.="]";
		$strTabla="transcriptores";
		$strColumnas="{ title: \"transcriptor_id\" },{ title: \"medico_id\" },{ title: \"clinica_id\" },{ title: \"imagen_id\" },{ title: \"registro_id\" },{ title: \"historia\" },{ title: \"nombre_completo_paciente\" },{ title: \"factura\" },{ title: \"nro_orden\" },{ title: \"fecha_facturacion\" },{ title: \"fecha_entrega_seguro\" },{ title: \"monto_servicio\" },{ title: \"pago\" },{ title: \"saldo_pendiente\" },{ title: \"tipo_pago\" },{ title: \"estatus\"},{ title: \"id_tabla_atencion\"},{ title: \"editar\"}";
		
		$strtfoot="<th>transcriptor_id</th><th>medico_id</th><th>clinica_id</th><th>imagen_id</th><th>registro_id</th><th>historia</th><th>nombre_completo_paciente</th><th>factura</th><th>nro_orden</th><th>fecha_facturacion</th><th>fecha_entrega_seguro</th><th>monto_servicio</th><th>pago</th><th>saldo_pendiente</th><th>tipo_pago</th><th>estatus</th><th>id_tabla_atencion</th><th>editar</th>";
		$strOpciones="{'copy','csv','excel','pdf','print','colvis'}"; 
		$strOrden="[ 0, 'asc' ]"; 
		$intCantidad=10;
		$strNombreArchivo="transcriptores";


		echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
	}
}
