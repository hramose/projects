<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

$nombre_prueba=strtolower($nombre_prueba);

$opciones_array="";

?>
            <table id="tabla_reportes" class="display" cellspacing="0" width="95%" align="center">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
						<th>Participante</th>
						<th>Cedula</th>
                        <th>Fecha</th>
                        <th>Hora</th>
						<th>Grupo</th>
						<th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>	
				<?php
					if (strpos($nombre_prueba,"epa") !== false || strpos($nombre_prueba,"alpha") !== false)
						$tabla="respuestas_epa";
					else {
						$tabla=FuncionesControllers::buscarTablaResultados($id_bateria);
					}
					
					$sql = "select distinct(c.id) as id_candidato, c.nombres, 
						c.apellidos, c.cedula, 
						r.fecha_creacion, c.id_autorizacion, a.id_grupo_candidatos
					from candidatos c, ".$tabla." r, autorizaciones a
					where a.id_tipo_prueba=$id_tipo_prueba and 
						a.id=c.id_autorizacion and
						r.id_autorizacion=a.id and
						date(r.fecha_creacion) between '".FuncionesControllers::fecha_mysql($fecha_reporte1)."' 
						and '".FuncionesControllers::fecha_mysql($fecha_reporte2)."' ";

					if ($cedula!="")
						$sql .= " and c.cedula='".$cedula."'";
					
					if ($id_grupo_candidatos>0)
						$sql.= " and id_grupo_candidatos=$id_grupo_candidatos ";

					if (Session::get("rol")!="A") {
						if (Session::get("rol")=="EA")
							$sql .= " and a.id_empresas=".Session::get("id_empresa");
						if (Session::get("rol")=="ERRHH") {
							$sql .= " and a.id_empresas=".Session::get("id_empresa");
							$sql .= " and a.id_invitador=".Session::get("id_usuario");
						}
					}
					//echo $sql; return;
					
					$data=DB::select($sql);

					$i=1;
					foreach ($data as $data) {
						$r="";
						$p="";
						$e="";
						$id_candidato=$data->id_candidato;
						$id_grupo_candidatos=$data->id_grupo_candidatos;
						$resultado="";
						
						$id_autorizacion=$data->id_autorizacion;
						
						//echo "id_grupo_candidatos=".$id_grupo_candidatos; return;
						
						if ($data->cedula=="")
							$cedula=0;
						else
							$cedula=$data->cedula;
						
						if (strpos($_SERVER["REQUEST_URI"],"consultar_encuesta") !== false)
							$ruta="";
						else
							$ruta="../";
						
						//echo "ruta=$ruta"; return;
						
						$id_au=$data->id_autorizacion;
						
						$sql = "select tabla
								from tablas_funciones
								where id_bateria=".$id_bateria;		

						$datafunciones=DB::select($sql);
						foreach($datafunciones as $datafunciones)	
							$funcion=$datafunciones->tabla;
						
						if ($nombre_prueba=="hic")
							$nombre_prueba="hi";
						if ($nombre_prueba=="alpha")
							$nombre_prueba="epa";
						
						if (strpos($_SERVER["REQUEST_URI"],"encuesta_reporte") !== false)
							$ruta="../";
						else
							$ruta="";
						
						if ($data->nombres=="")
							$nombre="";
						else
							$nombre=$data->nombres;
						
						if ($data->apellidos=="")
							$apellido="";
						else
							$apellido=$data->apellidos;

						?>
							<tr>
								<th>
									<!--a href="datos_participante/{{ $id_au }}">
										<button class="btn btn-default" type="button">Ver datos Participante</button>
									</a-->
								</th>
								<th><?php echo strtoupper($nombre." ".$apellido); ?></th>
								<th><?php echo "V-".$cedula; ?></th>
								<th><?php echo FuncionesControllers::fecha_normal(substr($data->fecha_creacion,0,10)); ?></th>
								<th><?php echo substr($data->fecha_creacion,11); ?></th>
								<th><?php echo FuncionesControllers::buscar_grupo_candidatos($id_grupo_candidatos); ?></th>
								<th>
									<div class="btn-group">
										<a target="_blank" href="{{ $ruta }}generar_resultado/{{ $id_au }}-{{ $id_tipo_prueba }}">
											<button class="btn btn-default" type="button">Imprimir Reporte</button>
										</a>
										
										<?php if (file_exists("pdf/hi/".$id_candidato.".pdf")) { ?>
										<a target="_blank"href="{{ $ruta }}pdf/hi/{{ $id_candidato }}.pdf">
											<button class="btn btn-default" type="button">Descargar PDF</button>
										</a>
										<?php } ?>
										
										
										<!--a href="<?php echo $ruta; ?>reenviar_pdf_hi/<?php echo $data->id_autorizacion; ?>">
											<button class="btn btn-default" type="button">Reenviar Reporte</button>
										</a-->
										
									</div>
								</th>
							</tr>						
						<?php
						$i++;
					}
				?>
				</tbody>	
			</table>