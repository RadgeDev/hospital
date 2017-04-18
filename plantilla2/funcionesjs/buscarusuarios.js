
$( document ).ready(function() {
  // Handler for .ready() called.mostrarDatos
mostrarDatos(""); //muestra todo al iniciar el formualrio

 $("#buscar").keyup(function(){ //busca segun el valor del imput 
buscar =  $("#buscar").val();

	mostrarDatos(buscar);

 });

 $("#btnbuscar").click(function(){ //muestra todos los datos de la tabla

	mostrarDatos("");

 });

$("form").submit(function (event){

    event.preventDefault();

    $.ajax({
      url:$("form").attr("action"),
      type:$("form").attr("method"),
      data:$("form").serialize(),
      success:function(respuesta){
       // alert(respuesta);
       
        if (respuesta ="Registro Guardado") {
         
           $('#myModalHorizontal').modal('hide');//esconde formulario modal
           swal("Genial!", respuesta, "success");// a trves swift una libreria permite crear mensajes bonitos
           $('#usuarioGuardar').get(0).reset();//resetea  los campos del formulario
        }
              mostrarDatos("");
      }
    });
  });

$("select[name=cargo]").change(function(){
            $('input[name=seleccion]').val($(this).val());
 });

});
    

//creauna tabla de la base de datos segun consulta del buscar
function mostrarDatos(valor) {
    $.ajax({
        url: "http://localhost/hospital/man_usuarios/mostrar",
        type:"POST",
        data:{buscar:valor},
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
    event.preventDefault();
    rutsele = $(this).attr("href");
   nombressele = $(this).parent().parent().children("td:eq(1)").text();
   loginsele = $(this).parent().parent().children("td:eq(2)").text();
    passwordsele = $(this).parent().parent().children("td:eq(3)").text();
    tipousuariosele = $(this).parent().parent().children("td:eq(4)").text();
    alert(tipousuariosele);

    $("#selecrut").val(rutsele);
    $("#selecnombre").val(nombressele);
    $("#seleclogin").val(loginsele);
    $("#seleclave").val(passwordsele);
    $("#seleccargo").val(tipousuariosele);

  document.getElementById('cargo2').value= tipousuariosele;
  }); 

  $("body").on("click","#tablausuarios button",function(event){
    rutselec = $(this).attr("value");
    eliminar(rutselec); 
  });

