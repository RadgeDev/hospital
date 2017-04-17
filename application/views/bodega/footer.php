    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?= base_url()?>plantilla2/js/jquery.js"></script>
  <script type="javascript">

        $( document ).ready(function() {
            alert("hola");
            mostrarDatos("");
    function mostrarDatos(valor) {
    $.ajax({
        url: "http://localhost/hospital/man_usuarios/mostrar",
        type:"POST",
        data:{buscar:valor},
        success:function(respuesta){
            alert(respuesta);
        }

    });


}
});
    </script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url()?>plantilla2/js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->

   

</body>

</html>