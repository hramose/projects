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
$id_clinica=0;
foreach ($cirugias as $key=>$cirugias) {
    $id_clinica=$cirugias->id_clinica;
}

?>
<div id="step-2">
    <h2 class="StepTitle">Clinica</h2>
    <div class="item form-group">    
        <label class="control-label col-xs-3">Clinica <span class="msj">(*)</span></label>
        <div class="col-xs-3">
            <select class="form-control" id="id_clinica" name="id_clinica" onchange="buscar_datos_clinica(this.value)">
                <option value=0>Selecciones la Clinica...</option>
                {{ FuncionesControllers::crear_combo('clinica', $id_clinica) }}
            </select>
        </div> 
    </div>
    <div id="datos_clinica"></div>
</div>

<script type="text/javascript">buscar_datos_clinica(<?=$id_clinica?>);</script>