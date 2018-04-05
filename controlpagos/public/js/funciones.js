/**
 * parallax.js
 * @Author original @msurguy (tw) -> http://bootsnipp.com/snippets/featured/parallax-login-form
 * @Tested on FF && CH
 * @Reworked by @kaptenn_com (tw)
 * @package PARALLAX LOGIN.
 */

/*$(document).ready(function() {
    $(document).mousemove(function(event) {
        TweenLite.to($("body"),
        .5, {
            css: {
                backgroundPosition: "" + parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / '12') + "px, " + parseInt(event.pageX / '15') + "px " + parseInt(event.pageY / '15') + "px, " + parseInt(event.pageX / '30') + "px " + parseInt(event.pageY / '30') + "px",
            	"background-position": parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / 12) + "px, " + parseInt(event.pageX / 15) + "px " + parseInt(event.pageY / 15) + "px, " + parseInt(event.pageX / 30) + "px " + parseInt(event.pageY / 30) + "px"
            }
        })
    })
})*/

function total_pagar_factura(monto,id_cirugia,id_paciente, id_datos_cirugia) {
	var f = eval("document.forms[0]");
	var chk=document.getElementById("chk_"+id_cirugia+"_"+id_paciente+"_"+id_datos_cirugia);
	var monto_tipo_atencion=monto;
		
	if (chk.checked == true)
		f.total.value=parseFloat(f.total.value)+parseFloat(monto_tipo_atencion);
	else
		f.total.value=parseFloat(f.total.value)-parseFloat(monto_tipo_atencion);
	document.getElementById("total_pagar").innerHTML="Total a pagar: Bs. "+CommaFormatted(parseFloat(f.total.value).toFixed(2));
}

function verificar_pago(f,tipo) {
	var longitud=f.length;
	var factura;
	
	f.montos.value="";

	var entra=0;
	for (i=0;i<f.length;i++) {		
		if (f.elements[i].name.indexOf("chk_") > -1 && document.getElementById(f.elements[i].name).checked==true) {
			entra=1;
		}
	}
	if (entra==0)
		alert("Recuerde que debe seleccionar al menos 1 caso, ademas de colocar su nro de factura y fecha");
	else {
		if (tipo=="f") {
			for (i=0;i<f.length;i++) {
				if (f.elements[i].name.indexOf("chk_") > -1 && document.getElementById(f.elements[i].name).checked==true) {
					factura=f.elements[i].name.substr(f.elements[i].name.indexOf("_")+1);
					factura=factura.substr(0,factura.indexOf("_"));
					factura=eval("document.forms[0].nro_factura_"+factura);
					if (factura.value) {
						alert("Debe ingresar el Nro de Factura, Nro de Control y Fecha de Factura");
						return;
					}
				}
			}
			//else {
				for (i=0; i<longitud; i++) {
					if (f.elements[i].name.indexOf("monto_")>-1 && f.elements[i].disabled==true)
						f.montos.value+=f.elements[i].name+"="+f.elements[i].value+",";
				}
				//alert(f.montos.value);
				f.submit();
			//}
		} else {
			for (i=0; i<longitud; i++) {
				if (f.elements[i].name.indexOf("monto_")>-1 && f.elements[i].disabled==true)
					f.montos.value+=f.elements[i].name+"="+f.elements[i].value+",";
			}
			//alert(f.montos.value);
			f.submit();		
		}
	}
}

function verificar_usuario(f) {
	//alert(f.username.value);
	//alert(f.password.value);
	if (f.username.value=="" || f.password.value=="")
		alert("Su usuario y password son requeridos")
	else 
		f.submit();
}

function validar_especialidad() {
	var f=eval("document.forms[0]");
	alert(f.especialidad.value);
	/*for (i=0; i<f.especialidad.length; i++) {
		if(f.especialidad.options[i].selected==true)
			f.id_especialidad.value += f.especialidad.options[i].value+",";
	}
	f.submit();*/
}

