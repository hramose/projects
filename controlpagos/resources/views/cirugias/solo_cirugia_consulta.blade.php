<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;

use App\Http\Controllers\FuncionesControllers;
$fecha = Session::get('fecha');
if (strpos($fecha,"-") !== false)
    $fecha=FuncionesControllers::fecha_normal($fecha);

$sql = "select dc.*, mc.*, dc.monto as monto_total, mc.monto as monto_detallado, c.nro_historia 
            from datos_cirugia dc, medico_cirugia mc, cirugias c 
            where c.id=dc.id_cirugia and mc.id_datos_cirugia=dc.id and 
            dc.id=".$id_datos_cirugia;
$data = DB::select($sql);
foreach ($data as $data) {
    $id_especialidad=$data->id_especialidad;
    $id_rol=$data->id_rol;
    $monto_total=$data->monto_total;
    $observaciones=$data->observaciones;
    $nombre_cirugia=$data->nombre_cirugia;
    $fecha_carga=$data->fecha_carga;
    $cirujano=$data->cirujano;
    $nro_historia=$data->nro_historia;
    $rol=$data->rol;
}

?>
@include ('layaout.header_admin')
    {!! Form::open(array('url' => 'guardar_edicion_solo_cirugia', 'method' => 'post', 'class' => "form-horizontal form-label-left", 'files'=>true)) !!}
    <input type="hidden" name="id_datos_cirugia" value="<?=$id_datos_cirugia?>" />
    <input type="hidden" name="monto_total" value="0" />
    <h3>Agregar Cirugia</h3>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Especialidad:</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div id="datos_especialidad">{{ FuncionesControllers::mostrar_especialidades(Session::get("id_medico"),$id_especialidad) }}</div>
                </div>
            </div>
    
                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Rol:</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div id="datos_rol"><?php echo FuncionesControllers::opciones_check('rol', $id_rol, $id_datos_cirugia) ?></div>
                    </div>
                </div>  

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Monto del Tipo de Atencion:</label>
                <div class="col-md-6 col-sm-6 col-xs-12">                    
                    <input readonly placeholder="Monto" type="text" class="form-control col-md-10" name="monto" id="monto" value="<?=$monto_total*100?>">
                    <script type="text/javascript">$('#monto').priceFormat();</script>
                </div>
            </div> 

                <div id="observ_otro_rol" style="display: none">
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Observaciones de Otro Rol</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input disabled maxlength="100" id="otro_rol" name="otro_rol" type="text" data-validate-words="1" class="form-control" placeholder="Observaciones de Otro Rol" value="">
                        </div> 
                    </div>
                </div>                 

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha <span class="msj">(*)</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input readonly value="{{ $fecha }}" data-inputmask="\'mask\': \'99/99/9999\'" id="fecha_cirugia" name="fecha_cirugia" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                    <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                </div>    
            </div>                 

                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre Cirugia <span class="msj">(*)</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input maxlength="100" id="nombre_cirugia" name="nombre_cirugia" type="text" data-validate-words="1" required="required" class="form-control" placeholder="Nombre Cirugia" value="<?=$nombre_cirugia?>">
                    </div>
                </div>                 

                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Cirujano <span class="msj">(*)</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="cirujano" maxlength="60" name="cirujano" type="text" data-validate-words="1" required="required" class="form-control" placeholder="Cirujano" value="<?=$cirujano?>">
                    </div>
                </div>

                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nro Historia Paciente</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="nro_historia" maxlength="10" name="nro_historia" type="text" data-validate-words="1" class="form-control" placeholder="Nro Historia Paciente" value="<?=$nro_historia?>">
                    </div> 
                </div>

                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Observacion:</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea maxlength="120" id="observaciones" name="observaciones" class="form-control"><?=$observaciones?></textarea>
                    </div>
                </div>                
        <div class="ln_solid"></div>

        <div class="form-group" align="center">
            <button id="send" type="submit" class="btn btn-success">Guardar Cirugia</button>        
        </div>

        <script type="text/javascript">
            validar_rol('<?php echo $rol; ?>');
            sumar_monto(0);
        </script>
        
    {!! Form::close() !!}
@include ('layaout.footer_admin')