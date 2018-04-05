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
<span class="header_tit1">H</span><span class="header_tit2">abilidades</span> <span class="header_tit1">I</span><span class="header_tit2">ntelectivas</span></div>

<div id="logo_inter">
<img src="../css/images/logo.png" width="122" height="60" alt="TalentsKey" />
</div>
</div></div>
<!-- CIERRE HEADER -->

<div id="valores_prueba"></div>

<script>nro_prueba=2; id_au=<?=$id_au?>; primera=new Array(); var num_actual=0; tabindex=1; var cantidad=0; 
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

	@include('encuestas_baterias.instrucciones',["boton"=> "1", "id_au"=>$id_au, "nro_inst"=>3, "titulo"=>$titulo,"instrucciones_antes"=>$instrucciones_antes,"instrucciones_despues"=>$instrucciones_despues, "tiempo"=>$tiempo, "funcion"=>"guardar_encuesta_hic"])
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

							<?php 
								$sql = "select * from preguntas_hl where id_pruebas=2 order by orden";
								$data=DB::select($sql);
								
								$i=1;
								$cantidad=1;
								$cantidad_2=1;
								
								foreach ($data as $data) {
									
									if ($cantidad==1)
										$display="inline";
									else
										$display="none";
									
									$pregunta=str_split($data->nombre);
									$id_preguntas=$data->id_preguntas;
									?>
									<div align="center" style="display: {{ $display }};" id="prueba{{ $cantidad }}">
									
									<?php
										echo "<table border=0 width='200%'>";
										if (strpos($data->nombre,"imagenes") !== false) {
											//IMAGENES
											$preg=explode(" ",$data->nombre);														
											$pregunta="<table border=0 width='100%'>
															<tr height='50px'>
																<td align='right'><img src='../".$preg[0]."' height='60' width='60'></td>
																<td align='center'><span style='color: blue'><h2>es a</h2></span></td>
																<td><img src='../".$preg[3]."' height='60' width='60'></td>
															</tr>
															<tr>
																<td colspan='3'><span style='color: blue; text-align: center;'><h2>como</h2></span></td>
															</tr>
															<tr height='50px'>
																<td align='right'><img src='../".$preg[5]."' height='60' width='60'></td>
																<td align='center'><span style='color: blue'><h2>es a</h2></span></td>
																<td colspan=2><span width='30px' id='respuesta_".$data->id_preguntas."'></span></td>
															</tr>
														</table>";
										} else {
											//TEXTOS
											$pregunta=$data->nombre;
											$parte1=explode(" como ",$pregunta);//Array ( [0] => perro es a ladrar [1] =>  búho es a: )
											$pregunta1=substr($parte1[0],0,strpos($parte1[0]," es a ")); 	//perro 
											$pregunta2=substr($parte1[0],strpos($parte1[0]," es a ")+6); 	// ladrar														
											$pregunta3=substr($parte1[1],0,strpos($parte1[1],"es "));
																						
											$pregunta="<table border=0 width='100%'>
															<tr height='50px' valign='top'>
																<td align='right'><h2><strong>".$pregunta1."</strong></h2></td>
																<td align='center'><span style='color: blue'><h2>es a</h2></span></td>
																<td><h2><strong>".$pregunta2."</strong></h2></td></tr>
															<tr><td colspan=3><span style='color: blue'><div align='center'><h2>como</h2></div></span></td>
															</tr>
															<tr height='50px'>
																<td align='right'><h2><strong>".$pregunta3."</strong></h2></td>
																<td align='center'><span style='color: blue'><h2>es a</h2></span></td>
																<td colspan=2><h2><span width='30px' style='color: green;' id='respuesta_".$data->id_preguntas."'></span></h2></td>
															</tr>
														</table>";
										}

										echo "<tr><td valign='top' width='50%'><strong><span style=' style='line-height: 200%''>".$pregunta."</span></strong></td>";
										$cantidad_2++;
										$sql = "select * from opciones_hl where id_pregunta=".$data->id_preguntas;
										$data_opciones=DB::select($sql);
										echo "<td valign='middle'>";
												echo "<table border=0 width='150' align='left'>
														<tr>
															<td align='left'>";										
										$k=1;
										foreach ($data_opciones as $data_opciones) {
											if (strpos($data_opciones->opcion,"imagenes") !== false)
												$opcion="<img src='../".$data_opciones->opcion."' height='60' width='60'>&nbsp;&nbsp;&nbsp;";
											else
												$opcion=($data_opciones->opcion);
											/**********************************/
											$selected="";
											/*if ($data_opciones->respuesta==1)
												//$selected="checked";
												echo "<h3>".$data_opciones->opcion."</h3>";*/
											/**********************************/
											if (strpos($data_opciones->opcion,"imagenes") === false) {			
												echo '<button style="width: 200%; height: 50%; margin: 10px;" type="button" onclick="colocar(\''.$data_opciones->opcion.'\',\''.$data->id_preguntas.'\',\''.$data_opciones->id_opciones.'\')" class="prueba1">'.$data_opciones->opcion.'</button>';
												//<input class='radio_iol' $selected type='radio' name='opc_hi_".$id_preguntas."' id='opc_hi_".$id_preguntas."' value='".$data_opciones->id_opciones."' onclick='colocar(\"".$data_opciones->opcion."\",".$data->id_preguntas.")'>
											} else {
												//echo "$opcion&nbsp;<input class='radio_iol' $selected type='radio' name='opc_hi_".$id_preguntas."' id='opc_hi_".$id_preguntas."' value='".$data_opciones->id_opciones."' onclick='colocar(\"".$data_opciones->opcion."\",".$data->id_preguntas.")'>&nbsp;&nbsp;&nbsp;&nbsp";
												echo '<button style="height: 50%; width: 200%; margin: 10px; padding: 10px;" type="button" onclick="colocar(\''.$data_opciones->opcion.'\',\''.$data->id_preguntas.'\',\''.$data_opciones->id_opciones.'\')" class="prueba1">'.$opcion.'</button>';
											}
											$k++;
										}
										echo "				</td>
														</tr>
													</table>";										
										echo "</td></tr>";
										echo "</table>";
									?>
									</div>
									<?php
									$index=$cantidad-1;
									echo "<script>preguntas[".$index."]=".$cantidad."</script>";
									$cantidad++;
									$i++;
									
								}
							?>
							<br /><br />
							<!--script>preguntas=<?php echo $cantidad_2; ?></script-->						
				@include('encuestas_baterias.botones',["funcion"=>'guardar_encuesta_hic',"final"=>-1])					
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