function validar_seguro() {
	var f=eval("document.forms[0]")
	for (i=0; i<f.seguro.length; i++) {
		if(f.seguro.options[i].selected==true)
			f.id_seguro.value += f.seguro.options[i].value+",";
	}
	f.submit();
}

function guardar_paciente(f) {
	var nombres=f.nombres.value;
	var apellidos=f.apellidos.value;
	var cedula=f.cedula.value;
	var edad=f.edad.value;
		
	var inputAutorizado = document.getElementById("datos_paciente");
	
	inputAutorizado.innerHTML="";
	
	var parametros = {
		"nombres" : nombres,
		"apellidos" : apellidos,
		"cedula" : cedula,
		"edad" : edad,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
		data:  parametros,
		url:   'index_guardar_paciente',
		type:  'post',
		beforeSend: function () {
			$("#datos_paciente").html("....Procesando, espere por favor");
		},
		success:  function (data) {
			$("#datos_paciente").html(data.resultado);
			buscar_paciente(document.forms[0]);
		}
	});
}

function activarmedico(id) {
	var inputId=id;
		
	var inputAutorizado = document.getElementById("autorizado_"+id);
	
	inputAutorizado.innerHTML="";
	
	var parametros = {
		"id" : id,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
		data:  parametros,
		url:   'index_proceso_autorizar',
		type:  'post',
		beforeSend: function () {
			$("#autorizado_"+id).html("....Procesando, espere por favor");
		},
		success:  function (data) {
			$("#autorizado_"+id).html(data.resultado);
		}
	});			
}

function setearclavemedico(id) {
	var inputId=id;
	
	var parametros = {
		"id" : id,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
		data:  parametros,
		url:   'index_seteo_contrasena',
		type:  'post',
		beforeSend: function () {
			//$("#autorizado_"+id).html("....Procesando, espere por favor");
		},
		success:  function (data) {
			//$("#autorizado_"+id).html(data.resultado);
			alert("Su nueva contraseña ha sido enviada a su correo electronico. "+data.resultado);
		}
	});			
}

function validarrespuesta(id) {
	alert(id);
	var f=eval("document.forms[0]")
	var respuesta=f.respuesta_secreta.value;
	
	var parametros = {
		"id" : id,
		"respuesta" : respuesta,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
		data:  parametros,
		url:   'index_proceso_respsec',
		type:  'post',
		beforeSend: function () {
			$("#textos_contrasenas").html("....Procesando, espere por favor");
		},
		success: function (data) {
			//$("#textos_contrasenas").html("su contraseña ahora es "+data.resultado);
			alert("Su nueva contraseña ha sido enviada a su correo electronico. "+data.resultado);
		}
	});
}

function buscar_datos_clinica(id_clinica) {
	var ruta = window.location.href;
	var route="";
	if (ruta.indexOf("consultarcirugia") > -1)
		route="../";
	
	var parametros = {
		"id_clinica" : id_clinica,
		"_token": $('input[name=_token]').val()
	};

	$.ajax({
		data:  parametros,
		url:   route+'index_buscar_clinica',
		type:  'post',
		beforeSend: function () {
			$("#datos_clinica").html("....Procesando, espere por favor");
		},
		success:  function (data) {
			$("#datos_clinica").html(data.resultado);
		}
	});			
}

function buscar_paciente (valor) {
	var ruta = window.location.href;
	var route="";

	if (ruta.indexOf("consultarcirugia") > -1)
		route="../";	

	if (cedula=="")
		alert("Debe indicar la Cedula o Nro de historia del paciente");
	else {
		var parametros = {
			"cedula" : valor,
			"_token": $('input[name=_token]').val()
		};
		$.ajax({
			data:  parametros,
			url:   route+'index_buscar_paciente_medico',
			type:  'post',
			beforeSend: function () {
				$("#datos_paciente").html("....Procesando, espere por favor");
			},
			success:  function (data) {
				if (data.resultado=="no sale") {
					alert("Este paciente no puede cargar un nuevo tipo de atencio hasta no ser dado de alta");
					location.href="consulta_cirugia_3?id_medico=1&fecha1=0&fecha2=0&consulta=1&indice=-1&cedula="+valor;
					//id_medico=2&fecha1=2016-04-10&fecha2=2016-5-10&consulta=1&indice=1
				}
			}
		});
	}
}

