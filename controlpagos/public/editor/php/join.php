<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;
use App\Http\Controllers\CirugiaControllers;
use Session;
use DB;
use View;
use Form;
use Illuminate\Support\Facades\URL;
?>

<?php

// DataTables PHP library
include( "DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\MleftJoin,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;

/*
* Example PHP implementation used for the leftJoin.html example
*/

$id_medico=$_GET["id_medico"];
$fecha1=$_GET["fecha1"];
$fecha2=$_GET["fecha2"];
$consulta=$_GET["consulta"];
$id_cirugia=$_GET["id_cirugia"];

Editor::inst( $db, 'datos_cirugia' )
	->field(
		Field::inst( 'datos_cirugia.id_cirugia' ),
		Field::inst( 'datos_cirugia.id_tipo_atencion' )
			->options( 'tipos_atencion', 'id', 'nombre' ),
		Field::inst( 'tipos_atencion.nombre' ),
		Field::inst( 'cirugias.nombre' ),
	    Field::inst( 'datos_cirugia.monto' )
	    	->validator( 'Validate::numeric' )
			->validator( 'Validate::notEmpty' ),
	    Field::inst( 'datos_cirugia.fecha_carga' )
			->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_822 )
			->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 ),
	    Field::inst( 'datos_cirugia.fecha_alta' ),
	    Field::inst( 'cirugias.seguros' ),
	    Field::inst( 'clinica_medico.nombre' ),
	    Field::inst( 'datos_cirugia.observaciones' )
			->validator( 'Validate::maxLen', 120)
	)
    ->where( 'datos_cirugia.id_cirugia', $id_cirugia )
    ->where( 'datos_cirugia.id_tipo_atencion', 3, '!=' )
    ->where( 'datos_cirugia.id_tipo_atencion', 7, '!=' )
    ->leftJoin( 'tipos_atencion', 'tipos_atencion.id', '=', 'datos_cirugia.id_tipo_atencion' )
    ->leftJoin( 'cirugias', 'datos_cirugia.id_cirugia', '=', 'cirugias.id' )
	->leftJoin( 'clinica_medico', 'clinica_medico.id_clinica', '=', 'cirugias.id_clinica' )	

	->process($_POST)
	->json();