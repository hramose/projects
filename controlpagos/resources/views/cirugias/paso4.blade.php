<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>
<div id="step-4">
    <h2 class="StepTitle">Cirugia</h2>
        <div class="item form-group">    
            <label class="control-label col-xs-3">Nombre Cirugia <span class="msj">(*)</span></label>
            <div class="col-xs-3">
                <input id="nombre" name="nombre" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombre Cirugia" value="">
            </div> 
        </div>  

        <div class="item form-group">
            <label class="control-label col-xs-3">Moneda:</span></label>
            <div class="col-xs-3">
                <select class="form-control" id="id_moneda" nombre="id_moneda" disabled>
                    <option value=0>Selecciones la Moneda...</option>
                    {{ FuncionesControllers::crear_combo_moneda('moneda', $id_moneda) }}
                </select>
            </div>
        </div>

        <div class="item form-group">
            <label class="control-label col-xs-3">Especialidad:</span></label>
            <div class="col-xs-3">
                <div id="datos_especialidad">{{ FuncionesControllers::mostrar_especialidades(Session::get("id_medico"),0) }}</div>
            </div>
        </div>      

        <div class="item form-group">
            <label class="control-label col-xs-3">Rol:</span></label>
            <div class="col-xs-3">
                <div id="datos_rol">{{ FuncionesControllers::opciones_check ('rol', 0) }}</div>
            </div>
        </div>        

        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de Cirugía <span class="msj">(*)</span></label>
            <div class="col-xs-3">
                <input readonly value="{{  Session::get('fecha') }}" data-inputmask="'mask': '99/99/9999'" id="fecha_cirugia" name="fecha_cirugia" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
            </div>    
        </div>
    
        <div class="item form-group">
            <label class="control-label col-xs-3">Nro de Caso <span class="msj">(*)</span></label>
            <div class="col-xs-3">
                <input id="nro_caso" name="nro_caso" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nro de Caso" value="<?=$nro_caso?>">
            </div> 
        </div>    
        <div class="item form-group">
            <label class="control-label col-xs-3">Imagen Sticker:</label>
            <div class="col-xs-9">
                {!! Form::file('img_sticker') !!}
            </div>
        </div>

    <div class="item form-group">
        <div class="col-xs-3">
            <a href="javascript:;" onclick="agregar_seguro({{ Session::get('id') }})">Agregar Seguro<i class="fa fa-plus-square"></i></a>
        </div>
    </div>

     <div id="datos_seguro"></div>
</div>