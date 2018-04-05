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
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Contros de Pagos</title>
	
	<!--link href="{{ URL::asset('css/estilos.css') }}" rel="stylesheet"-->
    <script src="{{ URL::asset('js/funciones.js') }}"></script>

    <!--CHECK BOX-->

    <link rel="stylesheet" href="{{ URL::asset('css/build.css') }}"/>    

    <!-- Bootstrap core CSS -->

    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('fonts/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/icheck/flat/green.css') }}" rel="stylesheet">

    <script src="{{ URL::asset('js/jquery.min.js') }}"></script>

    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->


    <?php if (strpos($_SERVER['REQUEST_URI'],"consulta_") !== false) { ?>

    <!--FUNCIONES DATATABLE-->

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('datatables/datatables.min.css') }}"/>
    <script type="text/javascript" src="{{ URL::asset('datatables/datatables.min.js') }}"></script> 

    <?php } ?>

    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>

    <!-- input mask -->
    <script src="{{ URL::asset('js/jquery.maskMoney.js') }}"></script>    


    <!-- SELECT MULTIPLE -->

    <link rel="stylesheet" href="{{ URL::asset('css/select2.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/select2-bootstrap.css') }}" />

    <?php if (strpos($_SERVER['REQUEST_URI'],"nuevo_medico") !== false || strpos($_SERVER['REQUEST_URI'],"consultarmedico") !== false) { ?>

        <!--DATE FORMAT-->

        <link rel="stylesheet" href="{{ URL::asset('js/datepicker/jquery-ui.css') }}">
        <script src="{{ URL::asset('js/datepicker/jquery-1.10.2.js') }}"></script>
        <script src="{{ URL::asset('js/datepicker/jquery-ui.js') }}"></script>

    <?php } ?>

</head>


<body class="nav-md">
<?php $ruta=""; ?>
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{ URL::asset('index') }}" class="site_title"> <span>{{ Session::get("name") }}</span></a>
                </div>
                <div class="clearfix"></div>
                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
					<?php if (Session::get("foto")=="") { ?>
                        <img src="{{ URL::asset('users/generico.jpg') }}" alt="..." class="img-circle profile_img">
					<?php } else { 
                            $id_usuario=Session::get("id_usuario");
                            $foto=Session::get("foto");                      
                        ?>
						<img src="<?php echo URL::asset('users/'.$id_usuario.'/'.$foto.''); ?>" alt="..." class="img-circle profile_img">
					<?php } ?>
                    </div>
                    <div class="profile_info">
                        <span>Bienvenido,</span>
                        <h2>{{ Session::get("nombre") }}</h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                <?php if (Session::get("id_usuario")!="") { ?>
                    @include("dashboard.menu_izquierdo")                        
                <?php } ?>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <?php if (Session::get("id_usuario")!="") { ?>
                    @include("dashboard.menu_footer")
                <?php } ?>
                <!-- /menu footer buttons -->
            </div>
        </div>
        <!-- top navigation -->
            <!-- top navigation -->
            <?php if (Session::get("id_usuario")!="") { ?>
                @include("dashboard.menu_superior")
            <?php } ?>
            <!-- /top navigation -->
        <!-- /top navigation -->
        <!-- page content -->
        <div class="right_col" role="main">