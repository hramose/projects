//VARIABLES
	var currentTabIndex=0;
	
	var tiempo_prueba=0;

	var prox_pregunta=1;
	var primera=new Array();

	var tocar_ejemplo=0;

	var nro_prueba=0;
	var nro_prueba_co=1;
	var preguntas=0;
	var preg_ant=0;
	var opciones=0;
	var resultado=0;	
	var nombre_ant="";
	var opciones_array=[];
	
	var pregunta_actual=0;
	var opcion_actual=0;

	var j=0;
	var mas=0;
	var menos=0;
	var array_preguntas=[];
	var indice_array=0;

	var id_pregunta_co=1;
	var correcto_mas=0;
	var correcto_menos=0;
	var id_pregunta_co=0;
	var pregunta_actual_co=1;
	var respuesta_actual_co= new Array();
	var entrada=0;
	
	var tiempo_co=0;
	var tiempo_hi=0;
	var tiempo_op=0;
	var tiempo_epa=0;
	
	var respuesta_ra=new Array();
	var indice_ra=1;
	
	var respuesta_rv=new Array();
	var respuesta_hn=new Array();
	var respuesta_iep_mas=new Array();
	var respuesta_iep_menos=new Array();
	
	var id_bateria=0;
	var proxima_pagina="";
	
	var cant_resp=0;
	
	var mouse_click=0;
	
//VARIABLES

//FUNCIONES	

function funcion_tiempo_prueba(tiempo, funcion) {
	//alert("1)tiempo="+tiempo);
	
	var minutos=tiempo.substr(0,tiempo.indexOf("."));
	//alert("minutos="+minutos);
	minutos=minutos.replace(".","");
	
	var segundos=tiempo.substr(tiempo.indexOf(".")+1);
	segundos=(segundos/6);
	
	//alert("minutos="+minutos);
	//alert("segundos="+segundos);
	
	if (segundos<1) {
		segundos=String(segundos);
		tiempo2=segundos.replace("0",minutos);
	} else {
		segundos=(segundos/10);
		//tiempo=minutos+"."+segundos;
		segundos=String(segundos);
		tiempo2=segundos.replace("0",minutos);
	}	

	//tiempo=2.4;
	
	var duration=tiempo2*60*1;
	var timer = duration, minutes, seconds;
	
	//alert("2)tiempo2="+tiempo2);
	//alert("minutos="+minutos);
	//alert("segundos="+segundos);
	//alert("timer="+timer);
	//tiempo=tiempo2;
	var milisegundos=duration*1000;
	var tiemposec=duration;
	tiempo_prueba = setInterval(function () {
		tiemposec--;
		minutes = parseInt(timer / 60, 10);
		//minutes=minutes-10;
		seconds = parseInt(timer % 60, 10);
		//seconds=(segundos*4)/10;
		
		//minutes=minutos;
		//seconds=segundos;
		
		//minutos--;
		//segundos--;
		
		//seconds--;
		//seconds=seconds+12;		
		//alert("3)minutes="+minutes);
		//alert("3)seconds="+seconds);	
		
		minutes = minutes < 10 ? "0" + minutes : minutes;
		seconds = seconds < 10 ? "0" + seconds : seconds;
		$("#time").html(minutes + ":" + seconds);

		if (--timer < 0) {
			timer = duration;
		}
		seconds--;
		if (tiemposec==-1) {
			alert("Presione Aceptar para pasar a la siguiente actividad...");
			eval(funcion+'()');
			//guardar_encuesta_co();
		}		
	}, 1000);
}

function ver_preguntas(tiempo, funcion) {
	document.getElementById("encuesta").style.display="inline";
	document.getElementById("instrucciones").style.display="none";
	//alert("1)"+tiempo);
	funcion_tiempo_prueba(tiempo,funcion);
	return false;
}