function buscar_medico (f) {
	var cedula=f.cedula_medico.value;
	
	if (cedula=="")
		alert("Debe indicar la Cedula del Medico");
	else {
		buscar_especialidad(cedula);
		var parametros = {
			"cedula" : cedula,
			"_token": $('input[name=_token]').val()
		};
		$.ajax({
			data:  parametros,
			url:   'index_buscar_medico',
			type:  'post',
			beforeSend: function () {
				$("#datos_medico").html("....Procesando, espere por favor");
			},
			success:  function (data) {				
				$("#datos_medico").html(data.resultado);
			}
		});
	}
}

function buscar_especialidad(cedula) {
	var parametros = {
		"cedula" : cedula,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
		data:  parametros,
		url:   'index_buscar_especialidad',
		type:  'post',
		beforeSend: function () {
			$("#datos_especialidad").html("....Procesando, espere por favor");
		},
		success:  function (data) {
			$("#datos_especialidad").html(data.resultado);
		}
	});	
}

function validar_usuario_olvido() {
	var f = eval("document.forms[0]")
	var user=f.username.value;
	if (user=="")
		alert("Debe indicar el usuario")
	else {
		f.action="olvido_contrasena/"+user;
		f.submit();
	}
}

function agregar_seguro(id) {
	var ruta = window.location.href;
	var route="";
	if (ruta.indexOf("consultarcirugia") > -1)
		route="../";

	id++;	
	var parametros = {
		"id":id,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
		data:  parametros,
		url:   route+'index_agregar_seguro',
		type:  'post',
		beforeSend: function () {
			//$("#datos_seguro").append("....Procesando, espere por favor");
		},
		success:  function (data) {
			$("#datos_seguro").append(data.resultado);
		}
	});	
}

function guardar_detalle(id_cirugia) {
	var f=eval("document.forms[0]");
	var fecha_carga=f.fecha_carga_edit.value;
	var fecha_alta=f.fecha_alta_edit.value;
	var observaciones=f.observaciones.value;
	var referencias=f.referencias.value;
	var habitacion=f.habitacion.value;
	
	var parametros = {
		"id_cirugia":id_cirugia,
		"fecha_carga":fecha_carga,
		"fecha_alta":fecha_alta,
		"observaciones":observaciones,
		"referencias":referencias,
		"habitacion":habitacion,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
		data:  parametros,
		url:   '../index_guardar_detalle',
		type:  'post',
		beforeSend: function () {
			$("#datos_tabla").html("....Procesando, espere por favor");
		},
		success:  function (data) {
			$("#datos_tabla").html(data.resultado);
		}
	});		
}

function eliminar_dato_cirugia(id_datos_cirugia,id_cirugia) {
	if (confirm("Está seguro de eliminar este detalle?")) {
		var parametros = {
			"id_cirugia":id_cirugia,
			"id_datos_cirugia":id_datos_cirugia,
			"_token": $('input[name=_token]').val()
		};
		$.ajax({
			data:  parametros,
			url:   '../index_eliminar_detalle',
			type:  'post',
			beforeSend: function () {
				$("#datos_tabla").html("....Procesando, espere por favor");
			},
			success:  function (data) {
				$("#datos_tabla").html(data.resultado);
			}
		});			
	}
}

function quitar_seguro (id) {
	$("#seguromonto_"+id).remove();
}

function guardar_cirugia() {
	var f=eval("document.forms[0]");
	var entra=0;
	for (i=0; i<f.length; i++) {
		if (f.elements[i].name.indexOf("seguro") > -1)
			entra=1;
	}
	if (entra==0)
		alert("Debe agregar al menos una forma de pago");
	else
		f.submit();
}

