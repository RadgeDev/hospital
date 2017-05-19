    $(document).on("ready", main);
   $(document).on("ready", mostrarProveedores);
   $(document).on("ready", mostrarProductos);
      $(document).on("ready", desabilitarcontroles);
    
function main(){
  setInterval(obtenerCorrelativo, 400);
var now = new Date();
$( "#datetimepicker1" ).datepicker({dateFormat:"dd-mm-yy"}).datepicker("setDate",new Date());

setTimeout("mostrarhora()",1000); 
numerofolio();
 $("#msg-error").hide();
  $("#msg-error2").hide();
    $("#msg-error3").hide();
      $("#msg-bien").hide();
  $("#lblneto").hide();
  var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("fechavencimiento")[0].setAttribute('min', today);
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

$("#fechavencimiento").html('fechatotal');
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
				filas2+='<option id="'+item.rut_proveedor+'" value="'+item.nombre_proveedor+'" />'+item.rut_proveedor+'';
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
  if (n1=="") {
 $("#recepcionado").val(0);
  }else if (n2==""){
   $("#valorunidad").val(0);	
  }
  if (n1==""||n2=="") {
  	  $("#valortotal").val(0);
  }else {
  total= parseInt(n1) * parseFloat(n2);
    $("#valortotal").val(parseFloat(total));
}
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
  var mifecha=$('#fechavencimiento').val();
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
    vencimiento:$('#fechavencimiento').val(),
    cantidad:$('#recepcionado').val(),
    valorunitario:$('#valorunidad').val(),
    valortotal:$('#valortotal').val(),
  });
  $("#tbproductos tbody").append(row);

    $('#ingresararticulo').get(0).reset();//resetea  los campos del formulario
   $('#largeModal').modal('hide');
    calculartotal();
  habilitando();
  
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
       `<td><button   id='eliminando'     class='btn btn-danger delRowBtn' >X</button></td>` +
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
  	$("#descuento").val(0);
 descuento=0;
  }else if (descuento>theneto) {
  	swal("Error", "El decuento es mayor al valor total", "error");
  	descuento=0;
      	$("#descuento").val(0);
  }

  thenetodesc=theneto-descuento;
     iva_venta = thenetodesc * (19/100);
      total = thenetodesc + iva_venta;
$("#valorfactura").val(theneto);
$("#neto").val(thenetodesc);
$("#iva").val(iva_venta);
$("#total").val(total);
var mivalor=$("#agregardesc").val();

if (mivalor=="desactivar") {
$("#descuento").prop("readonly",true);
$("#agregardesc").val("activar");
}else
{
$("#descuento").prop("readonly",false);
$("#agregardesc").val("desactivar");
}



if (theneto==thenetodesc) {
  $("#lblneto").hide();
}else{

  $("#lblneto").show();

}

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
$("#guardaringreso").prop("disabled",true);
$("#imprimiringreso").prop("disabled",true);
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
var valorfactura=$("#valorfactura").val();
if (valorfactura==0 || valorfactura==="") {
$("#neto").val(0);
$("#iva").val(0);
$("#total").val(0);
$("#descuento").val(0);
$("#guardaringreso").prop("disabled",true);
$("#agregardesc").prop("disabled",true);
$("#descuento").prop("readonly",true);
$("#Comentarios").prop("readonly",true);

}else{
$("#descuento").val(0);
$("#guardaringreso").prop("disabled",false);
$("#agregardesc").prop("disabled",false);
$("#descuento").prop("readonly",false);
$("#Comentarios").prop("readonly",false);

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
        calculartotal() ;
        habilitando() ;
           
  swal("Producto eliminado de la lista!", "Registro eliminado.", "success");

});