function siguiente_op() {
	if (nro_prueba==0) {
		//alert(2);
		var id=$("[tabindex='"+tabindex+"']").attr('id');
		//alert(4);
		pregunta_actual_co=id.substr(6);
		
		var valor_pregunta = parseInt($("#coord_"+pregunta_actual_co).val());
		var respuesta_pregunta = parseInt(respuesta_actual_co[pregunta_actual_co]);
		
		if (isNaN(valor_pregunta))
			valor_pregunta="";
		
		//colocar_nro(valor_pregunta);
		if (valor_pregunta==respuesta_pregunta) {
			if (pregunta_actual_co==3) {
				if (entrada==0) {
					entrada++;
					alert("Correcto, ahora presione el boton Comenzar Prueba ");
					cant_resp=respuesta_actual_co.length;
					cant_resp--;
					if (cant_resp==tabindex)
						document.getElementById("finalizar").style.display = "inline";
					return false;
				}
			} else {
				id_pregunta_co++;
				
				/*
					if (mas==0 || menos==0)
						alert("Ud no puede avanzar hasta no contestar completamente esta pregunta")
					else {		
						mas=0; 
						menos=0;
				*/
				
				document.getElementById("prueba"+tabindex).style.display = "none";
				tabindex++;
				cant_resp=respuesta_actual_co.length;
				cant_resp--;
				if (cant_resp==tabindex) {
					document.getElementById("prueba"+tabindex).style.display = "inline";
					document.getElementById("siguiente").style.display = "none";
					document.getElementById("finalizar").style.display = "inline";
				} else {
					document.getElementById("prueba"+tabindex).style.display = "inline";
					document.getElementById("anterior").style.display = "inline";
					$("[tabindex='"+tabindex+"']").focus();
				}
				$("[tabindex='"+tabindex+"']").focus();
				return false;
			}				
		} else {
			$("[tabindex='"+tabindex+"']").focus();
		}		
		return false;
	} else if(nro_prueba==7) {
		//alert("pregunta_actual="+pregunta_actual);
		if (typeof respuesta_iep_mas[pregunta_actual] === "undefined" || typeof respuesta_iep_menos[pregunta_actual] === "undefined")
			alert("Debe seleccionar ambas opciones");
		else {
			cant_resp=respuesta_actual_co.length;
			cant_resp--;	
			if (cant_resp==tabindex) {
				document.getElementById("prueba"+tabindex).style.display = "inline";
				document.getElementById("siguiente").style.display = "none";
				document.getElementById("finalizar").style.display = "inline";
			} else {
				document.getElementById("prueba"+tabindex).style.display = "none";
				tabindex++;
				document.getElementById("prueba"+tabindex).style.display = "inline";
				document.getElementById("prueba"+(tabindex-1)).style.display = "none";
				document.getElementById("anterior").style.display = "inline";
				indice_ra++;			
				$("[tabindex='"+tabindex+"']").focus();
				pregunta_actual=0;
				mas=0;
				menos=0;
			}
		}
	} else if(nro_prueba==10) {
		if (mouse_click==0)
			alert("No puede avanzar hasta no seleccionar alguna opcion");
		else {
			//mouse_click=0;
			tabindex_2=tabindex;
			tabindex_2++;
			cant_resp=respuesta_actual_co.length;
			cant_resp--;
			//alert(cant_resp+"..."+tabindex_2);
			document.getElementById("prueba"+tabindex).style.display = "none";
			tabindex++;
			document.getElementById("prueba"+tabindex).style.display = "inline";
			document.getElementById("prueba"+(tabindex-1)).style.display = "none";			
			if (cant_resp==tabindex_2) {
				document.getElementById("prueba"+tabindex).style.display = "inline";
				document.getElementById("prueba"+(tabindex-1)).style.display = "none";
				document.getElementById("siguiente").style.display = "none";
				document.getElementById("finalizar").style.display = "inline";
				indice_ra++;
			} else {
				document.getElementById("anterior").style.display = "inline";
				indice_ra++;			
				$("[tabindex='"+tabindex+"']").focus();
			}		
			return false;			
		}
	} else {
		cant_resp=preguntas.length;
		//alert(preguntas.length);
		cant_resp--;
		//alert(respuesta_actual_co.length);
		//alert("tabindex="+tabindex)
			
		var URLactual = window.location;
		//alert(URLactual);
		if (URLactual.toString().indexOf("prueba_tcgo")>-1) {
			opciones = document.getElementsByName("respuesta_evaluado_"+tabindex);
			//alert(opciones.length);
			for(var i=0; i<opciones.length; i++) {
				if (opciones[i].checked==true)
					break;
			}
			if (i==3)
				alert("No debe dejar esta respuesta en blanco")
			else {
				if (cant_resp==tabindex) {
					document.getElementById("prueba"+tabindex).style.display = "inline";
					document.getElementById("prueba"+(tabindex-1)).style.display = "none";
					document.getElementById("siguiente").style.display = "none";
					document.getElementById("finalizar").style.display = "inline";
					indice_ra++;
				} else {
					document.getElementById("prueba"+tabindex).style.display = "none";
					tabindex++;
					document.getElementById("prueba"+tabindex).style.display = "inline";
					document.getElementById("prueba"+(tabindex-1)).style.display = "none";
					document.getElementById("anterior").style.display = "inline";
					indice_ra++;			
					$("[tabindex='"+tabindex+"']").focus();
				}		
				return false;					
			}
		} else {
			tabindex_2=tabindex;			
			cant_preguntas=preguntas.length;
			tabindex_2++;
			cant_resp=respuesta_actual_co.length;
			//document.getElementById("valores_prueba").innerHTML = cant_preguntas+".."+tabindex_2;
			//alert(cant_resp+"..."+tabindex_2);
			if (cant_preguntas==tabindex_2) {
				document.getElementById("prueba"+tabindex).style.display = "none";
				tabindex++;
				document.getElementById("prueba"+tabindex).style.display = "inline";
				document.getElementById("prueba"+(tabindex-1)).style.display = "none";
				document.getElementById("siguiente").style.display = "none";
				document.getElementById("finalizar").style.display = "inline";
				indice_ra++;
			} else {
				if (cant_preguntas>tabindex_2) {
					document.getElementById("prueba"+tabindex).style.display = "none";
					tabindex++;
					document.getElementById("prueba"+tabindex).style.display = "inline";
					document.getElementById("prueba"+(tabindex-1)).style.display = "none";				
					document.getElementById("anterior").style.display = "inline";
					indice_ra++;			
					$("[tabindex='"+tabindex+"']").focus();
				}
			}		
			return false;		
		}
	}
}

