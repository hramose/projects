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

	{!! Form::model($medicos, array('url' => 'guardar_usuario_edicion', 'method' => 'put', 'class' =>  "form-horizontal", 'files'=>true)) !!}
    <h2>Editar Medico: {{ $medicos->nombres }}</h2><hr />
	
	<span class="msj">{{ Session::get("mensaje") }}</span>

<input type="hidden" name="id" value="<?=$medicos->id?>" />

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombres <span class="msj">(*)</span>:</label>
    <div class="col-md-3">
        <input id="nombres" name="nombres" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombres" value="<?=$medicos->nombres?>">
    </div>
    <div class="col-md-3">
        <input id="apellidos" name="apellidos" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Apellidos" value="<?=$medicos->apellidos?>">
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nro Colegio de medicos <span class="msj">(*)</span>:</label>
    <div class="col-md-6">
        <input id="cedula" name="cedula" type="text" class="form-control" placeholder="Nro Colegio de medicos" required="required" value="<?=$medicos->cedula?>">
    </div>
</div>

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Especialidad</label>
    <div class="col-md-6">
        <input id="especialidad" name="especialidad" type="text" class="form-control" value="{{ FuncionesControllers::buscar_especialidades($medicos->id_especialidad) }}" />
        <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
    </div>
    Nota: Para agregar la especialidad, debe colocar el nombre de la misma y para agregar otra, debe presionar la tecla enter.
</div>

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Telefono Principal</label>
    <div class="col-md-6">
        <input value="<?=$medicos->telefono_hab?>" id="telefono_hab" name="telefono_hab" type="text" class="form-control" data-inputmask="'mask' : '(9999) 999-9999'">
        <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Telefono Celular</label>
    <div class="col-md-6">
        <input value="<?=$medicos->telefono_cel?>" id="telefono_cel" name="telefono_cel" type="text" class="form-control" data-inputmask="'mask' : '(9999) 999-9999'">
        <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sexo</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <select class="form-control" id="sexo" name="sexo" id="sexo">
            {{ FuncionesControllers::crear_combo_maestro('sexo', $medicos->sexo) }}
        </select>
    </div>
</div>

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo de Recepcion de Repcepcion <span class="msj">(*)</span></label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{ FuncionesControllers::opciones_check('tipo_recepcion', $medicos->id_tipo_recepcion) }}
    </div>
</div>

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de Nacimiento <span class="msj">(*)</span></label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input data-inputmask="'mask': '99/99/9999'" id="fecha_nacimiento" name="fecha_nacimiento" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" value="{{ FuncionesControllers::fecha_normal($medicos->fecha_nacimiento) }}">
        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
    </div>
</div>

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="msj">(*)</span></label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="email" name="email" type="email" class="form-control" required="required" placeholder="Email" value="<?=$medicos->email?>">
        <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
    </div>
</div>

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Direccion:</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <textarea id="direccion" name="direccion" class="form-control"><?=$medicos->direccion?></textarea>
    </div>
</div>

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Twitter:</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="twitter" name="twitter" type="text" class="form-control" placeholder="Twitter" value="<?=$medicos->twitter?>">
        <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
    </div>
</div>

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Facebook:</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="facebook" name="facebook" type="text" class="form-control" placeholder="Facebook" value="<?=$medicos->facebook?>">
        <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
    </div>
</div>

<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pregunta Secreta <span class="msj">(*)</span></label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="pregunta_secreta" name="pregunta_secreta" type="text" class="form-control" required="required" placeholder="Pregunta Secreta" value="<?=$medicos->pregunta_secreta?>">
        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
    </div>    
</div>
<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Respuesta Secreta <span class="msj">(*)</span></label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="respuesta_secreta" name="respuesta_secreta" type="text" class="form-control" required="required" placeholder="Respuesta Secreta" value="<?=$medicos->respuesta_secreta?>">
        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
    </div>    
</div>
<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Foto:</label>
    <div class="col-xs-9">
        {!! Form::file('foto') !!}
    </div>
</div>
<br />
<div class="ln_solid"></div>
<div class="form-group" align="center">
<!--{!! Form::button('send', array('class'=>'send-btn', 'class'=>'btn btn-primary','onclick'=>'validar_especialidad(this.form)')) !!}-->
<button id="send" type="submit" class="btn btn-success">Guardar Medico</button>
</div>
{!! Form::close() !!}

@include ('layaout.footer_admin')