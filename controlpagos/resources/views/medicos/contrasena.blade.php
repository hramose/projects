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

{!! Form::open(array('url' => '', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}

<?php
    $sql = "select id from medico where email='$email'";
    $data=DB::select($sql);
    $id=0;
    foreach ($data as $data)
        $id=$data->id;
?>

<legend>Cambiar Contrase&ntilde;a</legend>
<br />
<br />
<div class="item form-group">
    <label class="control-label col-xs-3">Pregunta Secreta:</label>
    <div class="col-xs-9">
        <?php
        $sql = "select pregunta_secreta from medico where id=".$id;
        $data = DB::select($sql);
        foreach($data as $data)
            echo $data->pregunta_secreta;
        ?>
    </div>
</div>

<div class="item form-group">
    <label class="control-label col-xs-3">Respuesta Secreta:</label>
    <div class="col-xs-9">
        <input name="respuesta_secreta" type="text" class="form-control" placeholder="Respuesta Secreta" value="">
    </div>
</div>

<div class="item form-group">
    <div class="col-xs-offset-3 col-xs-9">
        <a href="javascript:;" onclick="validarrespuesta(<?php echo $id; ?>)">
            <button class="btn btn-default" style="margin-right: 5px;">Validar Respuesta</button>
        </a>
    </div>
</div>

<div id="textos_contrasenas"></div>

{!! Form::close() !!}

@include ('layaout.footer_admin')