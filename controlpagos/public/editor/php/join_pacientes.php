<?php

// DataTables PHP library
include( "../../php/DataTables.php" );

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

$format = isset( $_GET['format'] ) ?
	$_GET['format'] :
	'';

if ( $format === 'custom' ) {
	$update = 'n/j/Y';
	$registered = 'l j F Y';
}
else {
	$update = Format::DATE_ISO_8601;
	$registered = Format::DATE_ISO_8601;
}

$medico=2;

Editor::inst( $db, 'paciente' )
	->field(
		Field::inst( 'paciente.nombres' ),
		Field::inst( 'paciente.apellidos' ),
		Field::inst( 'paciente.cedula' )
			->validator( 'Validate::numeric' )
			->setFormatter( 'Format::ifEmpty', null ),
		Field::inst( 'paciente.edad' )
			->validator( 'Validate::numeric' )
			->setFormatter( 'Format::ifEmpty', null ),
		Field::inst( 'cirugias.nombre' )
	)
	->where( 'paciente.id_medico', 2 )
	->leftJoin( 'cirugias', 'cirugias.id_paciente', '=', 'paciente.id' )
	->leftJoin( 'clinica_medico', 'clinica_medico.id_clinica', '=', 'cirugias.id_clinica' )
	->leftJoin( 'seguros_medicos', 'seguros_medicos.id_medico', '=', "clinica_medico.id_medico" )
	->leftJoin( 'medico_cirugia', 'medico_cirugia.id_cirugia', '=', 'cirugias.id' )
	->leftJoin( 'datos_cirugia', 'datos_cirugia.id_cirugia', '=', 'cirugias.id' )
	->leftJoin( 'cirugia_seguro', 'cirugia_seguro.id_cirugia and cirugia_seguro.id_seguro', '=', 'cirugias.id and seguros_medicos.id' )	
	->leftJoin( 'maestro', 'maestro.padre and datos_cirugia.id_tipo_atencion', '=', '"tipo_atencion" and maestro.id_campo' )	
	
	->process($_POST)
	->json();
