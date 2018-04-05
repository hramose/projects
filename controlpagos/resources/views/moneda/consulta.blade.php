<?php namespace App\Http\Controllers;

use App\Http\Controllers\FuncionesControllers;
use App\Http\Controllers\SessionusuarioControllers;
use App\Http\Controllers\monedaControllers;
use Session;
use DB;
use View;
use Form;
use Illuminate\Support\Facades\URL;

?>

@include('layaout.header_admin')
    <!-- page content -->
    <div class="x_content">
        <h2>Monedas <small>Activas</small></h2>
        <span class="section">Informacion de los Monedas</span>
        {{ monedaControllers::consulta() }}                                    
    </div>
    <!-- /page content -->
@include('layaout.footer_admin')