function numerofolio(){
$.ajax({
		url : "http://localhost/hospital/control_compra_ingreso/devolverfolio",
		type: "POST",
		dataType:"json",
		success:function(response){
			
		
			var filas2="";
			$.each(response.folio,function(key,item){
				filas2+=item.codcompra;
			});

          nuevofolio=parseInt(filas2) + 1;
         $("#folio").val(nuevofolio);
		}
			});	
}
 function listarproductos(){
     var text2 = document.getElementById("buscarproducto"),
         element2 = document.getElementById("buscandoprod");
        var comprobar2=""
        

      if(element2.querySelector("option[value='"+text2.value+"']")){
             comprobar2="bien";
           }
      else{
     	comprobar2="mal";
         } 


         if (comprobar2==="bien") {
        $('#largeModal').modal('show');
         }else{
         	 $('#largeModal').modal('hide');
         	 $('#buscarproducto').val("");
       document.getElementById("buscarproducto").focus();
      swal("Error!", "Vuelva ingresar el producto articulo", "error");
      
         }
       }

function guardaringreso() {

numerofolio();

var tipoingresocod=document.getElementsByName("combo_tipoingreso")[0].value;	
var tipoingresonombre = $("#combo_tipoingreso option:selected").text();
var ndocumento= $("#ndocumento").val();
var nfolio= $("#folio").val();
var tipocompracod=document.getElementsByName("combo_tipocompra")[0].value;	
var tipocompranombre = $("#combo_tipocompra option:selected").text();
var nombreproveedor= $("#misproveedores2 option[value='" + $('#proveedorrut').val() + "']").attr('value');
var rutproveedor= $("#misproveedores2 option[value='" + $('#proveedorrut').val() + "']").attr('id');
var proveedortexto= $("#proveedorrut").val();
var fecha= $("#datetimepicker1").val();
var hora= $("#hora").val();
var nombreproduct= $("#buscandoprod option[value='" + $('#buscarproducto').val() + "']").attr('value');
var codbarraproduct= $("#buscandoprod option[value='" + $('#buscarproducto').val() + "']").attr('id');
var correlativoprod=$("#buscandoprod option[value='" + $('#buscarproducto').val() + "']").attr('data-codigo');
var productotexto= $("#buscarproducto").val();
var comentarios= $("#Comentarios").val();
var descuento= $("#descuento").val();
var valorfactura= $("#valorfactura").val();
var neto= $("#neto").val();
var iva = $("#iva").val();
var total= $("#total").val(); 
var text = document.getElementById("proveedorrut"),
    element = document.getElementById("misproveedores2");

     var comprobar=""
   
   if(element.querySelector("option[value='"+text.value+"']")){
  comprobar="bien";
   }
    else{
     comprobar="mal";
    }
 
if (tipoingresocod==0) {
swal("Error!", "Ingrese un tipo de ingreso", "error");
}else if (ndocumento==="") {
swal("Error!", "Ingrese un N° documento", "error");
}else if (nfolio==="") {
swal("Error!", "Ingrese un N° Folio", "error");
}else if (tipocompracod==0) {
swal("Error!", "Ingrese un tipo compra", "error");
}else if (comprobar==="mal"||proveedortexto==="") {
swal("Error!", "Ingrese un proveedor", "error");
}else if (fecha==="") {
swal("Error!", "Ingrese un fecha", "error");
}else if (descuento===""||descuento<0) {
swal("Error!", "Ingrese un decuento valido", "error");
$("#descuento").val(0);
}else if (valorfactura===""||valorfactura==0) {
swal("Error!", "Ingrese un producto ala lista", "error");
}else if (total===""||total==0) {
swal("Error!", "Ingrese un producto ala lista", "error");
}else{
  event.preventDefault();
$.ajax({

    url:"http://localhost/hospital/control_compra_ingreso/guardaringreso",
    type:"POST",
    data:{minfolio:nfolio,mitipoingresocod:tipoingresocod,mitipoingresonombre:tipoingresonombre,mindocumento:ndocumento,minfolio:nfolio,mitipocompracod:tipocompracod,mitipocompranombre:tipocompranombre,minombreproveedor:nombreproveedor,mirutproveedor:rutproveedor,mifecha:fecha,minombreproduct:nombreproduct,micodbarraproduct:codbarraproduct,micorrelativoprod:correlativoprod,micomentarios:comentarios,midescuento:descuento,mineto:neto,miiva:iva,mitotal:total},
    dataType:"json",
    success:function(respuesta){
    	   guardardetalle();
         console.log(respuesta);
       $("#msg-error3").hide();
       $("#msg-bien").show();
       swal("Exito!", "Ingreso guardado.", "success");
       window.location.hash = '#msg-bien';
             desabilitarcontroles();
       $("#imprimiringreso").prop("disabled",false);
       $("#combo_tipoingreso").prop("disabled",true);

            },
           error:function(){
              console.log('error');// solo ingresa a esta parte
       $("#msg-error3").show();
       $("#msg-bien").hide();
       swal("Algo fallo!", "Intentelo mas tarde verifique su conexion.", "error");
       window.location.hash = '#msg-error3';
           }
       });
}
}

