<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use Redirect;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\FoldersControllers;

?>

@include ('layaout.header_admin')
<?php
	if ($tipo=="medico") {
		echo "<br /><br /><div class='alert alert-info'><strong>Gracias por suscribirse, nuestro equipo estara revisardo susdatos y posteriormente autorizandolo a ingresar a nuestro portal.</strong>";
		echo "<br /><span class='forma_llena'>En los proximos minutos estara recibiendo un email dandole la bienvenida</span></div>";
	} elseif ($tipo=="paciente" || $tipo=="clinica" || $tipo=="seguro" || $tipo=="moneda" || $tipo=="especialidad" || $tipo=="cirugia_medico" || $tipo=="pago_medico") {
		echo "<div class='alert alert-info'><strong>Registro ingresado satisfactoriamente</strong></div>";
	} elseif ($tipo=="alta_cirugia") {
		echo "<div class='alert alert-info'><strong>Este paciente ya fue dado de alta</strong></div>";
	}

?>
@include ('layaout.footer_admin')