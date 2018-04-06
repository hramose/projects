<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\FoldersControllers;

?>

@include ('layaout.header_admin')
<?php
	if ($tipo=="medico") {
		echo "<span class='forma_llena'>Gracias por suscribirse, nuestro equipo estara revisardo susdatos y posteriormente autorizandolo a ingresar a nuestro portal.</span>";
		echo "<br /><span class='forma_llena'>En los proximos minutos estara recibiendo un email dandole la bienvenida</span>";
	}

?>
@include ('layaout.footer_admin')