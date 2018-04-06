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

function verificar_usuario(f) {
	//alert(f.username.value);
	//alert(f.password.value);
	if (f.username.value=="" || f.password.value=="")
		alert("Su usuario y password son requeridos")
	else 
		f.submit();
}

function validar_especialidad() {
	var f=eval("document.forms[0]")
	alert(f.especialidad.length);
	for (i=0; i<f.especialidad.length; i++) {
		if(f.especialidad.options[i].selected==true)
			f.id_especialidad.value += f.especialidad.options[i].value+",";
	}
	f.submit();
}