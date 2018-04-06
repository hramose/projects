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
	
	<link href="{{ URL::asset('css/estilos.css') }}" rel="stylesheet">
    <script src="{{ URL::asset('js/funciones.js') }}"></script>

	
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

    <!--FUNCIONES DATATABLE-->
    <link rel="stylesheet" href="{{ URL::asset('datatables/DataTables-1.10.9/css/jquery.dataTables.min.css') }}" />
    <style type="text/css" class="init">

    </style>
    <script type="text/javascript" src="{{ URL::asset('datatables/jQuery-2.1.4/jquery-2.1.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('datatables/DataTables-1.10.9/js/jquery.dataTables.min.js') }}"></script>

    <script type="text/javascript" class="init">
        $(document).ready(function() {
            $('#example').DataTable( {
                columnDefs: [ {
                    targets: [ 0 ],
                    orderData: [ 0, 1 ]
                }, {
                    targets: [ 1 ],
                    orderData: [ 1, 0 ]
                }, {
                    targets: [ 4 ],
                    orderData: [ 4, 0 ]
                } ]
            } );		
        } );
    </script>

    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>

    <!-- SELECT MULTIPLE -->

    <link rel="stylesheet" href="{{ URL::asset('css/select2.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/select2-bootstrap.css') }}" />                                           

<script type="text/javascript">
    //Select2
    $.getScript("{{ URL::asset('js/select2.min.js') }}",function(){
               
      /* dropdown and filter select */
      var select = $('#select2').select2();
      
      /* Select2 plugin as tagpicker */
      $("#especialidad").select2({
        closeOnSelect:false
      });

    }); //script         
          

    $(document).ready(function() {});    
</script>

<!-- DATE PICKER -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#fecha_nacimiento').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minDate: "01/01/1920",
            maxDate: moment().subtract(220, 'month'),
            locale: {format: 'DD/MM/YYYY'},
            calender_style: "picker_4"
        }, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>

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
                        <h2>{{ Session::get("name") }}</h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                @include("dashboard.menu_izquierdo")                        

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					
								{{ strtoupper(Session::get("name")) }}
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                <li><a href="<?php echo URL::asset('miperfil/'.$id_usuario.''); ?>">  Perfil</a>
                                </li>
                                <li><a href="{{ URL::asset('logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->
        <!-- page content -->
        <div class="right_col" role="main">