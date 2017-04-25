$(document).on("ready", main);


function main(){
	mostrarDatos("",1,10,"cod_depto");
	$("#msg-error").hide();

	
	$("input[name=busqueda]").keyup(function(){
		textobuscar = $(this).val();
		valoroption = $("#cantidad").val();
	    var valorcombo = $("#buscando").val();
	   
		mostrarDatos(textobuscar,1,valoroption,valorcombo);
	});

	$("body").on("click",".paginacion li a",function(e){
		e.preventDefault();
		valorhref = $(this).attr("href");
		valorBuscar = $("input[name=busqueda]").val();
		valoroption = $("#cantidad").val();
		mostrarDatos(valorBuscar,valorhref,valoroption,"cod_depto");
	});

	$("#cantidad").change(function(){
		valoroption = $(this).val();
		valorBuscar = $("input[name=busqueda]").val();
		mostrarDatos(valorBuscar,1,valoroption,"cod_depto");
	});
}
function mostrarDatos(valorBuscar,pagina,cantidad,valorcombo){

	$.ajax({
		url : "http://localhost/hospital/control_depto/mostrar",
		type: "POST",
		data: {buscar:valorBuscar,nropagina:pagina,cantidad:cantidad,valorcombos:valorcombo},
		dataType:"json",
		success:function(response){
			
			filas = "";
			$.each(response.depto,function(key,item){
				filas+="<tr class='active' ><td >"+item.cod_depto+"</td><td>"+item.nombre_depto+"</td><td> <button href='"+item.cod_depto+"'  id='editando'  onclick='editandos(this);' class='btn btn-warning' data-toggle='modal' data-target='#myModalEditar'>E</button> <button href='"+item.cod_depto+"'  id='eliminando'  onclick='eliminar(this);' class='btn btn-danger' >X</button></td></tr>";
			});

			$("#tbclientes tbody").html(filas);
			linkseleccionado = Number(pagina);
			//total registros
			totalregistros = response.totalregistros;
			//cantidad de registros por pagina
			cantidadregistros = response.cantidad;

			numerolinks = Math.ceil(totalregistros/cantidadregistros);
			paginador = "<ul class='pagination'>";
		 	if(linkseleccionado>1)
			{
				paginador+="<li><a href='1'>&laquo;</a></li>";
				paginador+="<li><a href='"+(linkseleccionado-1)+"' '>&lsaquo;</a></li>";

			}
			else
			{
				paginador+="<li class='disabled'><a href='#'>&laquo;</a></li>";
				paginador+="<li class='disabled'><a href='#'>&lsaquo;</a></li>";
			}
			//muestro de los enlaces 
			//cantidad de link hacia atras y adelante
 			cant = 2;
 			//inicio de donde se va a mostrar los links
			pagInicio = (linkseleccionado > cant) ? (linkseleccionado - cant) : 1;
			//condicion en la cual establecemos el fin de los links
			if (numerolinks > cant)
			{
				//conocer los links que hay entre el seleccionado y el final
				pagRestantes = numerolinks - linkseleccionado;
				//defino el fin de los links
				pagFin = (pagRestantes > cant) ? (linkseleccionado + cant) :numerolinks;
			}
			else 
			{
				pagFin = numerolinks;
			}

			for (var i = pagInicio; i <= pagFin; i++) {
				if (i == linkseleccionado)
					paginador +="<li class='active'><a href='javascript:void(0)'>"+i+"</a></li>";
				else
					paginador +="<li><a href='"+i+"'>"+i+"</a></li>";
			}
			//condicion para mostrar el boton sigueinte y ultimo
			if(linkseleccionado<numerolinks)
			{
				paginador+="<li><a href='"+(linkseleccionado+1)+"' >&rsaquo;</a></li>";
				paginador+="<li><a href='"+numerolinks+"'>&raquo;</a></li>";

			}
			else
			{
				paginador+="<li class='disabled'><a href='#'>&rsaquo;</a></li>";
				paginador+="<li class='disabled'><a href='#'>&raquo;</a></li>";
			}
			
			paginador +="</ul>";
			$(".paginacion").html(paginador);

		}
	});
}




