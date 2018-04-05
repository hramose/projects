<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>

@include ('layaout.header_admin')

    {!! Form::model($especialidad,array('url' => 'guardar_especialidad_edicion', 'method' => 'put', 'class' =>  "form-horizontal", 'files'=>true)) !!}
        <h2>Editar especialidad </h2><hr />
		
		<span class="msj">{{ Session::get("mensaje") }}</span>

        <input type="hidden" name="id" value="<?=$especialidad->id?>" />

        <div class="item form-group">
            <label class="control-label col-md-6 col-sm-6 col-xs-12">Nombre <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="nombre" name="nombre" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombre" value="<?=$especialidad->nombre?>">
            </div>
        </div>

        <br />
        <div class="ln_solid"></div>
        <div class="form-group" align="center">
            {!! Form::submit('Guardar', array('class'=>'send-btn', 'class'=>'btn btn-primary')) !!}
        </div>
    {!! Form::close() !!}

@include ('layaout.footer_admin')
