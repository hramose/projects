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
    {!! Form::open(array('name' => 'form', 'url' => 'guardar_cirugia_nuevo', 'method' => 'post', 'class' =>  "form-horizontal form-label-left", 'files'=>true)) !!}
        <input type="hidden" name="id" value="<?=$id?>" />
        <input type="hidden" name="monto_total" value="0" />
        <input type="hidden" name="seguros" value="" />
        @include ('cirugias.paso1')
        @include ('cirugias.paso3')        

        <br /><br /><br />

        <div class="ln_solid"></div>

        <div class="form-group" align="center">
            <button id="send" type="submit" class="btn btn-success">Guardar Cirugia</button>        
        </div>
    {!! Form::close() !!}
@include ('layaout.footer_admin')