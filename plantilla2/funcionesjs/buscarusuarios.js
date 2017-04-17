
$( document ).ready(function() {
  // Handler for .ready() called.mostrarDatos
mostrarDatos("");

 $("#buscar").keyup(function(){
buscar =  $("#buscar").val();

	mostrarDatos(buscar);

 });

 $("#btnbuscar").click(function(){

	mostrarDatos("");

 });

$("form").submit(function (event){

    event.preventDefault();

    $.ajax({
      url:$("form").attr("action"),
      type:$("form").attr("method"),
      data:$("form").serialize(),
      success:function(respuesta){
        alert(respuesta);
        if (respuesta ="Registro Guardado") {
           $('#myModalHorizontal').modal('hide');
        }
      }
    });
  });

$("select[name=cargo]").change(function(){
            $('input[name=seleccion]').val($(this).val());
 });

});
    


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
      +registros[i]["tipo_usuario"]+"</td><td>  <a href='"+registros[i]["rut"]+"' class='btn btn-warning' data-toggle='modal' data-target='#myModalHorizontal'>E</a>  <button class='btn btn-danger' type='button' value='"+registros[i]["rut"]+"'>X</button></td></tr>";
   

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
