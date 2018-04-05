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

    {!! Form::open(array('url' => 'guardar_clinica_nuevo', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
    <h2>Nuevo Clinica</h2> <hr />
	
	<span class="msj">{{ Session::get("mensaje") }}</span>

<input type="hidden" name="id" value="<?=$id?>" />
<input type="hidden" name="id_especialidad" value="" />

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre <span class="msj">(*)</span>:</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="nombre" name="nombre" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombre" value="">
    </div>
</div>

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Color</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="input-group demo2">
            <input id="color" readonly name="color" type="text" value="{{ FuncionesControllers::buscar_color_clinica($id) }}" class="form-control" />
            <span class="input-group-addon"><i></i></span>
        </div>
    </div>
</div>

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Direccion:</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <textarea id="direccion" name="direccion" class="form-control"></textarea>
    </div>
</div>

<div class="item form-group">    
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pais <span class="msj">(*)</span></label>
    <div class="col-md-6 col-sm-6 col-xs-12">        
        <select class="form-control" id="pais" name="pais">
            {{ FuncionesControllers::crear_combo_maestro('pais', $pais) }}
        </select>
    </div> 
</div>

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ciudad <span class="msj">(*)</span>:</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="ciudad" name="ciudad" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Ciudad" value="">
    </div>
</div>

<br />
<div class="ln_solid"></div>
<div class="form-group" align="center">
{!! Form::submit('Guardar', array('class'=>'send-btn', 'class'=>'btn btn-primary')) !!}
</div>
{!! Form::close() !!}

@include ('layaout.footer_admin')