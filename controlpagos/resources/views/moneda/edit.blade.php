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

    {!! Form::model($moneda,array('url' => 'guardar_moneda_edicion', 'method' => 'put', 'class' =>  "form-horizontal", 'files'=>true)) !!}
        <h2>Editar Moneda</h2> <hr />
		
		<span class="msj">{{ Session::get("mensaje") }}</span>

        <input type="hidden" name="id" value="<?=$moneda->id?>" />

        <div class="item form-group">
            <label class="control-label col-md-6 col-sm-6 col-xs-12">Tipo <span class="msj">(*)</span>:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="tipo" name="tipo" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Tipo" value="<?=$moneda->tipo?>">
            </div>
        </div>

        <br />
        <div class="ln_solid"></div>
        <div class="form-group" align="center">
            {!! Form::submit('Guardar', array('class'=>'send-btn', 'class'=>'btn btn-primary')) !!}
        </div>
    {!! Form::close() !!}

@include ('layaout.footer_admin')
