<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>
@include ('layaout.header_admin')

<?php
    $sql = "select * from medico where codigo_confirmacion='".$codigo_confirmacion."'";
    $data = DB::select($sql);
    if (empty($data))
        echo "Lo lamentamos. Su cuenta no pudo ser verificada";
    else {
        $sql = "update medico set confirmada=1 where codigo_confirmacion='".$codigo_confirmacion."'";
        DB::update($sql);
        echo "Felicidades. Su cuenta ha sido verificada satisfactoriamente";
    }
?>


@include ('layaout.footer_admin')