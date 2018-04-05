<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>
<div id="step-5">
    <h2 class="StepTitle">Datos Cirugia</h2>

    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de Carga / Alta<span class="msj">(*)</span></label>
        <div class="col-xs-3">
            <input readonly value="{{  Session::get('fecha') }}" data-inputmask="'mask': '99/99/9999'" id="fecha_carga" name="fecha_carga" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
        </div>
        <div class="col-xs-3">
            <input readonly data-inputmask="'mask': '99/99/9999'" id="fecha_alta" name="fecha_alta" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
        </div>                
    </div>   
       
    <div class="item form-group">
        <label class="control-label col-xs-3">Observaciones / Referencia:</label>
        <div class="col-xs-3">
            <textarea id="observaciones" name="observaciones" class="form-control"><?=$observaciones?></textarea>
        </div>
        <div class="col-xs-3">
            <textarea id="referencias" name="referencias" class="form-control"><?=$referencias?></textarea>
        </div>
    </div> 
    <div class="item form-group">
        <label class="control-label col-xs-3">Habitacion</label>
        <div class="col-xs-3">
            <input id="habitacion" name="habitacion" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Habitacion" value="">
        </div>
    </div>
</div>