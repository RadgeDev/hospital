    $(document).on("ready", main);


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
       mostrarDatos("",1,10,"rut_proveedor");
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



function ajaxSearch()
{
    var input_data = $('#search_data').val();

    if (input_data.length === 0)
    {
        $('#suggestions').hide();
    }
    else
    {

  
        $.ajax({
            type: "POST",
            url: "http://localhost/hospital/control_compra_ingreso/autocomplete/",
            data: input_data,
            success: function (data) {
                // return success
                if (data.length > 0) {
                    $('#suggestions').show();
                    $('#autoSuggestionsList').addClass('auto_list');
                    $('#autoSuggestionsList').html(data);
                }
            }
         });

     }
 }
