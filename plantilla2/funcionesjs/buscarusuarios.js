$( document ).ready(function() {
  // Handler for .ready() called.mostrarDatos
mostrarDatos("","rut"); //muestra todo al iniciar el formualrio
$("#msg-error").hide();


 $("#buscar").keyup(function(){ //busca segun el valor del imput 
buscar =  $("#buscar").val();

   var valores = $("#buscando").val();

  mostrarDatos(buscar,valores);

 });

 $("#btnbuscar").click(function(){ //muestra todos los datos de la tabla

  mostrarDatos("","rut");

 });


$("#cerrarmodal2").click(actualizar);
$("#cerrando").click(cerrarModal);

function cerrarModal() {
  $("#msg-error").hide();
    $("#msgerrorut").hide();
   $('#usuarioGuardar').get(0).reset();//resetea  los campos del formulario
}


$("#usuarioGuardar").submit(function (event){

    event.preventDefault();

    $.ajax({
      url:$("#usuarioGuardar").attr("action"),
      type:$("#usuarioGuardar").attr("method"),
      data:$("#usuarioGuardar").serialize(),
      success:function(respuesta){
       
        if (respuesta === "Registro Guardado") {
         
           $('#myModalHorizontal').modal('hide');//esconde formulario modal
           swal("Genial!", "Datos ingresados Correctamente", "success");// a trves swift una libreria permite crear mensajes bonitos
           $('#usuarioGuardar').get(0).reset();//resetea  los campos del formulario
        } else if (respuesta === "No se pudo guardar los datos") {
          swal("Error", "Error revise si los datos estan correctos", "error");
        }
        else
        {
    
          $("#msg-error").show();
          $(".list-errors").html(respuesta);
        }
             mostrarDatos("","rut");
      }
    });
  });


function actualizar(){

  $("#usuarioEditar").submit(function (event){
  
   event.preventDefault();
 });
  $.ajax({
    url:"http://localhost/hospital/man_usuarios/actualizar",
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
          mostrarDatos("","rut");
      }
    });
 
}


$("select[name=cargo]").change(function(){
            $('input[name=seleccion]').val($(this).val());
            $('input[name=seleccion2]').val($(this).val());
 });




});//fin de ready
    




    
    
//creauna tabla de la base de datos segun consulta del buscar
function mostrarDatos(valor,campo) {

    $.ajax({
        url: "http://localhost/hospital/man_usuarios/mostrar",
        type:"POST",
        data:{buscar:valor,campos:campo},
        success:function(respuesta){
           //alert(respuesta);
           var registros =eval(respuesta);
            html=" <table  class='table table-bordered table-hover table-striped'>";
            html+="                   <thead>";
            html+="                         <tr>";                    
            html+="                              <th>Rut</th>";
            html+="                              <th>Nombre</th>";
            html+="                              <th>Login</th>";
            html+="                              <th>Clave</th>";
            html+="                              <th>Tipo de usuario</th>";
            html+="                              <th>Accion</th>";
            html+="                          </tr>";
            html+="                    </thead>";
            html+="                    <tbody>";
                             
                            
                                 
                             
                            
      for (var i=0; i< registros.length; i++){
      html+="  <tr><td> "+registros[i]["rut"]+"</td><td>"
      +registros[i]["nombre"]+"</td><td>"
      +registros[i]["login"]+"</td><td>"
      +registros[i]["password"]+"</td><td>"
      +registros[i]["tipo_usuario"]+"</td><td>  <a href='"+registros[i]["rut"]+"' class='btn btn-warning' data-toggle='modal' data-target='#myModalEditar'>E</a>  <button class='btn btn-danger' type='button' value='"+registros[i]["rut"]+"'>X</button></td></tr>";
   

    };
          html+="</tbody> </table> ";
          $("#tablausuarios").html(html);                                          
        }

    });
} 
/*
$("body").on("click","#tablausuarios a",function(event)){
event.preventDefault();
idsele= $(this).attr("href");
nombresele =$(this).parent().parent().children("td:eq(1)").text();
});
*/
$("body").on("click","#tablausuarios a",function(event){
    $("#msg-error2").hide();
    event.preventDefault();
    rutsele = $(this).attr("href");
   nombressele = $(this).parent().parent().children("td:eq(1)").text();
   loginsele = $(this).parent().parent().children("td:eq(2)").text();
    passwordsele = $(this).parent().parent().children("td:eq(3)").text();
    tipousuariosele = $(this).parent().parent().children("td:eq(4)").text();
    $("#selecrut").val(rutsele);
    $("#selecnombre").val(nombressele);
    $("#seleclogin").val(loginsele);
    $("#seleclave2").val(passwordsele);
    $("#seleccion").val(tipousuariosele);
  document.getElementById('cargo').value= tipousuariosele;
  document.getElementById('seleccion2').value= tipousuariosele;
  desencriptar();
  }); 



  $("body").on("click","#tablausuarios button",function(event){

    selecrut = $(this).attr("value");
    nombressele = $(this).parent().parent().children("td:eq(1)").text();
   
swal({
  title: "Estas seguro que deseas eliminar?",
  text: "Quieres eliminar a: "+nombressele ,
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Si, deseo borrarlo!",
  closeOnConfirm: false
},
function(){
 eliminar(selecrut); 
  swal("Deleted!", "Registro eliminado.", "success");
});

  });






function eliminar(selecrut){
  $.ajax({
    url:"http://localhost/hospital/man_usuarios/eliminar",
    type:"POST",
    data:{id:selecrut},
    success:function(respuesta){

      if (respuesta =="Registro Eliminado" ) {
           swal("Genial!", respuesta, "success");// a trves swift una libreria permite crear mensajes bonitos
           
        }else{
          swal("Error", respuesta, "error");
        }
   mostrarDatos("","rut");
    }
  });

}

function validar(mirut){
 
  $.ajax({
    url:"http://localhost/hospital/man_usuarios/validar",
    type:"POST",
    data:{id:mirut},
    success:function(respuesta){
    if (respuesta ==="Rut existe" ) {
     $('#rut').val("");
    document.getElementById("rut").focus();
    swal("Error!", "Este rut ya esta registrado", "error");// a trves swift una libreria permite crear mensajes bonitos
           
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


function desencriptar() {
       var inputs = $('#seleclave2');
      var clave = $(inputs).val();

$.ajax({
    url:"http://localhost/hospital/man_usuarios/claves",
    type:"POST",
    data:{id:clave},
    success:function(respuesta){
    document.getElementById('seleclave').value = respuesta;
 }
  });
   

    }

