<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

$privilegio=FuncionesControllers::buscar_privilegio(Session::get("id_usuario"));

?>
    <?php if ($privilegio==1 || $privilegio==3) { ?>
	    <div class="item form-group">
	        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nro de Colegio <span class="msj">(*)</span></label>
	        <div class="col-md-6 col-sm-6 col-xs-12">
				<input id="cedula_medico" name="cedula_medico" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nro de Colegio" value="<?=$cedula_medico?>">
	        </div> 
	    </div>
	    <br />
	    <div align="center">
	    	{!! Form::button('Buscar', array('class'=>'send-btn', 'class'=>'btn btn-primary','onclick'=>'buscar_medico(this.form)')) !!} 
		</div>
	    <br />
	    <div id="datos_medico"></div>
    <?php } else { ?>
    	<!--{{ FuncionesControllers::buscar_medico(Session::get("id_usuario")) }}-->
    <?php } ?>
