  $(document).on("ready", main);
  //$(document).on("ready", desabilitarcontroles);
    
function main(){
  $.ajaxPrefilter(function( options, original_Options, jqXHR ) {
    options.async = true;


    //largo del div editable
var textfields = document.getElementsByClassName("textfield"); 
for(i=0; i<textfields.length; i++){
    textfields[i].addEventListener("keypress", function(e) {
        if(this.innerHTML.length >= this.getAttribute("max")){
            e.preventDefault();
            return false;
        }
    }, false);
}
  });


//setTimeout("mostrarhora()",1000); 
numerofolio();


    function horaserver() {
      $.ajax({
       type: 'POST',
      url:"http://localhost/hospital/control_pedido/hora",
       timeout: 1000,
       success: function(data) {
          $("#hora").val(data); 
          window.setTimeout(horaserver, 1000);

       }
      });
     }
     horaserver();

function fechaserver() {
      $.ajax({
       type: 'POST',
      url:"http://localhost/hospital/control_pedido/fecha",
       success: function(data) {
       $( "#datetimepicker1" ).val(data);
        

       }
      });
     }
fechaserver();

 $("#msg-error").hide();
  $("#msg-error2").hide();
    $("#msg-error3").hide();
      $("#msg-bien").hide();

 }
$("#combo_tipocompra").change(function(){
		bodega = $(this).val();
		valorBuscar = $("input[name=busqueda]").val();
    valoroption = $("#cantidadpag").val();
		mostrarDatos(valorBuscar,1,valoroption,"cod_interno_prod",bodega);
	});

	$("input[name=busqueda]").keyup(function(){
		textobuscar = $(this).val();
		valoroption = $("#cantidadpag").val();
	    var valorcombo = $("#buscando").val();
	   	bodega = $("#combo_tipocompra").val();
		mostrarDatos(textobuscar,1,valoroption,valorcombo,bodega);
	});



	$("#cantidadpag").change(function(){
		valoroption = $(this).val();
		valorBuscar = $("input[name=busqueda]").val();
    bodega = $("#combo_tipocompra").val();
		mostrarDatos(valorBuscar,1,valoroption,"cod_interno_prod",bodega);
	});

function mostrarDatos(valorBuscar,pagina,cantidad,valorcombo,mibodega){

	$.ajax({
		url : "http://localhost/hospital/control_producto/mostrar2",
		type: "POST",
		data: {buscar:valorBuscar,nropagina:pagina,cantidad:cantidad,valorcombos:valorcombo,bodega:mibodega},
		dataType:"json",
		success:function(response){
			
			filas = "";
			$.each(response.obtener,function(key,item){
				filas+="<tr class='active' ><td >"+item.cod_interno_prod+"</td><td>"+item.codigo_barra+"</td><td>"+item.nombre+"</td><td> <button href='"+item.cod_interno_prod+"'  id='agregar' onclick='addProductotabla(this);'  class= 'addBtn  btn btn-success '  >Agregar</button></td></tr>";
			});

			$("#tbproductos tbody").html(filas);
	

		}
	});
}

  
/*
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
*/










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


/*


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
       `<td><button   id='eliminando'  class='btn btn-danger delRowBtn' >X</button></td>` +
    `</tr>`
  );
}
*/
function calculartotal() {
	 var theneto = 0;
    $("td:nth-child(8)").each(function () {
        var val = $(this).text().replace(" ", "").replace(",-", "");
        theneto += parseFloat(val);
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
     iva_venta = parseFloat(thenetodesc * (19/100));
      total =parseFloat( thenetodesc + iva_venta);
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


/*
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
/*
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

}*/






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

function solonumerosenteros(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "1234567890";
     

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
           
  swal("Producto eliminado de la lista!", "Registro eliminado.", "error");

});

function numerofolio(){
$.ajax({
		url : "http://localhost/hospital/control_pedido/devolverfolio",
		type: "POST",
		dataType:"json",
		success:function(response){
			
		
			var filas2="";
			$.each(response.folio,function(key,item){
     	filas2+=item.folio

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
       $("#tbproductos").find("input,button,textarea,select").attr("disabled", "disabled");

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


function guardardetalle(){


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


function limpiar(){
location.reload(true);
}




//crea reporte
function abrirEnPestana() {
  var codseleccionado =$("#folio").val();
  var url="http://localhost/hospital/control_reporte/report/"+codseleccionado+ ""
    var a = document.createElement("a");
    a.target = "_blank";
    a.href = url;
    a.click();
  }
 
$("#nombre , #lote , #nombre").on('input', function(evt) {
        var input = $(this);
        var start = input[0].selectionStart;
        $(this).val(function (_, val) {
          return val.toUpperCase();
        });
        input[0].selectionStart = input[0].selectionEnd = start;
      });

 
 



 function addProductotabla(obj) {
 codseleccionado = obj.getAttribute("href");

  $.ajax({
    url:"http://localhost/hospital/control_producto/editando",
    type:"POST",
    data:{id:codseleccionado},
    dataType:"json",
    success:function(respuesta){
      filas="";
   $.each(respuesta.obtener,function(key,item){
				filas+="<tr class='active' ><td >"+item.cod_interno_prod+"</td><td>"+item.codigo_barra+"</td><td>"+item.nombre+"</td><td><div contenteditable='true' class='textfield' max='10' style='color:blue;background:#E7F570;' onkeypress='return solonumerosenteros(event);' ></div></td><td> <button   id='eleminando' onclick=''  class= 'delRowBtn btn btn-danger '>X</button></td></tr>";
   
      });
    $("#tbpedidos tbody").append(filas);
    tabladuplicada();
    }

  });

}

function tabladuplicada(){
var seen = {};
$('#tbpedidos tr').each(function() {
    var txt = $(this).children("td:eq(0)").text();
    if (seen[txt]){
        $(this).remove();
           swal("Producto ya existe", "Producto ya esta agregado en el pedido.", "error");
     } else{
        seen[txt] = true;
     }
});
    }
