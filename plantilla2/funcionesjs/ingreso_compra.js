    $(document).on("ready", main);
   $(document).on("ready", mostrarProveedores);
   $(document).on("ready", mostrarProductos);
function main(){

var now = new Date();
$( "#datetimepicker1" ).datepicker({dateFormat:"dd/mm/yy"}).datepicker("setDate",new Date());

setTimeout("mostrarhora()",1000); 

 $("#msg-error").hide();
 }

function mostrarhora(){ 
momentoActual = new Date() ;
hora = momentoActual.getHours() ;
minuto = momentoActual.getMinutes() ;
segundo = momentoActual.getSeconds() ;
if (segundo<10) {
	segundo="0"+segundo
}
if (minuto<10) {
	minuto="0"+minuto
}
horaImprimible = hora + " : " + minuto + " : " + segundo ;
$("#hora").val(horaImprimible);
setTimeout("mostrarhora()",1000); 
}



function mostrarfecha() {
var d= new Date();

var dia = d.getDate(); 
var mes =  ("0" + (d.getMonth() + 1));
var anio = d.getFullYear(); 

var fechatotal = dia + "/"+ mes +"/" + anio;

$("#fechaingreso").html('fechatotal');
alert(fechatotal);


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
borrardatalist();
mostrarProveedores();

      }
    });
  });

  function cerrarModal() {
  $("#msg-error").hide();
    $("#msgerrorut").hide();
   $('#proveedorGuardar').get(0).reset();//resetea  los campos del formulario
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







function mostrarProveedores(){
	$.ajax({
		url : "http://localhost/hospital/control_compra_ingreso/devolverarray",
		type: "POST",
		dataType:"json",
		success:function(response){
			
			filas = "";
			filas2="";
			$.each(response.proveedor,function(key,item){
				filas2+='<option value="'+item.nombre_proveedor+'" />'+item.rut_proveedor+'';
			});

        var my_list2=document.getElementById("misproveedores2");
        my_list2.innerHTML = filas2;
		}
			});

}

function mostrarProductos(){

	$.ajax({
		url : "http://localhost/hospital/control_compra_ingreso/devolverproductos",
		type: "POST",
		dataType:"json",
		success:function(response){
			
			filas = "";
			$.each(response.misproductos,function(key,item){
				filas+='<option id="'+item.codigo_barra+'" data-codigo="'+item.cod_interno_prod+'" value="'+item.nombre+'" />'+item.codigo_barra+'';
			});

            var my_list=document.getElementById("buscandoprod");
            my_list.innerHTML = filas;
		}
			});

}



function borrardatalist(){
 
        var parent = document.getElementById("misproveedores2");
        var childArray = parent.children;
        var cL = childArray.length;
        while(cL > 0) {
            cL--;
            parent.removeChild(childArray[cL]);
        }
}


$(function(){
    $('#Agregandogrilla').click(function(){
 var minombre= $("#buscandoprod option[value='" + $('#buscarproducto').val() + "']").attr('value');
  var micodbarra= $("#buscandoprod option[value='" + $('#buscarproducto').val() + "']").attr('id');
 var micodigo=$("#buscandoprod option[value='" + $('#buscarproducto').val() + "']").attr('data-codigo');
  $("#codigoarticulo").val(micodigo);
    $("#codigobarra").val(micodbarra);
      $("#nombreproducto").val(minombre);
    });
});

function multiplicar() {
 n1 =  $("#recepcionado").val();
  n2 = $("#valorunidad").val();
  total= parseInt(n1) * parseFloat(n2);
    $("#valortotal").val(parseFloat(total));
 }



function cerrarModal() {
   $('#ingresararticulo').get(0).reset();//resetea  los campos del formulario
}

//evitar enter codigo de barras
  $('#buscarproducto').keypress(function(e){
    if(e.which == 13){
      return false;
    }
  });





  function addProductotabla(e) {
  e.preventDefault();
  const row = createRow({
    codigointerno: $('#codigoarticulo').val(),
    codigobarra: $('#codigobarra').val(),
    nombre: $('#nombreproducto').val(),
    lote:$('#lote').val(),
    vencimiento:$('#fechaingreso').val(),
    cantidad:$('#recepcionado').val(),
    valorunitario:$('#valorunidad').val(),
    valortotal:$('#valortotal').val(),
  });
  $("#tbproductos tbody").append(row);
  clean();
}

function createRow(data) {
  return (
    `<tr class='active'>` +
      `<td>${data.codigointerno}</td>` +
      `<td>${data.codigobarra}</td>` +
       `<td>${data.nombre}</td>` +
       `<td>${data.lote}</td>` +
       `<td>${data.vencimiento}</td>` +
       `<td>${data.cantidad}</td>` +
       `<td>${data.valorunitario}</td>` +
       `<td>${data.valortotal}</td>` +
    `</tr>`
  );
}

function clean() {
  $('#name').val('');
  $('#lastname').val('');
  $('#name').focus();
}