function validarCodigo() {
 micodigo = $("#codigo").val();

  $.ajax({
    url:"http://localhost/hospital/control_depto/validar",
    type:"POST",
    data:{id:micodigo},
    success:function(respuesta){
      valorcodigo = $("#codigo").val();
      if (valorcodigo==="") {
  document.getElementById("codigo").focus();
     
      }else{
    if (respuesta ==="Codigo existe" ) {
    swal("Error!", "Este Codigo ya esta registrado", "error");// a trves swift una libreria permite crear mensajes bonitos       
        
       
       $('#departamentoGuardar').get(0).reset();//resetea  los campos del formulario
        document.getElementById("codigo").focus();
    
    }else{
        
 document.getElementById("nombre").focus();

        }
  }
    }
  });

}





 function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

   


$("#departamentoGuardar").submit(function (event){

    event.preventDefault();

    $.ajax({
      url:$("#departamentoGuardar").attr("action"),
      type:$("#departamentoGuardar").attr("method"),
      data:$("#departamentoGuardar").serialize(),
      success:function(respuesta){
       
        if (respuesta === "Registro Guardado") {
         
           $('#myModaldepartamento').modal('hide');//esconde formulario modal
           swal("Genial!", "Datos ingresados Correctamente", "success");// a trves swift una libreria permite crear mensajes bonitos
           $('#departamentoGuardar').get(0).reset();//resetea  los campos del formulario
        } else if (respuesta === "No se pudo guardar los datos") {
          swal("Error", "Error revise si los datos estan correctos", "error");
        }
        else
        {
    
          $("#msg-error").show();
          $(".list-errors").html(respuesta);
        }
       mostrarDatos("",1,10,"cod_depto");
      }
    });
  });


$("#cerrando").click(cerrarModal);

$("#editando").click(editandos);


function editandos(obj) {
  var rutseleccionado = obj.getAttribute("href");
   $("#msg-error2").hide();
    event.preventDefault();
// alert(rutseleccionado);
 $.ajax({
    url:"http://localhost/hospital/control_proveedor/editando",
    type:"POST",
    data:{id:rutseleccionado},
    dataType:"json",
    success:function(respuesta){
   $.each(respuesta.obtener,function(key,item){
    $("#selecrut").val(item.rut_proveedor);
    $("#selecnombre").val(item.nombre_proveedor);
    $("#selecrazon").val(item.razon_social);
    $("#selecdireccion").val(item.direccion);
    $("#selectelefono").val(item.telefono);
    $("#seleccorreo").val(item.correo);
      });

    }

  });



}


function cerrarModal() {
  $("#msg-error").hide();
    $("#msgerrorut").hide();
   $('#departamentoGuardar').get(0).reset();//resetea  los campos del formulario
}


$("#actualizaron").click(actualizar);
function actualizar(){

  $("#usuarioEditar").submit(function (event){
  
   event.preventDefault();
 });
  $.ajax({
    url:"http://localhost/hospital/control_proveedor/actualizar",
    type:"POST",
    data:$("#usuarioEditar").serialize(),
    success:function(respuesta){
       if (respuesta === "Registro Actualizado") {
         $('#usuarioEditar').get(0).reset();//resetea  los campos del formulario
           $('#myModalEditar').modal('hide');//esconde formulario modal
           swal("Genial!", "Datos Editados Correctamente", "success");// a trves swift una libreria permite crear mensajes bonitos
           
        } else if (respuesta === "Error al Actualizar") {
          $('#usuarioEditar').get(0).reset();//resetea  los campos del formulario
             $('#myModalEditar').modal('hide');//esconde formulario modal
          swal("Error", respuesta, "error");
        }
        else
        {
    
          $("#msg-error2").show();
          $(".list-errors").html(respuesta);
        }
        	mostrarDatos("",1,10,"rut_proveedor");
      }
    });
 
}


function eliminar(obj) {

rutseleccionado = obj.getAttribute("href");
   
swal({
  title: "Estas seguro que deseas eliminar?",
  text: "Quieres eliminar al RUT: "+rutseleccionado ,
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Si, deseo borrarlo!",
  closeOnConfirm: false
},
function(){

 eliminando(rutseleccionado); 
  swal("Eliminado!", "Registro eliminado.", "success");
});

}

function eliminando(borrarrut){
      alert(borrarrut);
  $.ajax({

    url:"http://localhost/hospital/control_proveedor/eliminar",
    type:"POST",
    data:{mirut:borrarrut},
    success:function(respuesta){

      if (respuesta ==="Registro Eliminado") {
           swal("Genial!", respuesta, "success");// a trves swift una libreria permite crear mensajes bonitos
           
        }else{
          swal("Error", respuesta, "error");
        }
  mostrarDatos("",1,10,"rut_proveedor");
    }
  });

}

