<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Redirect;
use App\Http\Controllers\FuncionesControllers;

?>

@include('layaout.header_admin')

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="col-md-3 col-sm-12 col-xs-6">
                    <div>
                        <div class="x_title">
                            <h2>Pacientes Activos (Sin Alta)</h2>
                            <div class="clearfix"></div>
                        </div>
                        <ul class="list-unstyled top_profiles scroll-view">
                            {{ FuncionesControllers::buscar_pendientes('sin_alta') }}
                        </ul>
                    </div>
                </div>

                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div>
                        <div class="x_title">
                            <h2>Altas sin Cobrar</h2>
                            <div class="clearfix"></div>
                        </div>
                        <ul class="list-unstyled top_profiles scroll-view">
                        	{{ FuncionesControllers::buscar_pendientes('alta') }}
                        </ul>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="demo-container" style="height:280px">
                        <div id="placeholder33x" class="demo-placeholder">
	                        <div class="x_title">
	                            <h2>Records Clinicas</h2>
	                            <div class="clearfix"></div>
	                        </div>                        	
							<div id="graph_bar" style="width:100%; height:200px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="row top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-caret-square-o-right"></i>
                </div>
                <div class="count">{{ FuncionesControllers::contador(1) }}</div>
                <h3>Atenciones Realizadas</h3>
                <p>&nbsp;</p>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-comments-o"></i>
                </div>
                <div class="count">{{ FuncionesControllers::contador(2) }}</div>

                <h3>Atenciones Cobradas</h3>
                <p>&nbsp;</p>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-sort-amount-desc"></i>
                </div>
                <div class="count">{{ FuncionesControllers::contador(3) }}</div>

                <h3>Cirugias No Cobradas</h3>
                <p>&nbsp;</p>
            </div>
        </div>
        <!--div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-check-square-o"></i>
                </div>
                <div class="count">179</div>

                <h3>New Sign ups</h3>
                <p>&nbsp;</p>
            </div>
        </div-->
    </div>
</div>

    <!-- moris js -->
    <script src="js/moris/raphael-min.js"></script>
    <script src="js/moris/morris.js"></script>
    <script>
        $(function () {
            var day_data = [
            <?php
            	$sql = "select count(c.id) as cantidad, cm.nombre 
            			from clinica_medico cm, cirugias c 
            			where c.id_medico=".Session::get("id_medico")." and 
            				c.id_medico=cm.id_medico group by cm.nombre";
            	$data=DB::select($sql);
            	$resultado="";
            	foreach ($data as $data) {
            		$resultado.='
		                {
		                    "Clinica": "'.$data->nombre.'",
		                    "Atenciones": '.$data->cantidad.'
		                },
            		';
	            }
	            echo substr($resultado,0,strlen($resultado)-1);
            ?>

    ];
            Morris.Bar({
                element: 'graph_bar',
                data: day_data,
                hideHover: 'always',
                xkey: 'Clinica',
                barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
                ykeys: ['Atenciones', 'sorned'],
                labels: ['Atenciones', 'SORN'],
                xLabelAngle: 30
            });
        });
    </script>

@include('layaout.footer_admin')