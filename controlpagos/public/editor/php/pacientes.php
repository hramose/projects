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
$id_clinica=$_GET["id_clinica"];
$id_seguro=$_GET["id_seguro"];

$campo='id_tipo_atencion';
$valor=7;
$operador="=";

if ($consulta==1)
	$operador="!=";
elseif ($consulta==2)
	$operador="=";
else {
	$valor="null";
	$operador="!=";
}
$sql = 'select id from cirugias where fecha_cirugia between \''.$fecha1.'\' and  \''.$fecha2.'\'';

if ($consulta==2)
	$sql.=" and id in (select id_cirugia from alta)";
elseif ($consulta==1)
	$sql.=" and id not in (select id_cirugia from alta)";

//echo $sql;
Editor::inst( $db, 'paciente' )
	->field(
		Field::inst( 'paciente.nombres' )
			->validator( 'Validate::maxLen', 25 ),
		Field::inst( 'paciente.apellidos' )
			->validator( 'Validate::maxLen', 25 ),
		Field::inst( 'paciente.edad' )
			->validator( 'Validate::numeric' )
			->setFormatter( 'Format::ifEmpty', null )
			->validator( 'Validate::maxLen', 3 ),
		Field::inst( 'paciente.cedula' )
			->validator( 'Validate::numeric' )
			->setFormatter( 'Format::ifEmpty', null )
			->validator( 'Validate::maxLen', 10 ),
		Field::inst( 'cirugias.cirujano' ),
		Field::inst( 'cirugias.nombre' ),
		Field::inst( 'cirugias.fecha_cirugia' )
			->validator( 'Validate::dateFormat', array(
				"format"  => Format::DATE_ISO_822,
				"message" => "Please enter a date in the format yyyy-mm-dd"
			) )
			->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_822 )
			->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_822 ),
		Field::inst( 'cirugias.seguros' ),
		Field::inst( 'clinica_medico.nombre' ),
		Field::inst( 'cirugias.monto' )
	)
    //->where ('cirugias.id_clinica',  'null', 'is not')
    ->leftJoin( 'cirugias', 'cirugias.id_paciente', '=', "paciente.id" )
    //->leftJoin( 'datos_cirugia', 'datos_cirugia.id_cirugia', "=", "cirugias.id" )
	->leftJoin( 'clinica_medico', 'clinica_medico.id_clinica', '=', 'cirugias.id_clinica' )
	//->leftJoin( 'alta', 'alta.id_cirugia', "=", 'cirugias.id' )
	//->leftJoin( 'seguros_medicos', 'seguros_medicos.id_medico', '=', "clinica_medico.id_medico" )
	//->leftJoin( 'maestro', 'maestro.padre and datos_cirugia.id_tipo_atencion', '=', '"tipo_atencion" and maestro.id_campo' )	
	//->leftJoin( 'cirugia_seguro', 'cirugia_seguro.id_cirugia', '=', 'cirugias.id' )
	//->where( $campo, $valor, $operador )
    //->leftJoin( 'cirugias', 'cirugias.id_paciente', '=', "paciente.id and cirugias.fecha_cirugia between ".$fecha1." and ".$fecha2 )
    //->leftJoin( 'cirugias', 'cirugias.fecha_cirugia', '>=', $fecha1 )
    //->leftJoin( 'cirugias', 'cirugias.fecha_cirugia', '<=', $fecha2 )
    ->where ( function ( $r ) use ($sql, $id_medico) {
    	$medicos=explode(",", $id_medico);
    	for ($i=0; $i<count($medicos); $i++) {
        	$r->or_where( 'paciente.id_medico', $medicos[$i] );
        }    	
   		$r->where( 'cirugias.id','( '.$sql.' )', 'IN', false );
    } )
    ->where ( function ( $r ) use ($id_clinica, $id_seguro) {
    	if ($id_clinica>0)
        	$r->where( 'cirugias.id_clinica', $id_clinica );
    	if ($id_seguro>0)
        	$r->where( 'cirugias.id', '(select id_cirugia from cirugia_seguro where id_seguro='.$id_seguro.')', 'IN', false );
    } )
	->process($_POST)
	->json();