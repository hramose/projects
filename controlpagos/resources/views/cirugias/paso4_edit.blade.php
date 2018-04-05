<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

use App\cirugias;
use App\medico_cirugia;
use App\cirugia_seguro;

$cirugias = Cirugias::where('id', '=', $id)->take(10)->get();
$id_moneda=0;
$id_medico=0;
$nombre='';
$nro_caso='';
foreach ($cirugias as $key=>$cirugias) {
    $id_moneda=$cirugias->id_moneda;
    $nombre=strtoupper($cirugias->nombre);
    $nro_caso=$cirugias->nro_caso;
    $id_medico=$cirugias->id_medico;
    $fecha_cirugia=FuncionesControllers::fecha_normal($cirugias->fecha_cirugia);
}

$medico_cirugia = Medico_cirugia::where('id_cirugia', '=', $id)->take(10)->get();
$id_especialidad=0;
$id_rol=0;
foreach ($medico_cirugia as $key=>$medico_cirugia) {
    $id_especialidad=$medico_cirugia->id_especialidad;
    $id_rol=$medico_cirugia->id_rol;
}


?>
<div id="step-4">
    <h2 class="StepTitle">Cirugia</h2>
        <div class="item form-group">    
            <label class="control-label col-xs-3">Nombre Cirugia <span class="msj">(*)</span></label>
            <div class="col-xs-3">
                <input id="nombre" name="nombre" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombre Cirugia" value="<?=$nombre?>">
            </div> 
        </div>  

        <div class="item form-group">
            <label class="control-label col-xs-3">Moneda:</span></label>
            <div class="col-xs-3">
                <select class="form-control" id="id_moneda" nombre="id_moneda" disabled>
                    <option value=0>Selecciones la Moneda...</option>
                    {{ FuncionesControllers::crear_combo_moneda('moneda', $id_moneda) }}
                </select>
            </div>
        </div>

        <div class="item form-group">
            <label class="control-label col-xs-3">Especialidad:</span></label>
            <div class="col-xs-3">
                <div id="datos_especialidad">{{ FuncionesControllers::mostrar_especialidades($id_medico,$id_especialidad) }}</div>
            </div>
        </div>

        <div class="item form-group">
            <label class="control-label col-xs-3">Rol:</span></label>
            <div class="col-xs-3">
                <div id="datos_rol">{{ FuncionesControllers::opciones_check ('rol', $id_rol) }}</div>
            </div>
        </div>        

        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de Cirugía <span class="msj">(*)</span></label>
            <div class="col-xs-3">
                <input readonly value="<?=$fecha_cirugia?>" data-inputmask="'mask': '99/99/9999'" id="fecha_cirugia_edit" name="fecha_cirugia_edit" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
            </div>    
        </div>
    
        <div class="item form-group">
            <label class="control-label col-xs-3">Nro de Caso <span class="msj">(*)</span></label>
            <div class="col-xs-3">
                <input id="nro_caso" name="nro_caso" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nro de Caso" value="<?=$nro_caso?>">
            </div> 
        </div>    
        <div class="item form-group">
            <label class="control-label col-xs-3">Imagen Sticker:</label>
            <div class="col-xs-9">
                {!! Form::file('img_sticker') !!}
            </div>
        </div>

    <div class="item form-group">
        <div class="col-xs-3">
            <a href="javascript:;" onclick="agregar_seguro({{ Session::get('id') }})">Agregar Seguro<i class="fa fa-plus-square"></i></a>
        </div>
    </div>

     <div id="datos_seguro">
        <?php
            $cirugia_seguro = Cirugia_seguro::where('id_cirugia', '=', $id)->take(10)->get();
            $id=Session::get('id');
            
            $resultado="";
            foreach ($cirugia_seguro as $key=>$cirugia_seguro) {
                if ($cirugia_seguro->id_seguro) {
                    $id++;
                    $monto=($cirugia_seguro->monto*100);
                    $resultado= '<div class="form-group" id="seguromonto_'.$id.'">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Seguro / Monto</label>
                        <div class="col-xs-3">
                            <input value="'.FuncionesControllers::buscar_seguro($cirugia_seguro->id_seguro).'" required="required" type="text" name="seguro'.$id.'" id="seguro'.$id.'" class="form-control col-md-10" style="float: left;" />
                            <div id="autocomplete-seguro'.$id.'" style="position: relative; float: left; width: 400px; margin: 10px;"></div>
                            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        <div class="col-xs-3">
                            <input value="'.$monto.'" placeholder="Monto" type="text" class="form-control col-md-10" name="monto'.$id.'" id="monto'.$id.'">
                            <span class="fa fa-money form-control-feedback right" aria-hidden="true"></span>            
                            <script type="text/javascript">$(\'#monto'.$id.'\').priceFormat();</script>            
                        </div>
                        <div class="col-xs-3">
                            <a href="javascript:;" onclick="agregar_seguro('.$id.')"><i class="fa fa-plus-square"></i></a>            
                            <a href="javascript:;" onclick="quitar_seguro('.$id.')"><i class="fa fa-minus-square"></i></a>
                        </div>
                    </div>';

                    $resultado.= '
                        <script type="text/javascript">
                            $(function () {
                                \'use strict\';
                                var segurosArray = $.map(seguros, function (value, key) {
                                    return {
                                        value: value,
                                        data: key
                                    };
                                });
                                // Initialize autocomplete with custom appendTo:
                                $(\'#seguro'.$id.'\').autocomplete({
                                    lookup: segurosArray,
                                    appendTo: \'#autocomplete-seguro'.$id.'\'
                                });
                            });
                        </script>   
                    ';
                    echo $resultado;
                }
            }
            $id++;
            Session::put("id",$id);
        ?>
     </div>
</div>