function quitar_chk(valor, chk) {
	var f = eval("document.forms[0]");
	valor=valor.replace(".", "");
	valor=valor.replace(",", ".");	
	//alert("valor="+valor);
	//alert("total 1="+f.total.value);
	f.total.value=parseFloat(f.total.value)-parseFloat(valor);
	//alert("total 2="+f.total.value);
	document.getElementById("total_pagar").innerHTML="Total a pagar: Bs. "+CommaFormatted(parseFloat(f.total.value).toFixed(2));
	chk.checked=false;
}

function total_pagar(monto,id_cirugia,id_paciente, id_datos_cirugia) {
	var f = eval("document.forms[0]");
	var chk=document.getElementById("chk_"+id_cirugia+"_"+id_paciente+"_"+id_datos_cirugia);
	var monto_tipo_atencion=eval("document.forms[0].monto_"+id_cirugia);

	monto_tipo_atencion.value=monto_tipo_atencion.value.replace(".", "");
	monto_tipo_atencion.value=monto_tipo_atencion.value.replace(",", ".");

	//if (chk.checked==true)
		//monto_tipo_atencion.disabled=true;
	//else {
		//monto_tipo_atencion.disabled=false;
		//monto_tipo_atencion.value=monto_tipo_atencion.value/100;
	//}
	
	if (IsNumeric(monto_tipo_atencion.value)) {
		if (monto<monto_tipo_atencion.value) {
			alert("Este monto no debe exceder de "+monto);
			chk.checked=false;
			//monto_tipo_atencion.disabled=false;
		}
		else {
			if (chk.checked == true)
				f.total.value=parseFloat(f.total.value)+parseFloat(monto_tipo_atencion.value);
			else
				f.total.value=parseFloat(f.total.value)-parseFloat(monto_tipo_atencion.value);
			document.getElementById("total_pagar").innerHTML="Total a pagar: Bs. "+CommaFormatted(parseFloat(f.total.value).toFixed(2));
		}
	} else
		alert("Este monto no es valido")
}

function IsNumeric(input)
{
   return (input - 0) == input && input.length > 0;
}

function CommaFormatted(amount) {
	var delimiter = ","; // replace comma if desired
	var a = amount.split('.',2)
	var d = a[1];
	var i = parseInt(a[0]);
	if(isNaN(i)) { return ''; }
	var minus = '';
	if(i < 0) { minus = '-'; }
	i = Math.abs(i);
	var n = new String(i);
	var a = [];
	while(n.length > 3) {
		var nn = n.substr(n.length-3);
		a.unshift(nn);
		n = n.substr(0,n.length-3);
	}
	if(n.length > 0) { a.unshift(n); }
	n = a.join(delimiter);
	if(d.length < 1) { amount = n; }
	else { amount = n + '.' + d; }
	amount = minus + amount;
	return amount;
}

function mostrar_tipo_atencion(valor) {
	var parametros = {
		"valor":valor,
		"_token": $('input[name=_token]').val()
	};
	$.ajax({
		data:  parametros,
		url:   'index_generar_atencion',
		type:  'post',
		beforeSend: function () {
			$("#ver_tipo_atencion").html("....Procesando, espere por favor");
		},
		success:  function (data) {
			$("#ver_tipo_atencion").html(data.resultado);
		}
	});	
}

function validar_rol (rol) {
	var f=eval("document.forms[0]");
	for (i=0;i<f.length;i++) {
		if (f.elements[i].name.indexOf("rol_")>-1) {
			if (f.elements[i].value=="OTRO" && f.elements[i].checked==true) {
				document.getElementById("otro_rol").disabled=false;
				document.getElementById("observ_otro_rol").style["display"] = "inline";
				f.otro_rol.value=rol.substr(rol.indexOf("(")+1).toUpperCase();
				f.otro_rol.value=f.otro_rol.value.replace(")","");
			}
		}
	}
}