function anterior_op() {
	$("#valor").html("");
	document.getElementById("prueba"+tabindex).style.display = "none";
	tabindex--;
	document.getElementById("prueba"+tabindex).style.display = "inline";
	
	if (tabindex==1)
		document.getElementById("anterior").style.display = "none";
	$("[tabindex='"+tabindex+"']").focus();
	
	cant_resp=respuesta_actual_co.length;
	document.getElementById("siguiente").style.display = "inline";
	document.getElementById("finalizar").style.display = "none";
	indice_ra--;
	return false;
}

function finalizar_op() {
	pregunta_actual_co++;
	//alert("finalizar_op="+pregunta_actual_co)
	//guardar_encuesta_co_ejemplo();
	return false;
}

//FUNCIONES

//JQuery

$(document).ready(function() {
	$(".clase_co").keydown(function(event) {
		var evt = event || window.event;
		var id = event.target.id;
		var node = (event.target) ? event.target : ((event.srcElement) ? event.srcElement : null);
		var tecla = (document.all) ? event.keyCode :event.which;
		pregunta_actual_co=id.substr(6);
		verificar_forma(1,pregunta_actual_co,respuesta_actual_co[pregunta_actual_co]);			
		if (event.keyCode==13) {
			if (nro_prueba==0) {
				var valor_pregunta = parseInt($("#coord_"+pregunta_actual_co).val());
				var respuesta_pregunta = parseInt(respuesta_actual_co[pregunta_actual_co]);
				
				if (isNaN(valor_pregunta))
					valor_pregunta="";

				colocar_nro(valor_pregunta);
				if (valor_pregunta==respuesta_pregunta) {
					if (pregunta_actual_co==3) {
						if (entrada==0) {
							entrada++;
							//alert("Correcto, ahora presione el boton Comenzar Prueba ");
							cant_resp=respuesta_actual_co.length;
							cant_resp--;
							if (cant_resp==tabindex)
								document.getElementById("finalizar").style.display = "inline";
							return false;
						}
					} else {
						id_pregunta_co++;
						siguiente_op();
						pregunta_actual_co++;
						//alert("clase_co_1="+pregunta_actual_co)
						//$("#coord_"+pregunta_actual_co).val("");
						$("[tabindex='"+tabindex+"']").focus();
						return true;
					}				
				} else {					
					if ((event.keyCode == 13) && (node.type=="text")) {
						//$("#coord_"+pregunta_actual_co).val("");
						return false;
					}
				}
			} else {
				cant_resp=respuesta_actual_co.length;				
				id_pregunta_co++;
				siguiente_op();
				if (cant_resp>tabindex) {
					pregunta_actual_co++;	
					//alert("clase_co_2="+pregunta_actual_co)											
					//$("#coord_"+pregunta_actual_co).val("");
					$("[tabindex='"+tabindex+"']").focus();
				}
				return true;
			}
		}
		
	 });
	 
	$(".prueba1").keydown(function(event) {
		var evt = event || window.event;
		var id = event.target.id;
		var node = (event.target) ? event.target : ((event.srcElement) ? event.srcElement : null);
		
		var tecla = (document.all) ? event.keyCode :event.which;
		pregunta_actual_co=id.substr(6);
		verificar_forma(1,pregunta_actual_co,respuesta_actual_co[pregunta_actual_co]);			
		if (event.keyCode==13) {
			if (nro_prueba==0) {
				var valor_pregunta = parseInt($("#coord_"+pregunta_actual_co).val());
				var respuesta_pregunta = parseInt(respuesta_actual_co[pregunta_actual_co]);
				
				if (isNaN(valor_pregunta))
					valor_pregunta="";

				colocar_nro(valor_pregunta);
				if (valor_pregunta==respuesta_pregunta) {
					if (pregunta_actual_co==3) {
						if (entrada==0) {
							entrada++;
							alert("Correcto, ahora presione el boton Comenzar Prueba ");
							cant_resp=respuesta_actual_co.length;
							cant_resp--;
							if (cant_resp==tabindex)
								document.getElementById("finalizar").style.display = "inline";
							return false;
						}
					} else {
						id_pregunta_co++;
						siguiente_op();
						pregunta_actual_co++;						
						$("#coord_"+pregunta_actual_co).val("");
						$("[tabindex='"+tabindex+"']").focus();
						return true;
					}				
				} else {					
					if ((event.keyCode == 13) && (node.type=="text")) {
						$("#coord_"+pregunta_actual_co).val("");
						return false;
					}
				}
			} else {
				cant_resp=respuesta_actual_co.length;				
				id_pregunta_co++;
				siguiente_op();
				if (cant_resp>tabindex) {
					pregunta_actual_co++;						
					$("#coord_"+pregunta_actual_co).val("");
					$("[tabindex='"+tabindex+"']").focus();
				}
				return true;
			}
		}
		
	 });	 
	 
	$(".prueba2").keydown(function(event) {
		var evt = event || window.event;
		var id = event.target.id;
		var node = (event.target) ? event.target : ((event.target) ? event.target : null);
		
		var tecla = (document.all) ? event.keyCode :event.which;
		pregunta_actual_co=id.substr(6);
		verificar_forma(1,pregunta_actual_co,respuesta_actual_co[pregunta_actual_co]);			
		if (event.keyCode==13) {
			if (nro_prueba==0) {
				var valor_pregunta = parseInt($("#coord_"+pregunta_actual_co).val());
				var respuesta_pregunta = parseInt(respuesta_actual_co[pregunta_actual_co]);
				
				if (isNaN(valor_pregunta))
					valor_pregunta="";

				//colocar_nro(valor_pregunta);
				if (valor_pregunta==respuesta_pregunta) {
					if (pregunta_actual_co==3) {
						if (entrada==0) {
							entrada++;
							alert("Correcto, ahora presione el boton Comenzar Prueba ");
							cant_resp=respuesta_actual_co.length;
							cant_resp--;
							if (cant_resp==tabindex)
								document.getElementById("finalizar").style.display = "inline";
							return false;
						}
					} else {
						id_pregunta_co++;
						siguiente_op();
						pregunta_actual_co++;						
						$("#coord_"+pregunta_actual_co).val("");
						$("[tabindex='"+tabindex+"']").focus();
						return true;
					}				
				} else {					
					if ((event.keyCode == 13) && (node.type=="text")) {
						$("#coord_"+pregunta_actual_co).val("");
						return false;
					}
				}
			} else {
				cant_resp=respuesta_actual_co.length;				
				id_pregunta_co++;
				siguiente_op();
				if (cant_resp>tabindex) {
					pregunta_actual_co++;						
					$("#coord_"+pregunta_actual_co).val("");
					$("[tabindex='"+tabindex+"']").focus();
				}
				return true;
			}
		}
	 });
	 
	 
	$(".radio_iol").keydown(function(event) {
		var evt = event || window.event;
		var id = event.target.id;
		var node = (event.target) ? event.target : ((event.target) ? event.target : null);
		var tecla = (document.all) ? event.keyCode :event.which;
		pregunta_actual_co=id.substr(6);
		verificar_forma(1,pregunta_actual_co,respuesta_actual_co[pregunta_actual_co]);
		opcion_actual=$(this).attr("value");
		pregunta_actual=$(this).attr("name").substr($(this).attr("name").indexOf("_")+1);
		if (event.keyCode==13) {
			cant_resp=preguntas.length;
			//alert(preguntas.length);
			id_pregunta_co++;
			siguiente_op();
			if (cant_resp>tabindex) {
				pregunta_actual_co++;						
				$("[tabindex='"+tabindex+"']").focus();
			}
			return true;
		}		
	 });
	
	$(".clase_textos_ejemplo_co").keydown(function(event) {
		var evt = event || window.event;
		var id = event.target.id;
		var nombre = event.target.name;
		var node = (event.target) ? event.target : ((event.target) ? event.target : null);
		var tecla = (document.all) ? event.keyCode :event.which;
		var tab=$("#"+id).prop('tabindex');
		// A - 81
		var valor_real = $("#"+id).prop('name');
		
		var letra = valor_real.substr(0,valor_real.indexOf("-"));
		valor_real = valor_real.substr(valor_real.indexOf("-")+1);
		var respuesta = valor_real;
		
		var valor_respondido = $("#"+id).prop('value');
		
		if (event.keyCode==13) {
			cant_caracteres=caracteres[vista_pregunta];
			//cant_caracteres++;
			
			cant_preguntas=preguntas.length;
			
			var cantidad=0;
			cantidad=nombre.substr(nombre.indexOf("_")+1);
			
			if (cant_caracteres>tab_aux) {
				//alert("letra="+letra+"...respuesta="+respuesta+"....valor_respondido="+valor_respondido);
				if (valor_respondido==respuesta) {
					tab++;
					tab_aux++;
					$("[tabindex='"+tab+"']").focus();
					$("#error").html("<span style='color: blue; font-weight: bold;'>Bien. El valor correcto para la letra "+letra+" es "+respuesta+", por favor intente de nuevo</span>");
				} else {
					//document.getElementById("siguiente").style.display = "none";
					$("#error").html("<span style='color: red; font-weight: bold;'>Malo. El valor correcto para la letra "+letra+" es "+respuesta+", por favor intente de nuevo</span>");
				}
			} else {
				if (cant_preguntas>vista_pregunta) {
					document.getElementById("finalizar").style.display = "none";
					document.getElementById("anterior").style.display = "inline";
					document.getElementById("siguiente").style.display = "inline";
					document.getElementById("prueba"+vista_pregunta).style.display = "none";
					vista_pregunta++;
					document.getElementById("prueba"+vista_pregunta).style.display = "inline";	
					tab++;
					$("[tabindex='"+tab+"']").focus();
					tab_aux=1;
				} else {
					document.getElementById("finalizar").style.display = "inline";
					document.getElementById("anterior").style.display = "inline";
					document.getElementById("siguiente").style.display = "none";
				}
			}
			return true;
		}
	 });	 
	 
	$(".clase_textos").keydown(function(event) {
		var evt = event || window.event;
		var id = event.target.id;
		var nombre = event.target.name;
		var node = (event.target) ? event.target : ((event.target) ? event.target : null);
		var tecla = (document.all) ? event.keyCode :event.which;
		var tab=$("#"+id).prop('tabindex');
		//tab=tab-3;
		if (event.keyCode==13) {
			cant_caracteres=caracteres[vista_pregunta];
			//cant_caracteres++;
			
			cant_preguntas=preguntas.length;
			//cant_preguntas++;			
			//alert(id);
			//alert(nombre);
			
			var cantidad=0;
			cantidad=nombre.substr(nombre.indexOf("_")+1);
			
			/*for (i=1; i<caracteres.length; i++)
				alert(caracteres[i]);*/
			
			//alert("cant_caracteres="+cant_caracteres+"....cantidad="+cantidad+"....cant_preguntas="+cant_preguntas+"...tab="+tab+"...tab_aux="+tab_aux);			
			if (cant_caracteres>tab_aux) {
				tab++;
				tab_aux++;
				$("[tabindex='"+tab+"']").focus();
			} else {
				if (cant_preguntas>vista_pregunta) {
					document.getElementById("finalizar").style.display = "none";
					document.getElementById("anterior").style.display = "inline";
					document.getElementById("siguiente").style.display = "inline";
					//alert("1)cant_preguntas="+cant_preguntas+"....vista_pregunta="+vista_pregunta);
					document.getElementById("prueba"+vista_pregunta).style.display = "none";
					vista_pregunta++;
					//alert("2)cant_preguntas="+cant_preguntas+"....vista_pregunta="+vista_pregunta);
					document.getElementById("prueba"+vista_pregunta).style.display = "inline";	
					tab++;
					$("[tabindex='"+tab+"']").focus();
					tab_aux=1;
				} else {
					document.getElementById("finalizar").style.display = "inline";
					document.getElementById("anterior").style.display = "inline";
					document.getElementById("siguiente").style.display = "none";
				}
			}
			return true;
		}
	 });

	$("#nacionalidad").change(function() {
		var valor=$( this ).val();
		if (valor=="Otro") {
			document.getElementById("pais_otro").style.display = "inline";
		} else {
			document.getElementById("pais_otro").style.display = "none";
		}
	});
})

//JQuery