  <!-- jQuery -->
    <script src="<?= base_url()?>plantilla2/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url()?>plantilla2/js/bootstrap.min.js"></script>
     <script type="text/javascript">

        $( document ).ready(function() {
  // Handler for .ready() called.mostrarDatos

 $("#buscar").keyup(function(){
buscar =  $("#buscar").val();
 mostrarDatos(buscar);

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
      html+="  <tr><td> "+registros[i]["rut"]+"</td><td>"+registros[i]["nombre"]+"</td><td>"+registros[i]["login"]+"</td><td>"+registros[i]["password"]+"</td><td>"+registros[i]["tipo_usuario"]+"</td> </tr>";
         

    };
          html+="</tbody> </table> ";
          $("#tablausuarios").html(html);                                          
        }

    });
}
</script>
    </body>

</html>