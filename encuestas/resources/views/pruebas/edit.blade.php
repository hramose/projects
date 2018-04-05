<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

$tiempo=$tipos_pruebas->tiempo;
//echo "tiempo=$tiempo<br>";
$minutos=substr($tiempo,0,strpos($tiempo,"."));
//echo "minutos=$minutos<br>";
$segundos=substr($tiempo,strpos($tiempo,".")+1);
//echo "segundos=$segundos<br>";
?>

@include ('layout.header')

    {!! Form::model($tipos_pruebas,array('url' => 'guardar_prueba_edicion', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}
		
		<input type="hidden" name="id" value="<?=$tipos_pruebas->id?>" />
		<div class="row">
			<div align="left" class="alert alert-danger alert-dismissible fade in" style="font-size: 12pt; font-weight: bold;">
				{{ Session::get("mensaje") }}
			</div>

			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre <span class="msj">(*)</span>:</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="nombre" name="nombre" type="text" required="required" class="form-control" placeholder="Nombres" value="<?=$tipos_pruebas->nombre?>">
				</div>
			</div>
			
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">URL <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="url" name="url" type="text" required="required" class="form-control" placeholder="URL" value="<?=$tipos_pruebas->url?>">
            </div>
        </div>			
			
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Tiempo <span class="msj">(*)</span>:</label>
				<div class="col-md-3 col-sm-10 col-xs-10">
					<label class="btn btn-default" data-toggle-class="btn-info" data-toggle-passive-class="btn-default">
							<select class="form-control" id="minutos" name="minutos">
								<?php
									$selected="";
									for ($i=0; $i<180; $i++) {
										if ($i==$minutos)
											$selected="selected";
										else
											$selected="";
										echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
									}
								?>
							</select>
							<strong>Minutos</strong>
							<select class="form-control" id="segundos" name="segundos">
								<?php
									$selected="";
									for ($i=0; $i<61; $i++) {
										if ($i<10)
											$m="0".$i;
										else
											$m=$i;
										
										if ($i==$segundos)
											$selected="selected";
										else
											$selected="";										
										
										echo '<option value="'.$m.'" '.$selected.'>'.$m.'</option>';
									}
								?>
							</select>
							<strong>Segundos</strong>
					</label>
				</div>
			</div>				

			<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Activo <span class="msj">(*)</span>:</label>
				<div class="col-md-2">
					<label class="btn btn-default" data-toggle-class="btn-info" data-toggle-passive-class="btn-default">
						<input class="btn btn-success" type="radio" <?php if ($tipos_pruebas->activo==1) echo "checked"; ?> name="activo" value="1"> &nbsp; SI &nbsp;
						<input class="btn btn-info" type="radio" <?php if ($tipos_pruebas->activo==0) echo "checked"; ?> name="activo" value="0"> NO
					</label>
				</div>						
			</div>
	
			<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Muestra del tiempo:</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<label class="btn btn-default" data-toggle-class="btn-info" data-toggle-passive-class="btn-default">
						<input class="btn btn-success" type="radio" name="vista_tiempo" value="1" <?php if ($tipos_pruebas->vista_tiempo==1) echo "checked"; ?>> &nbsp; Si &nbsp;
						<input class="btn btn-info" type="radio" name="vista_tiempo" value="0" <?php if ($tipos_pruebas->vista_tiempo==0) echo "checked"; ?>> No
					</label>
				</div>						
			</div>			

			<br />
			<div class="ln_solid"></div>
			<div class="form-group" align="center">
				{!! Form::button('Guardar', array('class'=>'send-btn', 'class'=>'btn btn-primary', 'onClick'=>'guardar_edit()')) !!}
			</div>
		</div>
    {!! Form::close() !!}

@include ('layout.footer')
