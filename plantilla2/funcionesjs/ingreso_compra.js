    $(document).on("ready", main);
   $(document).on("ready", mostrarProveedores);
   $(document).on("ready", mostrarProductos);
      $(document).on("ready", desabilitarcontroles);
    
function main(){
  setInterval(obtenerCorrelativo, 400);
var now = new Date();
$( "#datetimepicker1" ).datepicker({dateFormat:"dd/mm/yy"}).datepicker("setDate",new Date());

setTimeout("mostrarhora()",1000); 

 $("#msg-error").hide();
  $("#msg-error2").hide();
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
      $('#formGuardar').get(0).reset();//resetea  los campos del formulario
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


function borrardatalist2(){
 
        var parent = document.getElementById("buscandoprod");
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
    $("#msg-error").hide();
    $("#msgerrorut").hide();
       $("#msg-error2").hide();

}

//evitar enter codigo de barras
  $('#buscarproducto').keypress(function(e){
    if(e.which == 13){
      return false;
    }
  });





  function addProductotabla(e) {
  var micodigoarticulo=	$('#codigoarticulo').val();
  var milote=	$('#lote').val();
  var mifecha=$('#fechaingreso').val();
  var mirecepcionado= $('#recepcionado').val();
  var mivalorunidad=$('#valorunidad').val();
  var mivalortotal=$('#valortotal').val();
if (micodigoarticulo==="") {
   swal("Error", "Error vuelva agregar el articulo", "error");
     e.preventDefault();
}else if(milote==="") {
 swal("Error", "Agrege un lote valido", "error");
   e.preventDefault();
}else if(mifecha==="") {
 swal("Error", "Agrege un fecha valida", "error");
   e.preventDefault();
}else if(mirecepcionado==0 || mirecepcionado===""  ) {
 swal("Error", "Agrege la cantidad recepcionada valida", "error");
   e.preventDefault();
}else if(mivalorunidad==0 || mivalorunidad==="") {
 swal("Error", "Agrege la valor unidad valida", "error");
   e.preventDefault();
}else if(mivalortotal==0 || mivalortotal==="") {
 swal("Error", "Agrege la cantidad recepcionada y  valor unidad ", "error");
   e.preventDefault();
}else {
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

    $('#ingresararticulo').get(0).reset();//resetea  los campos del formulario
   $('#largeModal').modal('hide');
    calculartotal();
    $("#descuento").prop("readonly",false);
    $("#agregardesc").prop("disabled",false);
    $("#Comentarios").prop("readonly",false);
  
}
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
       `<td><button   id='eliminando'  onclick='' class='btn btn-danger delRowBtn' >X</button></td>` +
    `</tr>`
  );
}
function calculartotal() {
	 var theneto = 0;
    $("td:nth-child(8)").each(function () {
        var val = $(this).text().replace(" ", "").replace(",-", "");
        theneto += parseInt(val);
    });
    var iva_venta=0;
     var total=0;
     var descuento= $("#descuento").val();
  if(descuento===""){
  	swal("Error", "Agrege decuento valido", "error");
 descuento=0;
  }
  thenetodesc=theneto-descuento;
     iva_venta = thenetodesc * (19/100);
      total = thenetodesc + iva_venta;
$("#valorfactura").val(theneto);
$("#neto").val(thenetodesc);
$("#iva").val(iva_venta);
$("#total").val(total);

}



function desabilitarcontroles() {

$("#ndocumento").prop("readonly",true);
$("#Comentarios").prop("readonly",true);
$("#proveedorrut").prop("readonly",true);
$("#combo_tipocompra").prop("disabled",true);
$("#buscarproducto").prop("readonly",true);
$("#descuento").prop("readonly",true);
$("#agregarprov").prop("disabled",true);
$("#agreganuevo").prop("disabled",true);
$("#agregardesc").prop("disabled",true);
$("#Agregandogrilla").prop("disabled",true);
}


$("select[name=combo_tipoingreso]").change(function(){
    var porNombre=document.getElementsByName("combo_tipoingreso")[0].value;
         if (porNombre==0) {
         $("#ndocumento").prop("readonly",true);
         $("#ndocumento").val("");
            } else{
            	      
           $("#ndocumento").prop("readonly",false);

            }    
 });

function habilitando() {
var mitexto=$("#ndocumento").val();
if (mitexto=="") {
	$("#combo_tipocompra").val('0');
	$("#combo_tipocompra").prop("disabled",true);
}else{
	$("#combo_tipocompra").prop("disabled",false);
}

var mitexto2=$("#proveedorrut").val();
if (mitexto2=="") {
$("#buscarproducto").val("");
$("#buscarproducto").prop("readonly",true);
$("#Agregandogrilla").prop("disabled",true);
$("#agreganuevo").prop("disabled",true);
}else{
$("#buscarproducto").prop("readonly",false);
$("#Agregandogrilla").prop("disabled",false);
$("#agreganuevo").prop("disabled",false);
}



}

$("select[name=combo_tipocompra]").change(function(){
	   var porNombre=document.getElementsByName("combo_tipocompra")[0].value;
       if (porNombre==0) {
         $("#proveedorrut").prop("readonly",true);
         $("#agregarprov").prop("disabled",true);
         $("#proveedorrut").val("");
            } else{
            	      
           $("#proveedorrut").prop("readonly",false);
           $("#agregarprov").prop("disabled",false);

            }    
 
 });




///guardar
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
             $("#msg-error2").hide();
        } else if (respuesta === "No se pudo guardar los datos") {
          swal("Error", "Error revise si los datos estan correctos", "error");
        }
        else
        {
    
          $("#msg-error2").show();
          $(".list-errors2").html(respuesta);
        }
     borrardatalist2();
  mostrarProductos();
      }
    });
  });



 $(document.body).delegate(".delRowBtn", "click", function(){

   $(this).closest("tr").remove(); 
        calculartotal()  
           
  swal("Producto eliminado de la lista!", "Registro eliminado.", "success");

});


       

