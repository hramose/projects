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

    <h2>Nuevo Pago</h2> <hr />
	
	<span class="msj">{{ Session::get("mensaje") }}</span>

<input type="hidden" name="id" value="<?=$id?>" />

    <!-- page content -->
        <div class="x_content">
            <span class="section">Informacion de las Clinicas</span>
            {{ PagosControllers::consulta_pagos() }}
        </div>
    <!-- /page content -->

@include ('layaout.footer_admin')