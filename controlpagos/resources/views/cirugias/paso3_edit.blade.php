<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;
use App\paciente;
use App\cirugias;
use App\nro_historia;

$cirugias = Cirugias::where('id', '=', $id)->take(10)->get();
$id_paciente=0;
$id_clinica=0;
foreach ($cirugias as $key=>$cirugias) {
    $id_paciente=$cirugias->id_paciente;
    $id_clinica=$cirugias->id_clinica;
}

$paciente = paciente::where('id', '=', $id_paciente)->take(10)->get();
$nombres='';
$apellidos='';
$cedula_paciente='';
foreach ($paciente as $key=>$paciente) {
    $nombres=$paciente->nombres;
    $apellidos=$paciente->apellidos;
    $cedula_paciente=$paciente->cedula;
}

$nro_historia = nro_historia::where('id_clinica', '=', $id_clinica)
                            ->where('id_paciente', '=', $id_paciente)
                            ->take(10)->get();
$nro_historia_paciente="";
foreach ($nro_historia as $key=>$nro_historia) {
    $nro_historia_paciente=$nro_historia->nro_historia;
}

?>
<div id="step-3">
    <h2 class="StepTitle">Paciente</h2>
    <div class="item form-group">    
        <label class="control-label col-xs-3">Cedula <span class="msj">(*)</span></label>
        <div class="col-xs-3">
			<input id="cedula_paciente" name="cedula_paciente" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Cedula Paciente" value="<?=$cedula_paciente?>">
        </div> 
    </div>
    <div class="item form-group">    
        <label class="control-label col-xs-3">Nro Historia <span class="msj">(*)</span></label>
        <div class="col-xs-3">
			<input id="nro_historia" name="nro_historia" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nro de Historia" value="<?=$nro_historia_paciente?>">
        </div> 
    </div>
    <br />
    <div align="center">
    	{!! Form::button('Buscar', array('class'=>'send-btn', 'class'=>'btn btn-primary','onclick'=>'buscar_paciente(this.form)')) !!} 
	</div>
    <br />
    <div id="datos_paciente"></div>
</div>

<script type="text/javascript">buscar_paciente(document.forms[0]);</script>