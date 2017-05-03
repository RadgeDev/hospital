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
		valoroption = $("#cantidadpag").val();
	    var valorcombo = $("#buscando").val();
	   
		mostrarDatos(textobuscar,1,valoroption,valorcombo);
	});

	$("body").on("click",".paginacion li a",function(e){
		e.preventDefault();
		valorhref = $(this).attr("href");
		valorBuscar = $("input[name=busqueda]").val();
		valoroption = $("#cantidadpag").val();
		mostrarDatos(valorBuscar,valorhref,valoroption,"cod_interno_prod");
	});

	$("#cantidadpag").change(function(){
		valoroption = $(this).val();
		valorBuscar = $("input[name=busqueda]").val();
		mostrarDatos(valorBuscar,1,valoroption,"cod_interno_prod");
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

$("select[name=editcod_combo]").change(function(){
            $('input[name=editcombocorrelativo]').val($(this).val());  
            var varieble = $("#editcombocorrelativo").val();
            if (varieble==='Elige una opcion') {
            $("#editcombocorrelativo").val("");  
            }    
 });

$("select[name=medida2]").change(function(){
            $('input[name=seleccion2]').val($(this).val());
            var varieble = $("#seleccion2").val();
            if (varieble==='Seleccione una opcion') {
            $("#seleccion2").val("");
             }
   
 });


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
     $('#editcodigobarra').keypress(function(e){
    if(e.which == 13){
      return false;
    }
  });
    $('#editnombre').keypress(function(e){
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

function obtenerCorrelativo2() {
var porId=document.getElementById("editcod_combo").value;
if (porId==0) {
$("#editcodigo").val("");
}else {

   var micorrelatico;
   var ultimocodigo;
    var entero;
    micod = $("#editcombocorrelativo").val();
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
    $("#editcodigo").val(micorrelativo+numero);
    $("#editultimocorrelativo").val(numero);

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

   function solonumeros(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "1234567890.,";
     

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
  var codseleccionado = obj.getAttribute("href");
   $("#msg-error2").hide();
    event.preventDefault();
// alert(codseleccionado);
 $.ajax({
    url:"http://localhost/hospital/control_producto/editando",
    type:"POST",
    data:{id:codseleccionado},
    dataType:"json",
    success:function(respuesta){
   $.each(respuesta.obtener,function(key,item){
  $("#editcod_combo option[value="+ item.cod_bodega +"]").attr("selected",true);
    $("#editcodigo").val(item.cod_interno_prod);
    $("#editcodigobarra").val(item.codigo_barra);
    $("#editnombre").val(item.nombre);
    $("#editcantidad").val(item.cantidad);
    $("#editprecio").val(item.precio);
    $("#editstockcri").val(item.stock_critico);
    $("#editstockmin").val(item.stock_minimo);
    $("#editstockmax").val(item.stock_maximo);
    $("#seleccion2").val(item.unidad_medida);
    var unidad =item.unidad_medida;
    document.getElementById('medida2').value= unidad;


      });

    }

  });
}


function cerrarModal() {
  $("#msg-error").hide();
    $("#msgerrorut").hide();
   $('#formGuardar').get(0).reset();//resetea  los campos del formulario
}





  $("#formEditar").submit(function (event){
  
   event.preventDefault();

  $.ajax({
      url:$("#formEditar").attr("action"),
      type:$("#formEditar").attr("method"),
      data:$("#formEditar").serialize(),
    success:function(respuesta){
       if (respuesta === "Registro Guardado") {
          $("#msg-error2").hide();
         $('#formEditar').get(0).reset();//resetea  los campos del formulario
           $('#myModalEditar').modal('hide');//esconde formulario modal
           swal("Genial!", "Datos Editados Correctamente", "success");// a trves swift una libreria permite crear mensajes bonitos
           
        } else if (respuesta === "No se pudo guardar los datos") {
          $('#formEditar').get(0).reset();//resetea  los campos del formulario
             $('#myModalEditar').modal('hide');//esconde formulario modal
          swal("Error", respuesta, "error");
        }
        else
        {
    
          $("#msg-error2").show();
          $(".list-errors2").html(respuesta);
        }
        	mostrarDatos("",1,10,"cod_interno_prod");
      }
    });
 
 });


function eliminar(obj) {

rutseleccionado = obj.getAttribute("href");
   
swal({
  title: "Estas seguro que deseas eliminar?",
  text: "Quieres eliminar al Codigo: "+rutseleccionado ,
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