function validar_monto(id_campo, nombre) {
	var check=eval("document.forms[0].rol_"+id_campo);
	var f=eval("document.forms[0]");

	if (check.value=="CIRUJANO PRINCIPAL" && check.checked==true) {
		document.forms[0].cirujano.value=nombre;
		document.getElementById("cirujano").disabled=true;
	} else if (check.value=="CIRUJANO PRINCIPAL" && check.checked==false) {
		document.forms[0].cirujano.value="";
		document.getElementById("cirujano").disabled=false;
	}
	
	if (check.value=="OTRO" && check.checked==true) {
		document.getElementById("otro_rol").disabled=false;
		document.getElementById("observ_otro_rol").style["display"] = "inline";
	} else if  (check.value=="OTRO" && check.checked==false) {
		document.getElementById("observ_otro_rol").style["display"] = "none";
		document.getElementById("otro_rol").disabled=true;
		document.forms[0].otro_rol.value="";
	}

	if (check.checked==true) {
		document.getElementById("monto_"+id_campo).disabled=false;
		check.checked=true;
	} else {
		document.getElementById("monto_"+id_campo).disabled=true;

		f_monto=eval("f.monto_"+id_campo);
		f_monto.value=""+parseFloat(0).toFixed(2);
		check.checked=false;
		sumar_monto(0);
	}
}

function sumar_monto(valor) {
	var f=eval("document.forms[0]");
	var monto=0;
	for (i=0; i<f.length; i++) {
		if (f.elements[i].name.indexOf("monto_")>-1 && f.elements[i].name!="monto_total") {
			monto_actual=String(f.elements[i].value);
			monto_actual=monto_actual.replace(".", "");
			monto_actual=monto_actual.replace(".", "");
			monto_actual=monto_actual.replace(",", ".");
			monto+=parseFloat(monto_actual);
		}
	}
	f.monto_total.value=monto;
	f.monto.value=""+parseFloat(monto).toFixed(2);
}

function ver_consulta_3(id_medico,fecha1,fecha2,consulta) {	
	var f=eval("document.forms[0]");
	//alert(f.id_clinica.value);
	//alert(f.id_seguro.value);
	if (f.indice.value==-1)
		alert("Debe seleccionar un paciente a consultar")
	else
		location.href="consulta_cirugia_3?id_medico="+id_medico+"&fecha1="+fecha1+"&fecha2="+fecha2+"&consulta="+consulta+"&indice="+f.indice.value+"&id_clinica="+f.id_clinica.value+"&id_seguro="+f.id_seguro.value;
}

function ver_consulta_4(id_cirugia) {
	location.href="solo_cirugia?id_cirugia="+id_cirugia;
}

function ver_consulta_5(id_cirugia) {
	if (confirm("Este paciente sera dado de alta, ¿esta seguro?"))
		location.href="alta_cirugia?id_cirugia="+id_cirugia+"&fecha="+document.forma2.fecha_alta.value;	
}

function validar_pagos(f) {
	var entra=0;
	for (i=0; i<f.length; i++) {
		if (f.elements[i].name.indexOf("chk_")>-1) {
			if (f.elements[i].checked==true) {
				entra=1;
				i=f.length;
			}
		}
	}
	if (entra==1)
		f.submit();
	else
		alert("Recuerde que debe seleccionar al menos 1 pago")
}

	function numeros(evento) {
		patron_numeros=/[0-9]/;
		if(document.all)
			tecla_press=evento.keyCode;
		else
			tecla_press=evento.which;

		if(tecla_press==8 || tecla_press==0)
			return true;
			
		numero=String.fromCharCode(tecla_press);
		if(patron_numeros.test(numero)==true)
			return (patron_numeros.test(numero));
		else {
			alert('Solo se permiten numeros en este campo');
			return false;
		}
	}

	function caracteres(evento) {
		tecla=(document.all) ? evento.keyCode: evento.which;
		if(tecla==8 || tecla==0) {
			return true;
		}
		patron=/[A-Za-zñÑ]/;
		te=String.fromCharCode(tecla);
		te.toUpperCase();
		if(tecla==32) {
			return true;	
		} else if(patron.test(te)==true) {
			return true;
		} else {
			alert('Caracter no valido');
			return false;
		}
	}