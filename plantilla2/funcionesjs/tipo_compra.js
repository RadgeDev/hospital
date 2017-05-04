$(document).on("ready", main);


function main(){
	mostrarDatos("",1,10,"cod_tipocompra");
	

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
		mostrarDatos(valorBuscar,valorhref,valoroption,"cod_tipocompra");
	});

	$("#cantidad").change(function(){
		valoroption = $(this).val();
		valorBuscar = $("input[name=busqueda]").val();
		mostrarDatos(valorBuscar,1,valoroption,"cod_tipocompra");
	});
}
function mostrarDatos(valorBuscar,pagina,cantidad,valorcombo){

	$.ajax({
		url : "http://localhost/hospital/control_tipo_compra/mostrar",
		type: "POST",
		data: {buscar:valorBuscar,nropagina:pagina,cantidad:cantidad,valorcombos:valorcombo},
		dataType:"json",
		success:function(response){
			
			filas = "";
			$.each(response.tipocompra,function(key,item){
				filas+="<tr class='active' ><td >"+item.cod_tipocompra+"</td><td>"+item.nombre+"</td><td> <button href='"+item.cod_tipocompra+"'  id='editando'  onclick='editandos(this);' class='btn btn-warning' data-toggle='modal' data-target='#myModalEditar'>E</button> <button href='"+item.cod_tipocompra+"'  id='eliminando'  onclick='eliminar(this);' class='btn btn-danger' >X</button></td></tr>";
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
    url:"http://localhost/hospital/control_tipo_compra/validar",
    type:"POST",
    data:{id:micodigo},
    success:function(respuesta){
      valorcodigo = $("#codigo").val();
      if (valorcodigo==="") {
  document.getElementById("codigo").focus();
     
      }else{
    if (respuesta ==="Codigo existe" ) {
    swal("Error!", "Este Codigo ya esta registrado", "error");// a trves swift una libreria permite crear mensajes bonitos       
        
       
       $('#formGuardar').get(0).reset();//resetea  los campos del formulario
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

   


$("#formGuardar").submit(function (event){

    event.preventDefault();

    $.ajax({
      url:$("#formGuardar").attr("action"),
      type:$("#formGuardar").attr("method"),
      data:$("#formGuardar").serialize(),
      success:function(respuesta){
       
        if (respuesta === "Registro Guardado") {
         
           $('#myModaldepartamento').modal('hide');//esconde formulario modal
           swal("Genial!", "Datos ingresados Correctamente", "success");// a trves swift una libreria permite crear mensajes bonitos
           $('#formGuardar').get(0).reset();//resetea  los campos del formulario
          $('#myModalguardar').modal('hide');
        } else if (respuesta === "No se pudo guardar los datos") {
          swal("Error", "Error revise si los datos estan correctos", "error");
        }
        else
        {
    
          $("#msg-error").show();
          $(".list-errors").html(respuesta);
        }
       mostrarDatos("",1,10,"cod_tipocompra");
      }
    });
  });


$("#cerrando").click(cerrarModal);

$("#editando").click(editandos);


function editandos(obj) {
  var codseleccionado = obj.getAttribute("href");
   $("#msg-error2").hide();
    event.preventDefault();
// alert(rutseleccionado);
 $.ajax({
    url:"http://localhost/hospital/control_tipo_compra/editando",
    type:"POST",
    data:{id:codseleccionado},
    dataType:"json",
    success:function(respuesta){
   $.each(respuesta.obtener,function(key,item){
    $("#seleccod").val(item.cod_tipocompra);
    $("#selecnombre").val(item.nombre);
      });

    }

  });



}


function cerrarModal() {
  $("#msg-error").hide();
   $('#formGuardar').get(0).reset();//resetea  los campos del formulario
    $('#myModaldepto').modal('hide');
    $('#myModaleditar').modal('hide');
}


//$("#actualizaron").click(actualizar);






//editar ver en form editar modalhide url  al controlado depto
  $("#formEditar").submit(function (event){
   event.preventDefault();

  $.ajax({
 url:$("#formEditar").attr("action"),
      type:$("#formEditar").attr("method"),
      data:$("#formEditar").serialize(),
    success:function(respuesta){
       if (respuesta === "Registro Actualizado") {
         $('#formEditar').get(0).reset();//resetea  los campos del formulario
           $('#myModalEditar').modal('hide');//esconde formulario modal
           swal("Genial!", "Datos Editados Correctamente", "success");// a trves swift una libreria permite crear mensajes bonitos
           
        } else if (respuesta === "Error al Actualizar") {
          $('#formEditar').get(0).reset();//resetea  los campos del formulario
             $('#myModalEditar').modal('hide');//esconde formulario modal
          swal("Error", respuesta, "error");
        }
        else
        {
    
          $("#msg-error2").show();
          $(".list-errors").html(respuesta);
        }
        	mostrarDatos("",1,10,"cod_tipocompra");
      }
    });
  });



function eliminar(obj) {

codseleccionado = obj.getAttribute("href");
   
swal({
  title: "Estas seguro que deseas eliminar?",
  text: "Quieres eliminar el Codigo: "+codseleccionado ,
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Si, deseo borrarlo!",
  closeOnConfirm: false
},
function(){

 eliminando(codseleccionado); 
  swal("Eliminado!", "Registro eliminado.", "success");
});

}

function eliminando(borrarcod){
  $.ajax({

    url:"http://localhost/hospital/control_tipo_compra/eliminar",
    type:"POST",
    data:{micod:borrarcod},
    success:function(respuesta){

      if (respuesta ==="Registro Eliminado") {
           swal("Genial!", respuesta, "success");// a trves swift una libreria permite crear mensajes bonitos
           
        }else{
          swal("Error", respuesta, "error");
        }
  mostrarDatos("",1,10,"cod_tipocompra");
    }
  });

}

