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

	{!! Form::open(array('url' => 'guardar_usuario_nuevo_sist', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
    <h2>Nuevo Usuario </h2><hr />
	
	<span class="msj">{{ Session::get("mensaje") }}</span>

<input type="hidden" name="id" value="<?=$id?>" />
<input type="hidden" name="id_especialidad" value="" />

<div class="item form-group">
    <label class="control-label col-xs-3">Nombre <span class="msj">(*)</span>:</label>
    <div class="col-xs-3">
        <input id="nombres" name="nombre" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombres" value="<?=$nombres?>">
    </div>
    <div class="col-xs-3">
        <input id="apellidos" name="apellidos" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Apellidos" value="<?=$apellidos?>">
    </div>    
</div>

<div class="item form-group">
    <label class="control-label col-xs-3">Cedula <span class="msj">(*)</span>:</label>
    <div class="col-xs-3">
        <input id="cedula" name="cedula" type="text" class="form-control" placeholder="Cedula" value="<?=$cedula?>">
    </div>
</div>

<div class="item form-group">
    <label class="control-label col-xs-3">Telefono Principal</label>
    <div class="col-xs-3">
        <input id="telefono_hab" name="telefono_hab" type="number" class="form-control" required="required" placeholder="Telefono Principal" value="<?=$telefono_hab?>">
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-xs-3">Telefono Celular</label>
    <div class="col-xs-3">
        <input id="telefono_cel" name="telefono_cel" type="number" class="form-control" placeholder="Telefono Celular" value="<?=$telefono_cel?>">
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-xs-3">Sexo</label>
    <div class="col-xs-3">
        <select class="form-control" id="sexo" name="sexo" id="sexo">
        	{{ FuncionesControllers::crear_combo_maestro('sexo', $sexo) }}
        </select>
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-xs-3">Tipo de Recepcion de Repcepcion <span class="msj">(*)</span></label>
    <div class="col-xs-3">
        <select class="form-control" id="id_tipo_recepcion" name="id_tipo_recepcion" id="id_tipo_recepcion">
            {{ FuncionesControllers::crear_combo_maestro('tipo_recepcion', $tipo_recepcion) }}
        </select>
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de Nacimiento <span class="msj">(*)</span></label>
    <div class="col-xs-3">
        <input id="fecha_nacimiento" name="fecha_nacimiento" class="date-picker form-control col-md-7 col-xs-12" placeholder="Fecha de Nacimiento" type="date" required="required" data-parsley-id="8386">
        <ul id="parsley-id-8386" class="parsley-errors-list"></ul>
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-xs-3">Email <span class="msj">(*)</span></label>
    <div class="col-xs-3">
        <input id="email" name="email" type="email" class="form-control" required="required" placeholder="Email" value="<?=$email?>">
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-xs-3">Direccion:</label>
    <div class="col-xs-3">
        <textarea id="direccion" name="direccion" class="form-control"><?=$direccion?></textarea>
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-xs-3">Password <span class="msj">(*)</span></label>
    <div class="col-xs-3">
        <input id="contrasena" name="contrasena" data-validation="length alphanumeric" data-validation-length="min8" type="password" class="form-control" required="required" placeholder="Password" value="">
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-xs-3">Ingrese de nuevo su password <span class="msj">(*)</span></label>
    <div class="col-xs-3">
        <input id="contrasena2" name="contrasena2" data-validate-linked="contrasena" type="password" class="form-control" required="required" placeholder="Password" value="">
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-xs-3">Pregunta Secreta <span class="msj">(*)</span></label>
    <div class="col-xs-3">
        <input id="pregunta_secreta" name="pregunta_secreta" type="text" class="form-control" required="required" placeholder="Pregunta Secreta" value="<?=$pregunta_secreta?>">
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-xs-3">Respuesta Secreta <span class="msj">(*)</span></label>
    <div class="col-xs-3">
        <input id="respuesta_secreta" name="respuesta_secreta" type="text" class="form-control" required="required" placeholder="Respuesta Secreta" value="<?=$respuesta_secreta?>">
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-xs-3">Foto:</label>
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