<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Redirect;
use URL;
use App\Http\Controllers\FuncionesControllers;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
    <title>Contros de Pagos</title>

	<script src="{{ URL::asset('js/funciones.js') }}"></script>
    <!--CHECK BOX-->
    <link rel="stylesheet" href="{{ URL::asset('css/build.css') }}"/>

    <!-- Bootstrap core CSS -->

    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('fonts/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/animate.min.css') }}" rel="stylesheet">
	
    <!-- colorpicker -->
    <link href="{{ URL::asset('css/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet">	

    <!-- Custom styling plus plugins -->
    <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/maps/jquery-jvectormap-2.0.1.css') }}" />
    <link href="{{ URL::asset('css/icheck/flat/green.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('css/floatexamples.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <!--script src="{{ URL::asset('js/nprogress.js') }}"></script>
    <script>
        NProgress.start();
    </script-->
    
    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
		
    <!-- Custom styling plus plugins -->
    <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/icheck/flat/green.css') }}" rel="stylesheet">	

    <?php if (strpos($_SERVER['REQUEST_URI'],"nuevo_medico") !== false || strpos($_SERVER['REQUEST_URI'],"consultarmedico") !== false || strpos($_SERVER['REQUEST_URI'],"nuevo_cirugia") !== false || strpos($_SERVER['REQUEST_URI'],"consultarcirugia") !== false || strpos($_SERVER['REQUEST_URI'],"solo_cirugia") !== false) { ?>

        <!--DATE FORMAT-->

        <link rel="stylesheet" href="{{ URL::asset('js/datepicker/jquery-ui.css') }}">
        <script src="{{ URL::asset('js/datepicker/jquery-1.10.2.js') }}"></script>
        <script src="{{ URL::asset('js/datepicker/jquery-ui.js') }}"></script>

    <?php } ?>
		
    <?php if (strpos($_SERVER['REQUEST_URI'],"consulta") !== false || strpos($_SERVER['REQUEST_URI'],"nuevo_pago") !== false || strpos($_SERVER['REQUEST_URI'],"rpts") !== false || strpos($_SERVER['REQUEST_URI'],"cargarfactura") !== false || strpos($_SERVER['REQUEST_URI'],"cargarpago") !== false || strpos($_SERVER['REQUEST_URI'],"guardar_pago_nuevo_factura") !== false) { ?>

    <!--FUNCIONES DATATABLE-->

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('datatables/datatables.min.css') }}"/>
    <script type="text/javascript" src="{{ URL::asset('datatables/datatables.min.js') }}"></script> 

    <?php } ?>
	
    <!-- input mask -->
    <!--script src="{{ URL::asset('js/jquery.maskMoney.js') }}"></script-->

    <!-- SELECT MULTIPLE -->
    <link rel="stylesheet" href="{{ URL::asset('css/select2.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/select2-bootstrap.css') }}" />		

    <!-- select2 -->
    <link href="{{ URL::asset('css/select/select2.min.css') }}" rel="stylesheet">    
	
	<!--MONEY FORMAT-->
	<script src="{{ URL::asset('js/priceformat/jquery.price_format20.js') }}"></script>
	<script src="{{ URL::asset('js/priceformat/jquery.price_format20.min.js') }}"></script>

	<!--AUTOCOMPLETE FORMAT-->

<script src="{{ URL::asset('js/autocomplete/jquery.autocomplete.js') }}"></script>

<script type="text/javascript">
	var seguros={
		<?php			
			if (Session::get("id_medico")>0)
				$sql = "select * from seguros_medicos where id_medico=".Session::get("id_medico");
			else
				$sql = "select id, nombre from seguros ";
			$sql .= " order by 2";
			$data=DB::select($sql);
			$resultado="";
			foreach($data as $data)
				$resultado.=$data->id.":'".strtoupper($data->nombre)."',";
			$resultado=substr($resultado,0,strlen($resultado)-1);
			echo $resultado;
		?>
	}
	
	var clinicas={
		<?php
			$sql = "";
			if (Session::get("id_medico")>0)
				$sql .= " select * from clinica_medico where id_medico=".Session::get("id_medico");
			else
				$sql .= "select id as id_clinica, nombre from clinica ";
			$sql .= " order by 2";			
			$data=DB::select($sql);
			$resultado="";
			foreach($data as $data)
				$resultado.=$data->id_clinica.":'".strtoupper($data->nombre)."',";
			$resultado=substr($resultado,0,strlen($resultado)-1);
			echo $resultado;
		?>
	}	
</script> 

<style>
	.msj {
		color: red;
		font-weight: bold;
	}
</style>
    <?php if (strpos($_SERVER['REQUEST_URI'],"nuevo_cirugia") !== false || strpos($_SERVER['REQUEST_URI'],"cargarpago") !== false || strpos($_SERVER['REQUEST_URI'],"cargarfactura") !== false) { ?>
     <script src="{{ URL::asset('js/validCampoFranz.js') }}"></script>
       <script type="text/javascript">
            $(function(){
                //Para escribir solo letras
                $('#nombres').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');
                $('#apellidos').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');
                $('#clinica').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');
                $('#seguro').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');
                
                //Para escribir solo numeros    
                $('#edad').validCampoFranz('0123456789'); 
                $('#cedula').validCampoFranz('0123456789');
                $('#cedula').validCampoFranz('0123456789');
            });
        </script>  
    <?php } ?>   
</head>


<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="/controlpagos/public/index" class="site_title"><i class="fa fa-book"></i> <span>Control de Pagos</span></a>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                    	$id_usuario=Session::get('id_usuario');
                    	$foto=Session::get('foto');
                    ?>
                    <!-- menu prile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="<?php echo FuncionesControllers::capturar_ruta().'/users/'.$id_usuario.'/'.$foto; ?>" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>{{ Session::get("nombre") }}</h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
					<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">		
								<?php if (Session::get("id_usuario")!="") { ?>
									@include("dashboard.menu_izquierdo")
								<?php } ?>
                            </ul>
                        </div>
                    </div>									

				
					
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="CerrarSesion">
                            <a href="{{ URL::to('cerrar_session') }}"><span class="glyphicon glyphicon-off" aria-hidden="true"></span></a>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

			<?php if (Session::get("id_usuario")!="") { ?>
				@include("dashboard.menu_superior")
			<?php } ?>
			
			<!-- page content -->
			<div class="right_col" role="main">