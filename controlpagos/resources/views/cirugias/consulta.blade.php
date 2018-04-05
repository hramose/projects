<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use Session;
use DB;
use View;
use Form;

if (strpos($fecha1,"-") !== false) {
    $fecha1=FuncionesControllers::fecha_normal($fecha1);
    $fecha2=FuncionesControllers::fecha_normal($fecha2);
}
?>

    <!-- page content -->

    <h2>Consulta de Casos </h2>

    <div class="item form-group">
        <div class="col-md-3">
            <input class="flat" type="radio" name="consulta" id="Activos" value="1" <?php if ($consulta==1) echo "checked"; ?> /> Activos
            <input class="flat" type="radio" name="consulta" id="Alta" value="2" <?php if ($consulta==2) echo "checked"; ?> /> Alta  
            <input class="flat" type="radio" name="consulta" id="Todos" value="3" <?php if ($consulta==3) echo "checked"; ?> /> Todos
        </div>
        <div class="col-md-3">
            <select name="id_clinica" class="select2_single form-control" tabindex="-1">
                <option value=0>Todas clinica...</option>
                <?php
                    $sql = "select * from clinica_medico where id_medico=".Session::get("id_medico")." order by 2";
                    $data=DB::select($sql);
                    foreach ($data as $data)
                        if ($id_clinica==$data->id_clinica)
                            echo "<option value=".$data->id_clinica." selected>".$data->nombre."</option>";
                        else
                            echo "<option value=".$data->id_clinica.">".$data->nombre."</option>";
                ?>
            </select>
        </div>  
        <div class="col-md-3">
            <select name="id_seguro" class="select2_single form-control" tabindex="-1">
                <option value=0>Todos seguro...</option>
                <?php
                    $sql = "select * from seguros_medicos where id_medico=".Session::get("id_medico")." order by 2";
                    $data=DB::select($sql);
                    foreach ($data as $data)
                        if ($id_seguro==$data->id)
                            echo "<option value=".$data->id." selected>".$data->nombre."</option>";
                        else
                            echo "<option value=".$data->id.">".$data->nombre."</option>";
                ?>
            </select>
        </div>            
        <div class="col-md-3">
            <input readonly type="text" name="fecha" required="required" class="form-control" placeholder="Fecha de Cirugia" value="<?php echo $fecha1; ?> - <?php echo $fecha2; ?>" />
            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
        </div>     
    </div>
<br /><br />
    <?php if (Session::get("id_medico")==0) { ?>
        <div class="x_content">
            <span class="section">Medicos</span>
            {{ FuncionesControllers::buscar_medicos() }}
        </div>
    <?php } ?>

    <div class="form-group" align="center">
        <input type="submit" name="send" class="btn btn-success" value="Consultar Casos" />
    </div>
    <!-- /page content -->

    <script type="text/javascript">
        $(function() {
            $('input[name="fecha"]').daterangepicker();
        });
    </script>