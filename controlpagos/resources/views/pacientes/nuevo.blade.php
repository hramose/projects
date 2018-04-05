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

{!! Form::open(array('url' => 'guardar_paciente_nuevo', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}

@include('pacientes.forma_nuevo')

<br />
<div class="ln_solid"></div>
<div class="form-group" align="center">
{!! Form::submit('Guardar Paciente', array('class'=>'send-btn', 'class'=>'btn btn-primary')) !!}
</div>

{!! Form::close() !!}

@include ('layaout.footer_admin')