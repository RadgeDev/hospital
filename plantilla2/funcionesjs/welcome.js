  $(document).on("ready", main);

  var estadocantabla = "";

  function main() {
      crear_tabla();

  }



  function crear_tabla() {

      $.ajax({
          url: "http://localhost/hospital/welcome/get_totalcompralimit",
          type: "POST",
          data: {},
          dataType: "json",
          success: function(respuesta) {
              filas = "";
              $.each(respuesta.obtener, function(key, item) {
                  filas += "<tr class='active' ><td >" + item.cod_compra + "</td><td>" + item.nombre_proveedor + "</td><td>" + item.fecha + "</td><td>" + item.total_compra + "</td></tr>";

              });
              $("#tbproductos tbody").html(filas);

          }

      });

  }