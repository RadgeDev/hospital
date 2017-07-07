  $(document).on("ready", main);

  var estadocantabla = "";

  function main() {
  crear_tabla();
  crear_tabla_pedidos();
  crear_tabla_salidas();
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
                  filas += "<tr class='active' ><td >" + item.cod_compra + "</td><td>" + item.tipo_compra_nombre + "</td><td>" + item.fecha + "</td><td>" + item.total_compra + "</td></tr>";

              });
              $("#tbclientes tbody").html(filas);

          }

      });

  }



  function crear_tabla_pedidos() {

      $.ajax({
          url: "http://localhost/hospital/welcome/get_totalpedidoslimit",
          type: "POST",
          data: {},
          dataType: "json",
          success: function(respuesta) {
              filas = "";
              $.each(respuesta.obtener, function(key, item) {
                  filas += "<tr class='active' ><td >" + item.folio + "</td><td>" + item.depto + "</td><td>" + item.nombre + "</td><td>" + item.fecha + "</td></tr>";

              });
              $("#tbpedidos tbody").html(filas);

          }

      });

  }



  function crear_tabla_salidas() {

      $.ajax({
          url: "http://localhost/hospital/welcome/get_totalsalidaslimit",
          type: "POST",
          data: {},
          dataType: "json",
          success: function(respuesta) {
              filas = "";
              $.each(respuesta.obtener, function(key, item) {
                  filas += "<tr class='active' ><td >" + item.cod_salida + "</td><td>" + item.nombre_salida + "</td><td>" + item.fecha + "</td><td>" + item.nombre_depto + "</td></tr>";

              });
              $("#tbsalidas tbody").html(filas);

          }

      });

  }