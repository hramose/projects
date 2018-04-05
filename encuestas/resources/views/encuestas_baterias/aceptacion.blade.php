<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;
use Auth;
use Validator;
use Session;
use DB;
use Redirect;
use Form;
use App\Http\Controllers\FuncionesControllers;

use PDF;

?>

@include('layout.pruebas.header')
<form name="forma_cc" class="form-horizontal">
	<input type="hidden" name="id_au" id="id_au" value="<?=$id_au?>" />
	<input type="hidden" name="bateria" id="bateria" value="<?=$id_bateria?>" />
<div id="contenedor" style=" border: 0px solid green; height:100%">
<!-- HEADER -->
<div id="header"><div id="header_fondo">
<div id="header_tit" align="left">
<span class="header_tit1">C</span><span class="header_tit2">ondiciones </span>
</div>
</div>
<img src="../css/images/logo.png" alt="TalentsKey" />
</div>
<!-- CIERRE HEADER -->

<?php 
	$sql = "select c.*, a.id_empresas from candidatos c, autorizaciones a 
		where c.id_autorizacion=a.id and 
			c.id_autorizacion=".$id_au;
	$data=DB::select($sql);
	
	$nombres="";
	$apellidos="";
	$email="";
	$id_empresa=0;
	$cedula='';
	
	foreach ($data as $data) {
		$nombres=$data->nombres;
		$apellidos=$data->apellidos;
		$email=$data->email;
		$id_empresa=$data->id_empresas;
		$cedula=$data->cedula;
	}
?>

<!-- ACEPTACION -->
<div id="instrucciones" align="center" style="display:inline; font-size: 20pt;line-height: 150%; border: 0px solid green;">
	<?php
		
		if (strpos($id_bateria,"-") !== false)
			$id_bateria=substr($id_bateria,strpos($id_bateria,"-")+1);	
	
		$sql = "select * from texto_aceptacion 
			where id_bateria=$id_bateria and 
				id_empresa=$id_empresa and activa=1";
				//echo $sql; return;
		$data=DB::select($sql);
		$texto="";
		foreach ($data as $data) {
			$texto = $data->texto;
			$texto=str_replace("TXTNOMBRE","<strong>".strtoupper($nombres)."</strong>",$texto);
			$texto=str_replace("TXTAPELLIDO","<strong>".strtoupper($apellidos)."</strong>",$texto);
			$texto=str_replace("TXTCEDULA","<strong>".$cedula."</strong>",$texto);
			echo $texto;
		}
	?>
</div>	
<!-- ACEPTACION -->
<br /><br />
	<div align="center">
		<input type="button" name="si_acepta" value="Acepto" onclick="acepto()">
		<input type="button" name="no_acepta" value="NO Acepto">
	</div>
	</div>
</form>
@include('layout.pruebas.footer')