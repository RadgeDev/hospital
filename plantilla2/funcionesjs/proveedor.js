$(document).on("ready", main);


function main(){
	mostrarDatos("",1,10,"rut_proveedor");
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
		mostrarDatos(valorBuscar,valorhref,valoroption,"rut_proveedor");
	});

	$("#cantidad").change(function(){
		valoroption = $(this).val();
		valorBuscar = $("input[name=busqueda]").val();
		mostrarDatos(valorBuscar,1,valoroption,"rut_proveedor");
	});
}
function mostrarDatos(valorBuscar,pagina,cantidad,valorcombo){

	$.ajax({
		url : "http://localhost/hospital/control_proveedor/mostrar",
		type: "POST",
		data: {buscar:valorBuscar,nropagina:pagina,cantidad:cantidad,valorcombos:valorcombo},
		dataType:"json",
		success:function(response){
			
			filas = "";
			$.each(response.clientes,function(key,item){
				filas+="<tr><td>"+item.rut_proveedor+"</td><td>"+item.nombre_proveedor+"</td><td>"+item.razon_social+"</td><td>"+item.direccion+"</td><td>"+item.telefono+"</td><td>"+item.correo+"</td><td> <a href='"+item.rut_proveedor+"' class='btn btn-warning' data-toggle='modal' data-target='#myModalEditar'>E</a></td></tr>";
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




function validar(mirut){
 
  $.ajax({
    url:"http://localhost/hospital/control_proveedor/validar",
    type:"POST",
    data:{id:mirut},
    success:function(respuesta){
    if (respuesta ==="Rut existe" ) {
    	$('#rut').val("");
    	swal("Error!", "Este rut ya esta registrado", "error");// a trves swift una libreria permite crear mensajes bonitos       
        document.getElementById("rut").focus();
    }else{
        


        }
  
    }
  });

}


var Fn = {
  // Valida el rut con su cadena completa "XXXXXXXX-X"
  validaRut : function (rutCompleto) {
    if (!/^[0-9]+-[0-9kK]{1}$/.test( rutCompleto ))
      return false;
    var tmp   = rutCompleto.split('-');
    var digv  = tmp[1]; 
    var rut   = tmp[0];
    if ( digv == 'K' ) digv = 'k' ;
    return (Fn.dv(rut) == digv );
  },
  dv : function(T){
    var M=0,S=1;
    for(;T;T=Math.floor(T/10))
      S=(S+T%10*(9-M++%6))%11;
    return S?S-1:'k';
  }
}

function validarRut() {


if (Fn.validaRut( $("#rut").val() )){
   // $("#msgerrorut").html("El rut ingresado es válido :D");
  var inputs = $('#rut')
  var mirut = $(inputs).val();
  validar(mirut);
    $("#msgerrorut").html(" ");
  } else {
    $("#msgerrorut").show();
    $("#msgerrorut").html("<font color='red'>El Rut no es válido  </font> ");
     document.getElementById("rut").focus();
  }
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

    function solorut(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "1234567890-";
     

        if(letras.indexOf(tecla)==-1){
            return false;
        }
    }


$("#proveedorGuardar").submit(function (event){

    event.preventDefault();

    $.ajax({
      url:$("#proveedorGuardar").attr("action"),
      type:$("#proveedorGuardar").attr("method"),
      data:$("#proveedorGuardar").serialize(),
      success:function(respuesta){
       
        if (respuesta === "Registro Guardado") {
         
           $('#myModalproveedor').modal('hide');//esconde formulario modal
           swal("Genial!", "Datos ingresados Correctamente", "success");// a trves swift una libreria permite crear mensajes bonitos
           $('#proveedorGuardar').get(0).reset();//resetea  los campos del formulario
        } else if (respuesta === "No se pudo guardar los datos") {
          swal("Error", "Error revise si los datos estan correctos", "error");
        }
        else
        {
    
          $("#msg-error").show();
          $(".list-errors").html(respuesta);
        }
       mostrarDatos("",1,10,"rut_proveedor");
      }
    });
  });


$("#cerrando").click(cerrarModal);

function cerrarModal() {
  $("#msg-error").hide();
    $("#msgerrorut").hide();
   $('#usuarioGuardar').get(0).reset();//resetea  los campos del formulario
}



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
           swal("Genial!", "Datos Eitados Correctamente", "success");// a trves swift una libreria permite crear mensajes bonitos
           
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
 

$("body").on("click","tbody a",function(event){
   
    $("#msg-error2").hide();
    event.preventDefault();
    rutsele = $(this).attr("href");
    nombressele = $(this).parent().parent().children("td:eq(1)").text();
    razonsele = $(this).parent().parent().children("td:eq(2)").text();
    direccionsele = $(this).parent().parent().children("td:eq(3)").text();
    telefonosele = $(this).parent().parent().children("td:eq(4)").text();
    correosele = $(this).parent().parent().children("td:eq(5)").text();
    $("#selecrut").val(rutsele);
    $("#selecnombre").val(nombressele);
    $("#selecrazon").val(razonsele);
    $("#selecdireccion").val(direccionsele);
    $("#selectelefono").val(telefonosele);
    $("#seleccorreo").val(correosele);
  

  }); 

}