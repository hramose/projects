<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use App\imagen;
use App\Http\Controllers\FuncionesControllers;


class ImagenesControllers extends Controller {

	/**
	 * Display a listing of the resource.
	 * GET 
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return view::make('admin.imagen.nuevo');
	}


	public function create()
	{
		//
		return view::make('admin.imagen.crear');
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
		$imagenes = new imagen();
		$imagenes->fill(Request::all());
		$imagenes->save();
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
		$imagenes =  imagen::findOrFail($id);
		return view::make('admin.imagen.editar', compact('imagen'));
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
		$imagenes =  imagen::findOrFail($id);
		$imagenes->fill(Request::all());
		$imagenes->save();
		return Redirect::route('im_con');
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
		$imagenes = imagen::all();
		
		$strDatos="[";
		$end_data = imagen::count();

		foreach ($imagenes as $key=>$imagenes) {
    		$strDatos.="['".$imagenes->imagen_id."',";
            $strDatos.="'".$imagenes->medico_id."',";
            $strDatos.="'".$imagenes->clinica_id."',";
            $strDatos.="'".$imagenes->descripcion."',";
            $strDatos.="'".$imagenes->nombre_archivo."',";
            $strDatos.="'".$imagenes->fecha_fin_mes."',";
            $strDatos.="'".$imagenes->consecutivo."',";
            $strDatos.="'".$imagenes->tipo_imagen."',";
            $strDatos.="'".$imagenes->estatus."']";
            if (! ($key == $end_data-1)==true) {
           		$strDatos.=",";
           	};
		}
		$strDatos.="]";
		$strTabla="imagenes";
		$strColumnas="{ title: \"imagen_id\" },{ title: \"medico_id\" },{ title: \"clinica_id\" },{ title: \"descripcion\" },{ title: \"nombre_archivo\" },{ title: \"fecha_fin_mes\" },{ title: \"consecutivo\" },{ title: \"tipo_imagen\" },{ title: \"estatus\"}";
		
		$strtfoot="<th>imagen_id</th><th>medico_id</th><th>clinica_id</th><th>descripcion</th><th>nombre_archivo</th><th>fecha_fin_mes</th><th>consecutivo</th><th>tipo_imagen</th><th>estatus</th>";
		$strOpciones="{'copy','csv','excel','pdf','print','colvis'}"; 
		$strOrden="[ 0, 'asc' ]"; 
		$intCantidad=10;
		$strNombreArchivo="imagenes";

		echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
	}

	public static function consulta_edicion()
	{
		//
		return view::make('admin.imagen.consulta_edicion',compact('imagen'));
	}

	public function consulta2()
	{
		//
		return view::make('admin.imagen.consultar', compact('imagen'));
	}

	public static function edicion()
	{
		//
		$imagenes = imagen::all();
		
		$strDatos="[";
		$end_data = imagen::count();

		foreach ($imagenes as $key=>$imagenes) {
    		$strDatos.="['".$imagenes->imagen_id."',";
            $strDatos.="'".$imagenes->medico_id."',";
            $strDatos.="'".$imagenes->clinica_id."',";
            $strDatos.="'".$imagenes->descripcion."',";
            $strDatos.="'".$imagenes->nombre_archivo."',";
            $strDatos.="'".$imagenes->fecha_fin_mes."',";
            $strDatos.="'".$imagenes->consecutivo."',";
            $strDatos.="'".$imagenes->tipo_imagen."',";
            $strDatos.="'".$imagenes->estatus."',";
            $strDatos.="'<a href=\"im_editar/$imagenes->imagen_id\">Editar</a>']";
            if (! ($key == $end_data-1)==true) {
           		$strDatos.=",";
           	};
		}
		$strDatos.="]";
		$strTabla="imagenes";
		$strColumnas="{ title: \"imagen_id\" },{ title: \"medico_id\" },{ title: \"clinica_id\" },{ title: \"descripcion\" },{ title: \"nombre_archivo\" },{ title: \"fecha_fin_mes\" },{ title: \"consecutivo\" },{ title: \"tipo_imagen\" },{ title: \"estatus\"}",{ title: \"editar\"}";
		
		$strtfoot="<th>imagen_id</th><th>medico_id</th><th>clinica_id</th><th>descripcion</th><th>nombre_archivo</th><th>fecha_fin_mes</th><th>consecutivo</th><th>tipo_imagen</th><th>estatus</th><th>editar</th>";
		$strOpciones="{'copy','csv','excel','pdf','print','colvis'}"; 
		$strOrden="[ 0, 'asc' ]"; 
		$intCantidad=10;
		$strNombreArchivo="imagenes";


		echo FuncionesControllers::datatable_llenar($strDatos, $strTabla, $strColumnas, $strtfoot, $strOpciones, $strOrden, $intCantidad, $strNombreArchivo);
	}
}
