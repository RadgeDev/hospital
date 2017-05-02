$(document).on("ready", main);


function main(){
  setInterval(obtenerCorrelativo, 400);
  $.ajaxPrefilter(function( options, original_Options, jqXHR ) {
    options.async = true;
});
	mostrarDatos("",1,10,"cod_interno_prod");
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
		url : "http://localhost/hospital/control_producto/mostrar",
		type: "POST",
		data: {buscar:valorBuscar,nropagina:pagina,cantidad:cantidad,valorcombos:valorcombo},
		dataType:"json",
		success:function(response){
			
			filas = "";
			$.each(response.obtener,function(key,item){
				filas+="<tr class='active' ><td >"+item.cod_interno_prod+"</td><td>"+item.codigo_barra+"</td><td>"+item.cod_bodega+"</td><td>"+item.nombre+"</td><td>"+item.cantidad+
        "</td><td>"+item.precio+"</td><td>"+item.unidad_medida+
        "</td><td>"+item.stock_critico+"</td><td>"+item.stock_minimo+
        "</td><td>"+item.stock_maximo+
        "</td><td> <button href='"+item.cod_interno_prod+"'  id='editando'  onclick='editandos(this);' class='btn btn-warning' data-toggle='modal' data-target='#myModalEditar'>E</button> <button href='"+item.cod_interno_prod+"'  id='eliminando'  onclick='eliminar(this);' class='btn btn-danger' >X</button></td></tr>";
			});

			$("#tbproductos tbody").html(filas);
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

$("select[name=cod_combo]").change(function(){
            $('input[name=combocorrelativo]').val($(this).val());  
            var varieble = $("#combocorrelativo").val();
            if (varieble==='Elige una opcion') {
            $("#combocorrelativo").val("");  
            }    
 });

$("select[name=medida]").change(function(){
            $('input[name=seleccion]').val($(this).val());
            var varieble = $("#seleccion").val();
            if (varieble==='Seleccione una opcion') {
            $("#seleccion").val("");
             }
   
 });



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


//evitar enter codigo de barras
  $('#codigobarra').keypress(function(e){
    if(e.which == 13){
      return false;
    }
  });
    $('#nombre').keypress(function(e){
    if(e.which == 13){
      return false;
    }
  });

function obtenerCorrelativo() {
var porId=document.getElementById("cod_combo").value;
if (porId==0) {
$("#codigo").val("");
}else {

   var micorrelatico;
   var ultimocodigo;
    var entero;
    micod = $("#combocorrelativo").val();
    $.ajax({
    url:"http://localhost/hospital/control_producto/obtenercorrelativo",
    type:"POST",
    dataType:"json",
    data:{cod:micod},
    success:function(respuesta){
    $.each(respuesta.obtener,function(key,item){
     micorrelativo=item.correlativo;
    ultimocodigo=item.ultimo_codigo;
   // alert(ultimocodigo);
    entero = parseInt(ultimocodigo);
  });
       
   var numero=entero+1;
    $("#codigo").val(micorrelativo+numero);
    $("#ultimocorrelativo").val(numero);

  }
  });
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


$("#formGuardar").submit(function (event){

    event.preventDefault();

    $.ajax({
      url:$("#formGuardar").attr("action"),
      type:$("#formGuardar").attr("method"),
      data:$("#formGuardar").serialize(),
      success:function(respuesta){
       
        if (respuesta === "Registro Guardado") {
         
           $('#myModalguardar').modal('hide');//esconde formulario modal
           swal("Genial!", "Datos ingresados Correctamente", "success");// a trves swift una libreria permite crear mensajes bonitos
           $('#formGuardar').get(0).reset();//resetea  los campos del formulario
             $("#msg-error").hide();
        } else if (respuesta === "No se pudo guardar los datos") {
          swal("Error", "Error revise si los datos estan correctos", "error");
        }
        else
        {
    
          $("#msg-error").show();
          $(".list-errors").html(respuesta);
        }
       mostrarDatos("",1,10,"cod_interno_prod");
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
   $('#formGuardar').get(0).reset();//resetea  los campos del formulario
}


$("#actualizaron").click(actualizar);
function actualizar(){

  $("#usuarioEditar").submit(function (event){
  
   event.preventDefault();
 });
  $.ajax({
    url:"http://localhost/hospital/control_producto/actualizar",
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
        	mostrarDatos("",1,10,"cod_interno_prod");
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

    url:"http://localhost/hospital/control_producto/eliminar",
    type:"POST",
    data:{micodigo:borrarrut},
    success:function(respuesta){

      if (respuesta ==="Registro Eliminado") {
           swal("Genial!", respuesta, "success");// a trves swift una libreria permite crear mensajes bonitos
           
        }else{
          swal("Error", respuesta, "error");
        }
  mostrarDatos("",1,10,"cod_interno_prod");
    }
  });

}

