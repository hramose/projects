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
<span class="header_tit1">C</span><span class="header_tit2">apacidad de</span> <span class="header_tit1">C</span><span class="header_tit2">oordinac&oacute;n</span></div>

<div id="logo_inter">
<img src="../css/images/logo.png" width="122" height="60" alt="TalentsKey" />
</div>
</div></div>
<!-- CIERRE HEADER -->

<script>nro_prueba=1; id_au=<?=$id_au?>; primera=new Array(); var num_actual=0; tabindex=1; var cantidad=0; 
		preguntas=new Array(); caracteres=new Array(); vista_pregunta=1; tab_aux=1;</script>

<?php 
	$tabindex=1;
	$i=0; 
	
	$num=0;
	//$orden++;
	$sql = "select tp.id, tp.url, tp.vista_tiempo from tipos_pruebas tp, bateria_tipo_prueba btp
			where btp.id_tipo_prueba=tp.id and btp.id_bateria=".$id_bateria." 
				and btp.orden=".$orden;
	//echo $sql; return;
	$data=DB::select($sql);
	$proxima_pagina="";
	foreach ($data as $data) {
		$proxima_pagina=$data->url;
		$id_tp=$data->id;
		$tiempo=FuncionesControllers::buscarTiempo($data->id);
		//echo "tirmpo=$tiempo";
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
<div id="xxx"></div>
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

	@include('encuestas_baterias.instrucciones',["boton"=> "1", "id_au"=>$id_au, "nro_inst"=>0, "titulo"=>$titulo,"instrucciones_antes"=>$instrucciones_antes,"instrucciones_despues"=>$instrucciones_despues, "tiempo"=>$tiempo, "funcion"=>"guardar_encuesta_cc_1"])
</div>	
<!-- INSTRUCCIONES -->

<!-- CONTENIDO -->
<div id="encuesta" style="display:none;">
	<div id="cont3">
		<?php if ($vista_prueba==1) { ?>
			<div align="left" class="ver_tiempo_cc" style="font-size: 12pt; font-weight: bold;">
				Tiempo restante para la prueba <span id="time">00:00</span> minutos			
			</div>
		<?php } ?>	

		<div id="prueba1_sl_cont">
			<div align="center">
				<!--***********************CUERPO DE LA PRUEBA*************************-->
					<table border=0 width="250%" align="center">
					
						<tr>
							<td>
								<!--table align="center" border='0' cellpadding='10' cellspacing='10' width="100%">
									<tr align="center">
										<td colspan='2'>&nbsp;</td>
										<td colspan='5' style="background-color: yellow; font-size:15pt" align="center"><strong>Columnas</strong></td>
									</tr>
									<tr align="center" height="25px">
										<td colspan='2'>&nbsp;</td>
										<?php
											$sql = "select * from matriz_cc order by 1";
											$data=DB::select($sql);
											foreach ($data as $data)
												$matriz[$data->x][$data->y]=$data->letra;					
										
											foreach ($matriz as $key=>$value)
												echo "<td width='25px' style='border:1px solid; background-color: #c8c8c8; font-size:15pt'>".$key."</td>";
										?>				
									</tr>
										<?php
											$filas=array("F","i","l","a","s");
											foreach ($matriz as $key_x=>$value_x) {
												$i=0;
												foreach ($value_x as $key_y=>$value_y) {
													echo "<tr align='center' height='25px'>";
														echo "<td width='25px' style='background-color: yellow; font-size:15pt'><strong>".$filas[$i]."</strong></td>";
														echo "<td width='25px' style='border:1px solid; background-color: #c8c8c8; font-size:15pt'>".$key_y."</td>";
														foreach ($matriz as $k=>$v) {
															if ($matriz[$k][$key_y]=="A" || 
																$matriz[$k][$key_y]=="E" || 
																$matriz[$k][$key_y]=="I" || 
																$matriz[$k][$key_y]=="O" || 
																$matriz[$k][$key_y]=="U")
																echo "<td width='25px' height='25px' style='border:1px solid; background-color: #33ff33; font-size:15pt'>".$matriz[$k][$key_y]."</td>";
															else
																echo "<td style='border:1px solid; font-size:15pt' width='25px'>".$matriz[$k][$key_y]."</td>";
														}
														echo "</tr>";
														$i++;
													}							
												break;											
											}
										?>						
								</table-->
								<img src="../imagenes/tarjeta.jpg" />
							</td>
							<td align="center">
								<!--PREGUNTAS-->
								<?php 
									$sql = "select * from preguntas_hl where id_pruebas=1 and id_preguntas>2 and id_preguntas<10 order by orden";
									//echo $sql;
									$data=DB::select($sql);
									$cantidad=1;
									$index_cantidad=0;
									$tabindex=1;
									foreach ($data as $data) {
										//echo "<br>palabra=".$data->nombre;
										$index=$cantidad-1;
										$pregunta=str_split($data->nombre);
										$valor="";
										
										$id_pregunta=$data->id_preguntas;
										$respuesta=$data->respuesta;
										
										if ($cantidad==1) {
											$display="inline";
											$autofocus="autofocus";
										} else {
											$display="none";
											$autofocus="";
										}										
										?>
										<div align="center" style="display: {{ $display }};" id="prueba{{ $cantidad }}">
											<?php
											echo "<table border=0 style='padding:0px' align='center'><tr>";
											for ($i=0; $i<count($pregunta); $i++)
												echo "<td align='center'><p style='font-size:15pt'><strong>".$pregunta[$i]."</strong></p></td>";
											echo "</tr><tr>";
											$caracteres=0;										
											for ($i=0; $i<count($pregunta); $i++) {
												if ($data->id_preguntas<10)
													$id_pregunta="0".$data->id_preguntas;
												else
													$id_pregunta=$data->id_preguntas;
												if ($i<10)
													$complemento="0".$i;
												else
													$complemento=$i;
												/**********************************/
												$sql = "select * from matriz_cc where letra='".$pregunta[$i]."'";
												$data_res=DB::select($sql);
												/*foreach ($data_res as $data_res)
													$valor=$data_res->y.$data_res->x;*/
													
												//if ($i>2 || $cantidad_1>1)
													//$valor="";
												/**********************************/
												if ($tabindex==1) {
													$autofocus="autofocus";
												} else
													$autofocus="";											
												
												if ($i==0) {
													echo "<script>primera[".$num."]='".$tabindex."'; </script>";
													$num++;
													$id_campo="coord_".$id_pregunta."_".$complemento;
												} else {
													$id_campo="";
												}

												echo "<td><input autocomplete='off' autofocus='".$autofocus."' tabindex=".$tabindex." width='35px' height='35px' class='clase_textos' maxlength='2' style='width:50px; text-align: center' type='text' name='coord_".$id_pregunta."_".$complemento."' id='coord_".$id_pregunta."_".$complemento."' value='$valor'></td>";
												$tabindex++;

												$caracteres++;
											}
											
											echo "</tr></table><br />";
											?>
											<script>caracteres[<?php echo $cantidad; ?>]=<?php echo $caracteres; ?></script>
										</div>
										<?php
										echo "<script>respuesta_actual_co[".$index_cantidad."]=".$cantidad."</script>";
										$index=$cantidad-1;
										echo "<script>preguntas[".$index."]=".$cantidad."</script>";
										$index_cantidad++;
										$cantidad++;
									}
								?>
								
								@include('encuestas_baterias.botones',["funcion"=>'guardar_encuesta_cc_1',"final"=>-1])								
								<!--FIN PREGUNTAS-->								
							</td>
						</tr>
					</table>
				
				<!--***********************CUERPO DE LA PRUEBA*************************-->
			</div>
			<br /><br /><br />
			<div id="valor" style="text-align: center; font-size:14pt; width: 100%;"></div>
		</div>

	</div>
</div>

<script>
	$("[tabindex='1']").focus();
</script>
</div>
</form>
@include('layout.pruebas.footer')