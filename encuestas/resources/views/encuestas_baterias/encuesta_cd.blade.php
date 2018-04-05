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

<form name="forma_cc" class="form-horizontal" onsubmit= "return guardar_encuesta_co()">
	<input type="hidden" name="id_au" id="id_au" value="<?=$id_au?>" />
	<input type="hidden" name="bateria" id="bateria" value="<?=$id_bateria?>" />
	<input type="hidden" name="orden" id="orden" value="<?=$orden?>" />
<div id="contenedor">
<!-- HEADER -->
<div id="header"><div id="header_fondo">
<div id="header_tit" align="left">
<span class="header_tit1">C</span><span class="header_tit2">ompetencias</span> <span class="header_tit1">D</span><span class="header_tit2">iferenciadoras</span></div>

<div id="logo_inter">
<img src="../css/images/logo.png" width="122" height="60" alt="TalentsKey" />
</div>
</div></div>
<!-- CIERRE HEADER -->

<script>nro_prueba=1; id_au=<?=$id_au?>; primera=new Array(); var num_actual=0; tabindex=1; var cantidad=0;
		preguntas=new Array();</script>
<div id="valores_prueba"></div>
<?php 
	$tabindex=1;
	$i=0; 
	
	$sql = "select tp.id, tp.url, tp.vista_tiempo from tipos_pruebas tp, bateria_tipo_prueba btp
			where btp.id_tipo_prueba=tp.id and btp.id_bateria=".$id_bateria." 
				and btp.orden=".$orden;
	//echo $sql; return;
	$data=DB::select($sql);
	foreach ($data as $data) {
		$proxima_pagina=$data->url;
		$id_tp=$data->id;
		$tiempo=FuncionesControllers::buscarTiempo($data->id);
		$vista_prueba=substr($tiempo,strpos($tiempo,"/")+1);
		$tiempo=substr($tiempo,0,strpos($tiempo,"/"));		
	}
	
	$sql ="select * from autorizaciones where id=$id_au";
	$data=DB::select($sql);
	foreach ($data as $data) {
		$id_empresa=$data->id_empresas;
	}
	
	$id_bateria=substr($id_bateria,strpos($id_bateria,"-")+1);
?>

<script>
	proxima_pagina='<?php echo $proxima_pagina; ?>';
	var id_au_ejemplo=<?=$id_au?>;
</script>

<?php
	$opciones=array(1=>'Completamente',
					2=>'Moderadamente',
					3=>'Ligeramente',
					
					4=>'Ligeramente',
					5=>'Moderadamente',
					6=>'Completamente');
?>

<!-- INSTRUCCIONES -->
<div id="instrucciones" align="center" style="display:inline;">
	<?php
		$sql = "select i.texto, tp.nombre, i.posicion
				from instrucciones i, tipos_pruebas tp 
				where tp.id=$id_tp and i.id_prueba=tp.id and i.id_empresa=$id_empresa";
		//echo $sql; return;
		$data_i = DB::select($sql);
		
		$instrucciones_antes="";
		$instrucciones_despues="";
		
		if (empty($data_i)) {
			$instrucciones_antes="";
			$instrucciones_despues="";
		} else
			foreach ($data_i as $data_i) {
				if ($data_i->posicion==0)
					$instrucciones_antes=$data_i->texto;
				else
					$instrucciones_despues=$data_i->texto;
				$titulo=$data_i->nombre;
			}
	?>

	@include('encuestas_baterias.instrucciones',["boton"=> "1", "id_au"=>$id_au, "nro_inst"=>0, "titulo"=>$titulo,"instrucciones_antes"=>$instrucciones_antes,"instrucciones_despues"=>$instrucciones_despues, "tiempo"=>$tiempo, "funcion"=>"guardar_encuesta_cd"])
</div>	
<!-- INSTRUCCIONES -->

<!-- CONTENIDO -->
<div id="encuesta" style="display:none;">
	<div id="cont3">
		<?php if ($vista_prueba==1) { ?>
			<div align="left" class="ver_tiempo_cc" style="font-size: 12pt; font-weight: bold;">
				Tiempo restante para la prueba <span id="time">00:00</span> minutos			
			</div>
			<br /><br />
		<?php } ?>	

		<div id="prueba1_sl_cont">
			<br /><br /><br />
			<div align="center">
				<!--***********************CUERPO DE LA PRUEBA*************************-->
				
				<?php
					$sql = "select * from preguntas_hl where id_pruebas=5 order by orden";
					//echo $sql;
					$data=DB::select($sql);
					$cantidad=1;
					$i=1;
					
					foreach ($data as $data) {
						$pregunta=$data->nombre;
						$id_pregunta=$data->id_preguntas;
						
						if ($cantidad==1) {
							$display="inline";
							$autofocus="autofocus";
						} else {
							$display="none";
							$autofocus="";
						}
						
						?>
							<div id="prueba{{ $tabindex }}" style="display: {{ $display }};">	
								<?php
									echo "<table border='0' width='200%' align='center' cellspacing='5'  cellpadding='5'>";
									echo "<tr><td colspan='2'><h3><strong>".$pregunta."</strong></h3><br /></td></tr>";
									$m=1;
									$color=1;
									$k=1;
									
									/**********************************/
									$respuesta=$data->respuesta;
									/**********************************/
									$paso=0;
									$selected="";
									foreach ($opciones as $key=>$value) {
										/*if ($key==$respuesta)
											$selected="checked";
										else*/
											$selected="";
										
										echo "<tr>
												<td align='right'width='80%' >";
												
										if ($key<4)
											$titulo="en Desacuerdo: ";
										else
											$titulo="de Acuerdo: ";
										
										if ($key==1 || $key==4)
											echo "<strong>".$titulo."</strong></td>";												
												
										echo "<td align='right'>";
												//echo '<button style="width: 200%; height: 50%; margin: 10px;" type="button" name="op_'.$id_pregunta.'" id="op_'.$id_pregunta.'" class="radio_iol">NO</button>';
												//echo "<label style='border-radius: 40px 40px 40px 40px; border: 1px solid #c8c8c8; width: 300%; height: 200px; padding: 10px; margin: 10px;'>$value<input class='radio_iol' $selected type='radio' name='op_".$id_pregunta."' id='op_".$id_pregunta."' value='".$key."'><label></td>";
												echo "<label>$value<input class='radio_iol' $selected type='radio' name='op_".$id_pregunta."' id='op_".$id_pregunta."' value='".$key."'><label></td>";
										echo "
												</td>
											</tr>";														
										if ($paso==7) {
											$paso=0;
										} elseif ($paso==2) {
											echo "<tr>
													<td width='80%' collspan=2>&nbsp;</td>
												</tr>";
										}
										$paso++;
									}												
									$m++;
									$k++;
									
									echo "</table>";
								?>
							</div>
						<?php
						$index=$cantidad-1;
						echo "<script>preguntas[".$index."]=".$cantidad."</script>";						
						
						$cantidad++;
						
						$tabindex++;
						$i++;
					}
				?>
				
				<!--***********************CUERPO DE LA PRUEBA*************************-->
			</div>
			<br /><br /><br />
			<div id="valor" style="text-align: center; font-size:14pt; width: 100%;"></div>
		</div>
		
		

	</div>
	@include('encuestas_baterias.botones',["funcion"=>'guardar_encuesta_cd',"final"=>-1])
</div>

<script>
	$("[tabindex='1']").focus();
</script>
</div>
</form>
@include('layout.pruebas.footer')