<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use URL;
use App\Http\Controllers\FuncionesControllers;

?>

@include ('layout.header')

<style type="text/css" media="all">
	@import 'css/texto/info.css';
	<!--@import "css/texto/main.css";
	@import "css/texto/widgEditor.css";-->
</style>

     {!! Form::model($bateria,array( 'name'=>"forma", 'url' => 'guardar_bateria_edicion', 'method' => 'put', 'class' =>  "form-horizontal", 'files'=>true, 'onSubmit'=>"guardar()")) !!}
		
		<input type="hidden" name="id" value="<?=$bateria->id?>" />
		
		<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
		<input type="hidden" name="texto" id="texto" value="" />
		
<div class="row">
		<div align="left" class="alert alert-danger alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
			{{ Session::get("mensaje") }}
		</div>	

		<div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="nombre" name="nombre" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombre" value="<?=$bateria->nombre?>">
            </div>
        </div>
		
<!-- Tablas Genericas -->
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Funcion <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <!--input id="funcion" name="funcion" type="text" required="required" class="form-control" placeholder="Funcion" value="<?=FuncionesControllers::buscarTablaFuncion($bateria->id)?>"-->
				<select class="form-control" id="funcion" name="funcion">
					<option value="generar_resultado_hi" <?php if (FuncionesControllers::buscarTablaFuncion($bateria->id)=="generar_resultado_hi") echo "selected"; ?>>generar_resultado_hi</option>
					<option value="generar_resultado_epa" <?php if (FuncionesControllers::buscarTablaFuncion($bateria->id)=="generar_resultado_epa") echo "selected"; ?>>generar_resultado_epa</option>
					<option value="generar_resultado_octagon" <?php if (FuncionesControllers::buscarTablaFuncion($bateria->id)=="generar_resultado_octagon") echo "selected"; ?>>generar_resultado_octagon</option>
				</select>            
			</div>
        </div>			
		
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Opciones <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <!--input id="opciones" name="opciones" type="text" required="required" class="form-control" placeholder="Opciones" value="<?=FuncionesControllers::buscarTablaOpciones($bateria->id)?>"-->
				<select class="form-control" id="opciones" name="opciones">
					<option value="opciones_hl" <?php if (FuncionesControllers::buscarTablaOpciones($bateria->id)=="opciones_hl") echo "selected"; ?>>opciones_hl</option>
					<option value="opciones_epa" <?php if (FuncionesControllers::buscarTablaOpciones($bateria->id)=="opciones_epa") echo "selected"; ?>>opciones_epa</option>
					<option value="opciones" <?php if (FuncionesControllers::buscarTablaOpciones($bateria->id)=="opciones") echo "selected"; ?>>opciones</option>
				</select>	            
			</div>
        </div>	

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Preguntas <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <!--input id="preguntas" name="preguntas" type="text" required="required" class="form-control" placeholder="Preguntas" value="<?=FuncionesControllers::buscarTablaPreguntas($bateria->id)?>"-->
				<select class="form-control" id="preguntas" name="preguntas">
					<option value="preguntas_hl" <?php if (FuncionesControllers::buscarTablaPreguntas($bateria->id)=="preguntas_hl") echo "selected"; ?>>preguntas_hl</option>
					<option value="preguntas_epa" <?php if (FuncionesControllers::buscarTablaPreguntas($bateria->id)=="preguntas_epa") echo "selected"; ?>>preguntas_epa</option>
					<option value="preguntas" <?php if (FuncionesControllers::buscarTablaPreguntas($bateria->id)=="preguntas") echo "selected"; ?>>preguntas</option>
				</select>	            
			</div>
        </div>	

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Resultados <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <!--input id="resultados" name="resultados" type="text" required="required" class="form-control" placeholder="Resultados" value="<?=FuncionesControllers::buscarTablaResultados($bateria->id)?>"-->
				<select class="form-control" id="resultados" name="resultados">
					<option value="respuestas_hl" <?php if (FuncionesControllers::buscarTablaResultados($bateria->id)=="respuestas_hl") echo "selected"; ?>>respuestas_hl</option>
					<option value="respuestas_epa" <?php if (FuncionesControllers::buscarTablaResultados($bateria->id)=="respuestas_epa") echo "selected"; ?>>respuestas_epa</option>
					<option value="respuestas" <?php if (FuncionesControllers::buscarTablaResultados($bateria->id)=="respuestas") echo "selected"; ?>>respuestas</option>
				</select>	
			</div>
        </div>	

<!-- Tablas Genericas -->			
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-122">Pruebas</label>
			<div class="col-md-6 col-sm-6 col-xs-12">		
				{{ FuncionesControllers::crear_check('tipos_pruebas', 'id_tipos_pruebas',$bateria->id) }}
            </div>
        </div>			
				
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Estatus <span class="msj">(*)</span>:</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<div class="radio">
					<input class="flat" type="checkbox" id="activa" name="activa" value="1" <?php if ($bateria->activa==1) echo "checked"; ?>> Activo
				</div>
			</div>
        </div>

        <br />
        <div class="ln_solid"></div>
        <div class="form-group" align="center">
            {!! Form::submit('Guardar', array('class'=>'send-btn', 'class'=>'btn btn-primary')) !!}
        </div>
</div>
    {!! Form::close() !!}

@include ('layout.footer')
