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

Editor::inst( $db, 'cirugias' )
	->field(
		Field::inst( 'cirugias.id' ),
		Field::inst( 'datos_cirugia.tipo_atencion' ),
		Field::inst( 'cirugias.nombre' ),
	    Field::inst( 'medico_cirugia.rol' )
	    	->validator( 'Validate::notEmpty' ),
	    Field::inst( 'medico_cirugia.monto' )
	    	->validator( 'Validate::numeric' )
			->validator( 'Validate::notEmpty' ),
	    Field::inst( 'datos_cirugia.fecha_carga' )
	    	->validator( 'Validate::dateFormat', array(
				"format"  => Format::DATE_ISO_822,
				"message" => "Please enter a date in the format yyyy-mm-dd"
			) )
			->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_822 )
			->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_822 ),
	    Field::inst( 'datos_cirugia.fecha_alta' ),
	    Field::inst( 'cirugias.seguros' ),
	    Field::inst( 'clinica_medico.nombre' )
	)
    ->leftJoin( 'datos_cirugia', 'datos_cirugia.id_cirugia', '=', 'cirugias.id' )
	->leftJoin( 'medico_cirugia', 'medico_cirugia.id_cirugia', '=', 'cirugias.id and medico_cirugia.rol!=\'\'' )	
	->leftJoin( 'clinica_medico', 'clinica_medico.id_clinica', '=', 'cirugias.id_clinica' )	
    ->where( 'datos_cirugia.id_cirugia', $id_cirugia )
    ->where( 'datos_cirugia.id_tipo_atencion', 3, '=' )
	->process($_POST)
	->json();