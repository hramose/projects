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

    {!! Form::model($seguro,array('url' => 'guardar_seguro_edicion', 'method' => 'put', 'class' =>  "form-horizontal", 'files'=>true)) !!}
    <h2>Editar seguro</h2> <hr />
	
	<span class="msj">{{ Session::get("mensaje") }}</span>

<input type="hidden" name="id" value="<?=$seguro->id?>" />
<input type="hidden" name="id_especialidad" value="" />

<div class="item form-group">
    <label class="control-label col-md-6 col-sm-6 col-xs-12">Nombre <span class="msj">(*)</span>:</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="nombre" name="nombre" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombre" value="<?=$seguro->nombre?>">
    </div>
</div>

<div class="item form-group">
    <label class="control-label col-md-6 col-sm-6 col-xs-12">Direccion:</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <textarea id="direccion" name="direccion" class="form-control"><?=$seguro->direccion?></textarea>
    </div>
</div>

<br />
<div class="ln_solid"></div>
<div class="form-group" align="center">
{!! Form::submit('Guardar', array('class'=>'send-btn', 'class'=>'btn btn-primary')) !!}
</div>
{!! Form::close() !!}

@include ('layaout.footer_admin')