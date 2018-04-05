<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>
<div id="step-3">
    <h2 class="StepTitle">Nuevo Paciente</h2>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3">Nombres<span class="msj">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-9">
                    <input id="nombres" name="nombres" maxlength="25" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombres" value="">
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3">Apellidos<span class="msj">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-9">
                    <input id="apellidos" name="apellidos" maxlength="25" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Apellidos" value="">
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3">Cedula<span class="msj">*</span></label>
                <div class="col-md-3 col-sm-3 col-xs-9">
                    <input required="required" onblur="buscar_paciente(this.value)" maxlength="9" id="cedula" name="cedula" type="text" data-validate-minmax="10,99999999" class="form-control" placeholder="Cedula" required="required" value="">
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3">Edad</label>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <input required="required" id="edad" name="edad" type="text" maxlength="3" class="form-control" data-validate-minmax="0,110" placeholder="Edad" value="">
                </div>
            </div>
        <div class="ln_solid"></div>        
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3">Tipo de Atencion<span class="msj">*</span>:</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    {{ FuncionesControllers::opciones_radio ('tipo_atencion', 0) }}                          
                </div>                          
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3">Diagnostico<span class="msj">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-9">
                    <input id="diagnostico" maxlength="60" name="diagnostico" type="text" data-validate-words="1" required="required" class="form-control" placeholder="Diagnostico" value="">
                </div> 
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3">Fecha de Diagnostico<span class="msj">*</span></label>
                <div class="col-md-3">
                    <input readonly value="{{ Session::get('fecha') }}" id="fecha_cirugia" name="fecha_cirugia" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                </div>    
            </div>        

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3">Especialidad</span></label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div id="datos_especialidad">{{ FuncionesControllers::mostrar_especialidades(Session::get("id_medico"),0) }}</div>
                </div>
            </div>         

            <div id="ver_tipo_atencion"></div>
</div>