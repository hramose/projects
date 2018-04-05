<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\ReportesControllers;
use Session;
use DB;
use View;
use Form;

// ARREGLO DE TITULOS
$array_titulos=array(
    "rpt_med_pac"=>"Consulta de Pacientes",
    "rpt_med_pac_xcli"=>"Consulta de Pacientes x Clinicas",
    "rpt_med_pac_xAte"=>"Consulta de Pacientes x Atencion",
    "rpt_med_pac_xRol"=>"Consulta de Pacientes x Rol",
    "rpt_med_pac_xRolxCir"=>"Consulta de Pacientes x Rol x Cirujano",
    "rpt_med_pac_xDia"=>"Consulta de Pacientes x Diagnostico",
    "rpt_med_pac_xSegxAte"=>"Consulta de Pacientes x Seguro x Atencion",
    "rpt_med_pac_xAtexCir"=>"Consulta de Pacientes x Atencion x Cirujano"
);

?>

@include ('layaout.header_admin')

<!-- page content -->
<div class="x_content">
    <span class="section">Reporte: {{ $array_titulos[Session::post("ruta")] }}</span>
    {{ ReportesControllers::consulta($data, $array_campos) }}                             
</div>
<!-- /page content -->

@include ('layaout.footer_admin')

