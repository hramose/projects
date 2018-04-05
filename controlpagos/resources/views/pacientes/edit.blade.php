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

	{!! Form::model($paciente, array('url' => 'guardar_paciente_edicion', 'method' => 'put', 'class' =>  "form-horizontal", 'files'=>true)) !!}
    <h2>Editar Paciente: {{ $paciente->nombres }}</h2><hr />
	
	<span class="msj">{{ Session::get("mensaje") }}</span>

<input type="hidden" name="id" value="<?=$paciente->id?>" />

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombres <span class="msj">(*)</span>:</label>
    <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="nombres" name="nombres" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombres" value="<?=$paciente->nombres?>">
    </div>
    <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="apellidos" name="apellidos" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Apellidos" value="<?=$paciente->apellidos?>">
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Cedula <span class="msj">(*)</span>:</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="cedula" name="cedula" type="text" class="form-control" placeholder="Cedula" required="required" value="<?=$paciente->cedula?>">
    </div>
</div>

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Edad <span class="msj">(*)</span>:</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="edad" name="edad" type="number" class="form-control" required="required" placeholder="Edad" value="<?=$paciente->edad?>">
    </div>
</div>

<br />
<div class="ln_solid"></div>
<div class="form-group" align="center">
{!! Form::submit('Guardar Paciente', array('class'=>'send-btn', 'class'=>'btn btn-primary')) !!}
</div>
{!! Form::close() !!}

@include ('layaout.footer_admin')