
$( document ).ready(function() {
	function mostrarDatos(valor) {
	$.ajax({
		url: "http://localhost/hospital/man_usuarios/mostrar",
		type:"POST",
		data:{buscar:valor},
		success:function(respuesta){
			alert(respuesta);
		}

	});


}
});

