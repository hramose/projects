<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

use App\cirugias;

$cirugias = Cirugias::where('id', '=', $id)->take(10)->get();
$id_medico=0;
foreach ($cirugias as $key=>$cirugias) {
    $id_medico=$cirugias->id_medico;
}


$privilegio=FuncionesControllers::buscar_privilegio(Session::get("id_usuario"));

?>
<div id="step-1">
    {{ FuncionesControllers::buscar_medico($id_medico) }}
</div>