  $(document).on("ready", main);
  $(document).on("ready", desabilitarcontroles);
  var estadocantabla = "";

  function main() {
      $.ajaxPrefilter(function(options, original_Options, jqXHR) {
          options.async = true;


          //largo del div editable de la tabla pedidos
          var textfields = document.getElementsByClassName("textfield");
          for (i = 0; i < textfields.length; i++) {
              textfields[i].addEventListener("keypress", function(e) {
                  if (this.innerHTML.length >= this.getAttribute("max")) {
                      e.preventDefault();
                      return false;
                  }
              }, false);
          }
      });

      numerofolio();

      function fechaserver() {
          $.ajax({
              type: 'POST',
              url: "http://localhost/hospital/control_pedido/fecha",
              success: function(data) {
                  $("#datetimepicker1").val(data);

              }
          });
      }
      fechaserver();

      function horaserver() {
          $.ajax({
              type: 'POST',
              url: "http://localhost/hospital/control_pedido/hora",
              timeout: 1000,
              success: function(data) {
                  $("#hora").val(data);
                  window.setTimeout(horaserver, 1000);

              }
          });
      }
      horaserver();
      $("#msg-error").hide();
      $("#msg-error2").hide();
      $("#msg-error3").hide();
      $("#msg-bien").hide();


  }

  $("#combo_tipocompra").change(function() {
      bodega = $(this).val();
      valorBuscar = $("input[name=busqueda]").val();
      valoroption = $("#cantidadpag").val();
      mostrarDatos(valorBuscar, 1, valoroption, "cod_interno_prod", bodega);
  });

  $("input[name=busqueda]").keyup(function() {
      textobuscar = $(this).val();
      valoroption = $("#cantidadpag").val();
      var valorcombo = $("#buscando").val();
      bodega = $("#combo_tipocompra").val();
      mostrarDatos(textobuscar, 1, valoroption, valorcombo, bodega);
  });



  $("#cantidadpag").change(function() {
      valoroption = $(this).val();
      valorBuscar = $("input[name=busqueda]").val();
      bodega = $("#combo_tipocompra").val();
      mostrarDatos(valorBuscar, 1, valoroption, "cod_interno_prod", bodega);
  });

  function mostrarDatos(valorBuscar, pagina, cantidad, valorcombo, mibodega) {
      var tiempo = $("#combo_tiempo").val();
      if (tiempo == "0") {
          $('#tbproductos').children('tr:not(:first)').remove();
      } else {
          $.ajax({
              url: "http://localhost/hospital/control_producto/mostrar2",
              type: "POST",
              data: { buscar: valorBuscar, nropagina: pagina, cantidad: cantidad, valorcombos: valorcombo, bodega: mibodega },
              dataType: "json",
              success: function(response) {

                  filas = "";
                  $.each(response.obtener, function(key, item) {
                      filas += "<tr class='active' ><td >" + item.cod_interno_prod + "</td><td>" + item.codigo_barra + "</td><td>" + item.nombre + "</td><td> <button href='" + item.cod_interno_prod + "'  id='agregar' onclick='addProductotabla(this);'  class= 'addBtn  btn btn-success '  >Agregar</button></td></tr>";
                  });

                  $("#tbproductos tbody").html(filas);


              }
          });

      }
  }

  function soloLetras(e) {
      key = e.keyCode || e.which;
      tecla = String.fromCharCode(key).toLowerCase();
      letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
      especiales = "8-37-39-46";

      tecla_especial = false
      for (var i in especiales) {
          if (key == especiales[i]) {
              tecla_especial = true;
              break;
          }
      }

      if (letras.indexOf(tecla) == -1 && !tecla_especial) {
          return false;
      }
  }


  $(function() {
      $('#Agregandogrilla').click(function() {
          var minombre = $("#buscandoprod option[value='" + $('#buscarproducto').val() + "']").attr('value');
          var micodbarra = $("#buscandoprod option[value='" + $('#buscarproducto').val() + "']").attr('id');
          var micodigo = $("#buscandoprod option[value='" + $('#buscarproducto').val() + "']").attr('data-codigo');
          $("#codigoarticulo").val(micodigo);
          $("#codigobarra").val(micodbarra);
          $("#nombreproducto").val(minombre);
      });
  });

  function multiplicar() {
      n1 = $("#recepcionado").val();
      n2 = $("#valorunidad").val();
      if (n1 == "") {
          $("#recepcionado").val(0);
      } else if (n2 == "") {
          $("#valorunidad").val(0);
      }
      if (n1 == "" || n2 == "") {
          $("#valortotal").val(0);
      } else {
          total = parseInt(n1) * parseFloat(n2);
          $("#valortotal").val(parseFloat(total));
      }
  }



  function cerrarModal() {
      $('#ingresararticulo').get(0).reset(); //resetea  los campos del formulario
      $("#msg-error").hide();
      $("#msgerrorut").hide();
      $("#msg-error2").hide();

  }

  //evitar enter codigo de barras
  $('#buscarproducto').keypress(function(e) {
      if (e.which == 13) {
          return false;
      }
  });





  function desabilitarcontroles() {
      //combos
      $("#combo_tiempo").prop("disabled", true);
      $("#combo_tipocompra").prop("disabled", true);
      $("#buscando").prop("disabled", true);
      $("#combo_tipocompra").val('0');
      $("#combo_tiempo").val('0');
      $("#combo_depto").val('0');
      //botones
      $("#guardarpedido").prop("disabled", true);
      $("#limpiarpedido").prop("disabled", true);
      $("#imprimirpedido").prop("disabled", true);
      $("#cantidadpag").prop("disabled", true);

      //inputs
      $("#busqueda").prop("readonly", true);
      $("#micomentario").prop("readonly", true);
      //tablas
      $("#tbproductos").find("input,button,textarea,select").attr("disabled", "disabled");
      $("#tbpedidos").find("input,button,textarea,select,div").attr("disabled", "disabled").off('click');
      var editable_elements = document.querySelectorAll("[contenteditable=true]");
      for (var i = 0; i < editable_elements.length; i++)
          editable_elements[i].setAttribute("contenteditable", false);
      var filas = "";
      $("#tbpedidos tbody").html(filas);
      $("#tbproductos tbody").html(filas);
  }


  $("select[name=combo_depto]").change(function() {
      var porNombre = document.getElementsByName("combo_depto")[0].value;
      if (porNombre == 0) {
          $("#combo_tiempo").prop("disabled", true);
          $("#combo_tiempo").val('0');
          $("#combo_tipocompra").prop("disabled", true);
          $("#combo_tipocompra").val('0');
      } else {

          $("#combo_tiempo").prop("disabled", false);

      }
  });

  function desabilitarcontroles2() {
      //combos
      $("#combo_tiempo").prop("disabled", true);
      $("#combo_tipocompra").prop("disabled", true);
      $("#buscando").prop("disabled", true);

      //botones
      $("#guardarpedido").prop("disabled", true);
      $("#limpiarpedido").prop("disabled", true);
      $("#imprimirpedido").prop("disabled", true);
      $("#cantidadpag").prop("disabled", true);

      //inputs
      $("#busqueda").prop("readonly", true);
      $("#micomentario").prop("readonly", true);

  }


  $("select[name=combo_depto]").change(function() {
      var porNombre = document.getElementsByName("combo_depto")[0].value;
      if (porNombre == 0) {
          $("#combo_tiempo").prop("disabled", true);
          $("#combo_tiempo").val('0');
          $("#combo_tipocompra").prop("disabled", true);
          $("#combo_tipocompra").val('0');
      } else {

          $("#combo_tiempo").prop("disabled", false);

      }
  });

  $("select[name=combo_pedido]").change(function() {
      var valorcombopedido = document.getElementsByName("combo_pedido")[0].value;
      var tiempo = $("#combo_tiempo").val();
      if (tiempo == "1") {
          $.ajax({
              url: "http://localhost/hospital/control_bodega/editando",
              type: "POST",
              dataType: "json",
              data: { id: valorcombopedido },
              success: function(respuesta) {
                  $.each(respuesta.obtener, function(key, item) {
                      $("#recepcion").val(item.horario_recepcion);
                      $("#entrega").val(item.horario_entrega);
                  });
              }
          });
      } else if (tiempo == "2") {
          $("#recepcion").val("Primeros 5 dias habiles");
          $("#entrega").val("6 dia habil");
      } else {
          swal("Error", "Eliga un tiempo de pedidos EJ:semanal", "error");
          //  $('#tbproductos').children( 'tr:not(:first)' ).remove();
          filas = "";
          $("#tbproductos tbody").html(filas);
      }


      if (valorcombopedido == 0) {
          $("#buscando").prop("disabled", true);
          $("#buscando").val('nombre');
          $("#busqueda").prop("readonly", true);
          $("#busqueda").val("");
      } else {

          $("#buscando").prop("disabled", false);
          $("#busqueda").prop("readonly", false);
      }
      filas = "";
      $("#tbpedidos tbody").html(filas);
  });




  ///horario mensual
  $("select[name=combo_tiempo]").change(function() {
      var porNombre = document.getElementsByName("combo_tiempo")[0].value;
      if (porNombre == 0) {
          $("#combo_tipocompra").prop("disabled", true);
          $("#combo_tipocompra").val('0');
      } else if (porNombre == 2) {
          $("#recepcion").val("Primeros 5 dias habiles");
          $("#entrega").val("6 dia habil");
      } else {
          $("#combo_tipocompra").prop("disabled", false);
      }
  });



  $('#codigobarra').keypress(function(e) {
      if (e.which == 13) {
          return false;
      }
  });
  $('#nombre').keypress(function(e) {
      if (e.which == 13) {
          return false;
      }
  });


  function obtenerCorrelativo() {
      var porId = document.getElementById("cod_combo").value;
      if (porId == 0) {
          $("#codigo").val("");
      } else {

          var micorrelatico;
          var ultimocodigo;
          var entero;
          micod = $("#combocorrelativo").val();
          $.ajax({
              url: "http://localhost/hospital/control_producto/obtenercorrelativo",
              type: "POST",
              dataType: "json",
              data: { cod: micod },
              success: function(respuesta) {
                  $.each(respuesta.obtener, function(key, item) {
                      micorrelativo = item.correlativo;
                      ultimocodigo = item.ultimo_codigo;
                      // alert(ultimocodigo);
                      entero = parseInt(ultimocodigo);
                  });

                  var numero = entero + 1;
                  $("#codigo").val(micorrelativo + numero);
                  $("#ultimocorrelativo").val(numero);

              }
          });
      }
  }


  function solonumeros(e) {
      key = e.keyCode || e.which;
      tecla = String.fromCharCode(key).toLowerCase();
      letras = "1234567890.,";


      if (letras.indexOf(tecla) == -1) {
          return false;
      }
  }

  function solonumerosenteros(e) {
      key = e.keyCode || e.which;
      tecla = String.fromCharCode(key).toLowerCase();
      letras = "1234567890";


      if (letras.indexOf(tecla) == -1) {
          return false;
      }
  }


  $(document.body).delegate(".delRowBtn", "click", function() {

      $(this).closest("tr").remove();
      swal("Producto eliminado de la lista!", "Registro eliminado.", "error");
  });

  function numerofolio() {
      $.ajax({
          url: "http://localhost/hospital/control_pedido/devolverfolio",
          type: "POST",
          dataType: "json",
          success: function(response) {


              var filas2 = "";
              $.each(response.folio, function(key, item) {
                  filas2 += item.folio

              });


              nuevofolio = parseInt(filas2) + 1;
              $("#folio").val(nuevofolio);

          }
      });
  }

  function listarproductos() {
      var text2 = document.getElementById("buscarproducto"),
          element2 = document.getElementById("buscandoprod");
      var comprobar2 = ""


      if (element2.querySelector("option[value='" + text2.value + "']")) {
          comprobar2 = "bien";
      } else {
          comprobar2 = "mal";
      }


      if (comprobar2 === "bien") {
          $('#largeModal').modal('show');
      } else {
          $('#largeModal').modal('hide');
          $('#buscarproducto').val("");
          document.getElementById("buscarproducto").focus();
          swal("Error!", "Vuelva ingresar el producto articulo", "error");

      }
  }

  function guardarpedido() {

      numerofolio();

      var tipodeptocod = document.getElementsByName("combo_depto")[0].value;
      var deptonombre = $("#combo_depto option:selected").text();
      var hora = $("#hora").val();
      var fecha = $("#datetimepicker1").val();
      var comentarios = $("#micomentario").val();
      var nfolio = $("#folio").val();
      var tiempocod = document.getElementsByName("combo_tiempo")[0].value;
      var tiemponombre = $("#combo_tiempo option:selected").text();
      var pedidocod = document.getElementsByName("combo_pedido")[0].value;
      var pedidonombre = $("#combo_tipocompra option:selected").text();
      verificartablapedidos();
      if (tipodeptocod == 0) {
          swal("Error!", "Ingrese un Departamento", "error");
      } else if (tiempocod == 0) {
          swal("Error!", "Ingrese un Tiempo pedido", "error");
      } else if (pedidocod == 0) {
          swal("Error!", "Ingrese un Tipo Pedido", "error");
      } else if (hora === "") {
          swal("Error!", "No hay hora", "error");
      } else if (fecha === "") {
          swal("Error!", "No hay fecha", "error");
      } else if (nfolio === "") {
          swal("Error!", "N° Folio", "error");
      } else if (estadocantabla === "vacio") {
          swal("Error!", "Cantidad de pedido vacias", "error");
      } else {

          event.preventDefault();
          $.ajax({

              url: "http://localhost/hospital/control_pedido/guardarpedido",
              type: "POST",
              data: { minfolio: nfolio, mitipodeptocod: tipodeptocod, mideptonombre: deptonombre, mihora: hora, mifecha: fecha, mitiempocod: tiempocod, mitiemponombre: tiemponombre, mipedidocod: pedidocod, mipedidonombre: pedidonombre, micomentario: comentarios },
              dataType: "json",
              success: function(respuesta) {
                  console.log(respuesta);
                  guardardetalle();
                  $("#msg-error3").hide();
                  $("#msg-bien").show();
                  swal("Exito!", "Ingreso guardado.", "success");
                  window.location.hash = '#msg-bien';
                  $("#tbproductos").find("input,button,textarea,select").attr("disabled", "disabled");
                  $("#tbpedidos").find("input,button,textarea,select,div").attr("disabled", "disabled").off('click');
                  var editable_elements = document.querySelectorAll("[contenteditable=true]");
                  for (var i = 0; i < editable_elements.length; i++)
                      editable_elements[i].setAttribute("contenteditable", false);
                  desabilitarcontroles2();
                  $("#imprimirpedido").prop("disabled", false);
                  $("#combo_depto").prop("disabled", true);
                  $("#guardarpedido").prop("disabled", true);

              },
              error: function() {
                  console.log('error'); // solo ingresa a esta parte
                  $("#msg-error3").show();
                  $("#msg-bien").hide();
                  swal("Algo fallo!", "Intentelo mas tarde verifique su conexion.", "error");
                  window.location.hash = '#msg-error3';
              }
          });
      }
  }


  function guardardetalle() {
      alert("hola");
      var miJSON = "";
      var datostabla = { datos: [] };
      var obj = JSON.parse(JSON.stringify(datostabla));
      $("#tbpedidos tbody tr").each(function(index) {
          var micodinterno, micodbarra, minombre, micantidad;
          $(this).children("td").each(function(index2) {
              switch (index2) {
                  case 0:
                      micodinterno = $(this).text();
                      break;
                  case 1:
                      micodbarra = $(this).text();
                      break;
                  case 2:
                      minombre = $(this).text();
                      break;
                  case 3:
                      micantidad = $(this).text();
                      break;

              }

          })

          var nfolio = $("#folio").val();
          //  var obj = JSON.parse('[datostabla]');
          obj['datos'].push({ "folio": nfolio, "codinterno": micodinterno, "codbarra": micodbarra, "nombre": minombre, "cantidad": micantidad });

          //var miJSON = JSON.encode(obj);
          //alert(campo1 + ' - ' + campo2 + ' - ' + campo3);
      })

      $.post('http://localhost/hospital/control_pedido/guardardetalle', { sendData: JSON.stringify(obj) }, function(res) {
          console.log(res);
      }, "json");

  }


  function limpiar() {
      location.reload(true);
  }




  //crea reporte
  function abrirEnPestana() {
      var codseleccionado = $("#folio").val();
      var url = "http://localhost/hospital/control_reporte/report/" + codseleccionado + ""
      var a = document.createElement("a");
      a.target = "_blank";
      a.href = url;
      a.click();
  }

  $("#nombre , #lote , #nombre").on('input', function(evt) {
      var input = $(this);
      var start = input[0].selectionStart;
      $(this).val(function(_, val) {
          return val.toUpperCase();
      });
      input[0].selectionStart = input[0].selectionEnd = start;
  });






  function addProductotabla(obj) {
      codseleccionado = obj.getAttribute("href");
      $.ajax({
          url: "http://localhost/hospital/control_producto/editando",
          type: "POST",
          data: { id: codseleccionado },
          dataType: "json",
          success: function(respuesta) {
              filas = "";
              $.each(respuesta.obtener, function(key, item) {
                  filas += "<tr class='active' ><td >" + item.cod_interno_prod + "</td><td>" + item.codigo_barra + "</td><td>" + item.nombre + "</td><td><div contenteditable='true' class='textfield' max='10' style='color:blue;background:#E7F570;' onkeypress='return solonumerosenteros(event);' ></div></td><td> <button   id='eleminando' onclick=''  class= 'delRowBtn btn btn-danger '>X</button></td></tr>";

              });
              $("#tbpedidos tbody").append(filas);
              tabladuplicada();
          }

      });

  }

  function tabladuplicada() {
      var seen = {};
      $('#tbpedidos tr').each(function() {
          var txt = $(this).children("td:eq(0)").text();
          if (seen[txt]) {
              $(this).remove();
              swal("Producto ya existe", "Producto ya esta agregado en el pedido.", "error");
          } else {
              seen[txt] = true;
          }
      });
  }

  function cambiacontenidotabla() {
      var rowCount = $('#tbpedidos tr').length;
      if (rowCount > 1) {
          $("#guardarpedido").prop("disabled", false);
          $("#limpiarpedido").prop("disabled", false);
          $("#cantidadpag").prop("disabled", false);
          $("#micomentario").prop("readonly", false);
      } else {
          $("#guardarpedido").prop("disabled", true);
          $("#limpiarpedido").prop("disabled", true);
          $("#imprimirpedido").prop("disabled", true);
          $("#cantidadpag").prop("disabled", true);
          $("#micomentario").prop("readonly", true);
      }


  }
  $("#tbpedidos").bind("DOMSubtreeModified", function() {
      cambiacontenidotabla();
  });


  function bloqueosdias() {
      //hora
      $("#alerta").remove();
      var iniciopedido = new Date();
      (9, 40, 0);
      iniciopedido.setHours(00, 00, 0); // 5.30 pm
      var finpedido = new Date();
      finpedido.setHours(9, 40, 0); // 6.30 pm
      //fecha
      var midia = "";
      var date = $("#datetimepicker1").val();
      var dateParts = date.split("-");
      var date = new Date(dateParts[2], (dateParts[1] - 1), dateParts[0]);
      switch (date.getDay()) {
          case 1:
              midia = "lunes";
              break;
          case 2:
              midia = "martes";
              break;
          case 3:
              midia = "miercoles";
              break;
          case 4:
              midia = "jueves";
              break;
          case 5:
              midia = "viernes";
              break;
          default:
              midia = "nopermitir";
      } //fin switch
      var mihora = $("#hora").val();
      mihora = new Date();
      //bloqueo semanal por dia viernes a partir de las 9.40  y fines de semana
      if (midia == "nopermitir") {
          desabilitarcontroles();
          $("#combo_depto").prop("disabled", true);
          var div = $("<div id='alerta' class='alert alert-danger'  style='text-align:left;'><strong>¡Error!</strong>Su plazo de entrega a expirado.</div>");
          $("#box").append(div);

      } else if (mihora > finpedido && midia == "viernes") {
          desabilitarcontroles();
          $("#combo_depto").prop("disabled", true);
          var div = $("<div id='alerta' class='alert alert-danger'  style='text-align:left;'><strong>¡Error!</strong>Su plazo de entrega a expirado.</div>");
          $("#box").append(div);
      } else {
          $("#combo_depto").prop("disabled", false);
      }

  } //fin clase bloquear personal



  function bloqueoservicios() {
      //hora
      // var iniciopedido = new Date();(9,40,0);
      //iniciopedido.setHours(00,00,0); // 5.30 pm
      var finpedido = new Date();
      finpedido.setHours(12, 30, 0); // 6.30 pm
      //fecha
      var date = $("#datetimepicker1").val();
      var dateParts = date.split("-");
      var date = new Date(dateParts[2], (dateParts[1] - 1), dateParts[0]);
      switch (date.getDay()) {
          case 1:
              midia = "lunes";
              break;
          case 2:
              midia = "martes";
              break;
          case 3:
              midia = "miercoles";
              break;
          case 4:
              midia = "jueves";
              break;
          default:
              midia = "nopermitir";
      } //fin switch
      var mihora = $("#hora").val();
      mihora = new Date();
      var deptocod = document.getElementsByName("combo_depto")[0].value;
      //bloqueo semanal por dia viernes a partir de las 9.40  y fines de semana
      if (midia == "nopermitir" && deptocod == "1") {
          var div = $("<div id='alerta' class='alert alert-danger'  style='text-align:left;'><strong>¡Error!</strong>Su plazo de entrega a expirado.</div>");
          $("#box").append(div);
          $("#combo_depto").prop("disabled", true);
          desabilitarcontroles();
          $("#combo_depto").prop("disabled", true);
      } else if (mihora > finpedido && midia == "jueves" && deptocod == "1") {
          var div = $("<div id='alerta' class='alert alert-danger'  style='text-align:left;'><strong>¡Error!</strong>Su plazo de entrega a expirado.</div>");
          $("#box").append(div);
          desabilitarcontroles();
          $("#combo_depto").prop("disabled", true);

      } else {
          $("#combo_depto").prop("disabled", false);
      }

  } //fin clase bloquear personal


  function verificartablapedidos() {
      estadocantabla = "";
      $('#tbpedidos td div').each(function() {
          if (!$(this).text().trim().length) {
              $(this).css('border', '1px solid red');
              estadocantabla = "vacio";
          } else {
              $(this).css('border', '1px solid yellow');
              estadocantabla = "lleno";
          }
      });
  }



  //crea reporte
  function abrirEnPestana() {
      var codseleccionado = $("#folio").val();
      var url = "http://localhost/hospital/control_reporte/report_pedidos/" + codseleccionado + ""
      var a = document.createElement("a");
      a.target = "_blank";
      a.href = url;
      a.click();
  }