/*  $("#tbproductos tbody tr").each(function (index) 
        {
            var micodinterno, micodbarra, minombre,milote,mifechavenc,micantidad,mivalor,mitotal;
            $(this).children("td").each(function (index2) 
            {
                switch (index2) 
                {
                    case 0: micodinterno = $(this).text();
                            break;
                    case 1: micodbarra = $(this).text();
                            break;
                    case 2: minombre = $(this).text();
                            break;
                    case 3: milote = $(this).text();
                            break;
                    case 4: mifechavenc = $(this).text();
                            break;
                    case 5: micantidad = $(this).text();
                            break;
                    case 6: mivalor = $(this).text();
                            break;
                    case 7: mitotal = $(this).text();
                            break;
                }
               
            })
var datostabla={datos:[]};
         var obj = JSON.parse(JSON.stringify(datostabla));
         var nfolio= $("#folio").val();
         //  var obj = JSON.parse('[datostabla]');
              obj['datos'].push({"folio":nfolio,"codinterno":micodinterno,"codbarra":micodbarra,"nombre":minombre,"lote":milote,"fechavenc":mifechavenc,"cantidad":micantidad,"valor":mivalor,"total":mitotal});
 
var miJSON = JSON.encode(obj);
            //alert(campo1 + ' - ' + campo2 + ' - ' + campo3);
        })


    $.ajax({
    url:"http://localhost/hospital/control_compra_ingreso/datosdetalle",
    type:"POST",
    dataType:"json",
    data: miJSON ,
    success:function(respuesta){
   
  }
  });

*/

function guardardetalle(){

alert("entro");
var miJSON="";
var datostabla={datos:[]};
 var obj = JSON.parse(JSON.stringify(datostabla));
	$("#tbproductos tbody tr").each(function (index) 
        {
            var micodinterno, micodbarra, minombre,milote,mifechavenc,micantidad,mivalor,mitotal;
            $(this).children("td").each(function (index2) 
            {
                switch (index2) 
                {
                    case 0: micodinterno = $(this).text();
                            break;
                    case 1: micodbarra = $(this).text();
                            break;
                    case 2: minombre = $(this).text();
                            break;
                    case 3: milote = $(this).text();
                            break;
                    case 4: mifechavenc = $(this).text();
                            break;
                    case 5: micantidad = $(this).text();
                            break;
                    case 6: mivalor = $(this).text();
                            break;
                    case 7: mitotal = $(this).text();
                            break;
                }
               
            })

         var nfolio= $("#folio").val();
         //  var obj = JSON.parse('[datostabla]');
              obj['datos'].push({"folio":nfolio,"codinterno":micodinterno,"codbarra":micodbarra,"nombre":minombre,"lote":milote,"fechavenc":mifechavenc,"cantidad":micantidad,"valor":mivalor,"total":mitotal});
     
//var miJSON = JSON.encode(obj);
            //alert(campo1 + ' - ' + campo2 + ' - ' + campo3);
        })

$.post('http://localhost/hospital/control_compra_ingreso/guardardetalle', {sendData: JSON.stringify(obj)}, function(res) {
    console.log(res);
}, "json");
   
}




