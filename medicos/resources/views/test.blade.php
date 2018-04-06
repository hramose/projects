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

    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />
    <script src="{{ URL::asset('js/jquery-2.1.4.min.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('css/datepicker.css') }}" />
    <script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>

    <script>
        $( document ).ready(function() {
            $('#fecha').datepicker();
        });
    </script>    

    </head>

    <body>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="fecha" name="fecha" />
    </body>
</html>