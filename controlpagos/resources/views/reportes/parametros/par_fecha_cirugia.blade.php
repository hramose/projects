<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;

$today = @getdate();
        
        $dia = $today["mday"];
        $mes = $today["mon"];
        $ano = $today["year"];
        $fecha_act = $ano."-".$mes."-".$dia;

        $fecha = $fecha_act;
        $nuevafecha = strtotime ( '-30 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );

        $fecha_act = $fecha;
        $fecha2=FuncionesControllers::fecha_normal($fecha_act);
        $fecha1=FuncionesControllers::fecha_normal($nuevafecha);
?>

<div class="col-md-3">
	<input type="text" name="fecha" required="required" class="form-control" placeholder="Fecha" value="<?php echo $fecha1; ?> - <?php echo $fecha2; ?>" />
    <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
</div>    
