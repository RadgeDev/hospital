$(document).on("ready", main);
//  $(document).on("ready", mostrarProveedores);
$(document).on("ready", mostrarProductos);
  $(document).on("ready", desabilitarcontroles);

function main() {
  //setInterval(obtenerCorrelativo, 400);
  var now = new Date();
  $("#datetimepicker1").datepicker({ dateFormat: "dd-mm-yy" }).datepicker("setDate", new Date());

  setTimeout("mostrarhora()", 1000);
  numerofolio();


  $("#msg-error").hide();
  $("#msg-error2").hide();
  $("#msg-error3").hide();
  $("#msg-bien").hide();
  /*
$("#lblneto").hide();
var today = new Date().toISOString().split('T')[0];
document.getElementsByName("fechavencimiento")[0].setAttribute('min', today);*/
  $('#modal_pedidos').modal('hide');
  $('#largeModal').modal('show');



}

function mostrarhora() {
  momentoActual = new Date();
  hora = momentoActual.getHours();
  minuto = momentoActual.getMinutes();
  segundo = momentoActual.getSeconds();
  if (segundo < 10) {
    segundo = "0" + segundo
  }
  if (minuto < 10) {
    minuto = "0" + minuto
  }
  horaImprimible = hora + " : " + minuto + " : " + segundo;
  $("#hora").val(horaImprimible);
  setTimeout("mostrarhora()", 1000);
}



function mostrarfecha() {
  var d = new Date();

  var dia = d.getDate();
  var mes = ("0" + (d.getMonth() + 1));
  var anio = d.getFullYear();

  var fechatotal = dia + "/" + mes + "/" + anio;

  $("#fechavencimiento").html('fechatotal');
  alert(fechatotal);


}
function desabilitarcontroles() {
  $("#ndocumento").prop("readonly", true);
  $("#Comentarios").prop("readonly", true);
  $("#buscarproducto").prop("readonly", true);
  $("#combo_salida").prop("disabled", false);
  $("#combo_depto").prop("disabled", true);
  $("#Agregandogrilla").prop("disabled", true);
  $("#guardarsalida").prop("disabled", true);

}

$("select[name=combo_salida]").change(function () {
    var filas="";
  var salida = $("#combo_salida").val();
  if (salida == 0) {
    $("#combo_depto").prop("disabled", false);
    $("#combo_depto").val('0');
    $("#Agregandogrilla").prop("disabled", true);
    $("#buscarproducto").prop("readonly", true);
    $("#Comentarios").prop("readonly", true);
    $("#Comentarios").val("");
    $("#buscarproducto").val("");
    $("#tbproductos tbody").html(filas);

  }else if (salida == 1){
   $("#combo_depto").prop("disabled", false);
    $("#combo_depto").val('0');
    $("#Agregandogrilla").prop("disabled", true);
    $("#buscarproducto").prop("readonly", true);
    $("#buscarproducto").val("");
    $("#tbproductos tbody").html(filas);
  $("#Comentarios").prop("readonly", false);
    $("#Comentarios").val("");

  } else {
    $("#combo_depto").prop("disabled", true);
    $("#combo_depto").val('0');
    $("#Agregandogrilla").prop("disabled", false);
    $("#buscarproducto").prop("readonly", false);
    $("#tbproductos tbody").html(filas);
    $("#Comentarios").prop("readonly", false);
    $("#Comentarios").val("");
  }

});

$("select[name=combo_depto]").change(function () {
  var depto = $("#combo_depto").val();
  if (depto == 0) {

  } else {
    mostrarDatos(depto);
  }

});

function mostrarDatos(valorBuscar) {

  if (valorBuscar == "0") {
    $('#tbpedidos').children('tr:not(:first)').remove();
  } else {
    $.ajax({
      url: "http://localhost/hospital/control_salida/mostrarpedido",
      type: "POST",
      data: { buscar: valorBuscar },
      dataType: "json",
      success: function (response) {

        filas = "";
        $.each(response.obtener, function (key, item) {
          filas += "<tr class='active' ><td >" + item.depto + "</td><td>" + item.comentario + "</td><td>" + item.estado + "</td><td>" + item.fecha + "</td><td>" + item.hora + "</td><td><button href='" + item.folio + "'  type='button' onclick='Agregarpedidotabla(this);'  id='agregartabla'   class= '  btn btn-success '  >+</button></td><td> <button href='" + item.folio + "'  id='eliminar' onclick=''  class= 'addBtn  btn btn-danger '>X</button></td></tr>";
        });

        $("#tbpedidos tbody").html(filas);

      }
    });

  }
  $('#modal_pedidos').modal('show');

}




function Agregarpedidotabla(obj) {
  valorBuscar = obj.getAttribute("href");
  $('#npedido').val(valorBuscar);
  if (valorBuscar == "0") {
    $('#tbproductos').children('tr:not(:first)').remove();
  } else {
    $.ajax({
      url: "http://localhost/hospital/control_salida/cargartabla",
      type: "POST",
      data: { buscar: valorBuscar },
      dataType: "json",
      success: function (response) {

        filas = "";
        $.each(response.obtener, function (key, item) {
          filas += "<tr class='active tdcolordanger' ><td >" + item.cod_producto + "</td><td>" + item.nombre_prod + "</td><td>0</td><td>N/N</td><td>" + item.cantidad + "</td><td>0</td><td>0</td><td><button href='" + item.folio + "'  id='eliminar' onclick=''  class= 'addBtn delRowBtn  btn btn-danger '>X</button></td></tr>";
        });

        $("#tbproductos tbody").html(filas);


      }
    });

  }
  $('#modal_pedidos').modal('hide');

}

//evento click  en tabla productos obtene primer valor
$('#tbproductos').on('click', 'tr', function (e) {
  var values = $(this).find('td').map(function () {
    return $(this).text();
  });
  var opcion = document.getElementsByName("combo_salida")[0].value;
  /*switch (opcion) {

   case "4"://pedidos
   alert("aaaaaaaaaaaaa");
  //evita llamar a otoer evento del boton
  if (!$(e.target).closest('.delRowBtn').length) {
    valorcod = values[0]; // cod  td
    var cantpedido = values[4]; // cantidad td
    $("#cantped").empty();
    $("#cantped").append(cantpedido);
    if (valorcod == "0") {
      $('#tbproductos').children('tr:not(:first)').remove();
    } else {
      $.ajax({
        url: "http://localhost/hospital/control_salida/cargarlotesvenc",
        type: "POST",
        data: { buscar: valorcod },
        dataType: "json",
        success: function (response) {
          filas = "";
          $.each(response.obtener, function (key, item) {
            filas += "<tr class='active' ><td >  <input type='checkbox'  class='case' name='case[]' value=" + item.id + "></td><td >" + item.lote + "</td><td>" + item.cod_producto + "</td><td>" + item.nombre + "</td><td>" + item.fecha_vencimiento + "</td><td>" + item.precio + "</td><td>" + item.cantidad + "</td><td><div contenteditable='true' class='textfield' max='10' style='color:blue;background:#E7F570;' onkeypress='return solonumerosenteros(event);'></div></td></tr>";
          });

          $("#tblotes tbody").html(filas);


        }
      });

    }
    $('#modal_lotes').modal('show');
  } else {
    event.preventDefault(e);
  }
  break;

  default:*/
    //evita llamar a otoer evento del boton
  if (!$(e.target).closest('.delRowBtn').length) {
    valorcod = values[0]; // cod  td
    var cantpedido = values[4]; // cantidad td
    $("#cantped").empty();
    $("#cantped").append(cantpedido);
    if (valorcod == "0") {
      $('#tbproductos').children('tr:not(:first)').remove();
    } else {
      $.ajax({
        url: "http://localhost/hospital/control_salida/cargarlotes",
        type: "POST",
        data: { buscar: valorcod },
        dataType: "json",
        success: function (response) {
          filas = "";
          $.each(response.obtener, function (key, item) {
            filas += "<tr class='active' ><td >  <input type='checkbox'  class='case' name='case[]' value=" + item.id + "></td><td >" + item.lote + "</td><td>" + item.cod_producto + "</td><td>" + item.nombre + "</td><td>" + item.fecha_vencimiento + "</td><td>" + item.precio + "</td><td>" + item.cantidad + "</td><td><div contenteditable='true' class='textfield' max='10' style='color:blue;background:#E7F570;' onkeypress='return solonumerosenteros(event);'></div></td></tr>";
          });

          $("#tblotes tbody").html(filas);


        }
      });

    }
    $('#modal_lotes').modal('show');
  } else {
    event.preventDefault(e);
  }

});


//validar cheackbox
function agregarlotes() {
  mitotal = 0;
  var lotemayor = "";
  $("#tblotes td:nth-child(8)").each(function () {
    var val = $(this).text().replace(" ", "").replace(",-", "");
    if (val == "") {
      val = 0;
    }
    mitotal += parseInt(val);
  });
  //comparar columas stock y valor ingresado
  $('#tblotes  tr').each(function () {

    var cell3 = parseInt($(this).find("td:eq(6)").text());
    var cell4 = parseInt($(this).find("td:eq(7)").text());
    if (cell3 < cell4) {
      lotemayor = "mayor";
      return false;
    } else {
      lotemayor = "no";
    }

  });


  var final = mitotal;
  var checked = $("#tblotes input:checked").length > 0;

  if (final == "0") {
    swal("Error!", "Escriba una cantidad valida", "error");// a trves swift una libreria permite crear mensajes bonitos   

  } else if (lotemayor == "mayor") {
    swal("Error!", "Cantidad ingresada es  mayor que el stock lote", "error");// a trves swift una libreria permite crear mensajes bonitos    

  } else if (!checked) {
    swal("Error!", "Seleccione un lote", "error");// a trves swift una libreria permite crear mensajes bonitos    

  } else {

    cantidad = $("#cantped").text();
    var searchString = "";
    var values = "";
    $.each($("input[name='case[]']:checked"), function (index, value) {
      var data = $(this).parents('tr:eq(0)');
      if (index > 0)
        values += " ";

      values += "<tr class='active tdcolor' ><td>" + $(data).find('td:eq(2)').text() + "</td><td>" + $(data).find('td:eq(3)').text() + "</td><td>" + $(data).find('td:eq(1)').text() + "</td><td>" + $(data).find('td:eq(4)').text() + "</td><td>" + cantidad + "</td><td>" + $(data).find('td:eq(7)').text() + "</td><td>" + $(data).find('td:eq(5)').text() + "</td><td><button  id='eliminar'   class= 'addBtn delRowBtn   btn btn-danger '>X</button></td></tr>";
      searchString = $(data).find('td:eq(2)').text();

    });

    $("#tbproductos tr td:contains('" + searchString + "')").each(function () {
      if ($(this).text() == searchString) {
        $(this).parent().remove();
      }
    });
    $('#tbproductos tbody').append(values);

    $('#modal_lotes').modal('hide');
  }

}


//validar lotes
var contents = $('.textfield').html();
$('.textfield').blur(function () {
  if (contents != $(this).html()) {
    alert('Handler for .change() called.');
    contents = $(this).html();
  }
});
// cerrar modal
function cerrarModal() {
  $("#msg-error").hide();
  $("#msgerrorut").hide();
  $('#proveedorGuardar').get(0).reset();//resetea  los campos del formulario
  $('#formGuardar').get(0).reset();//resetea  los campos del formulario
}

//dejar estatico  el modal
$('#modal_pedidos').modal({
  backdrop: 'static',
  keyboard: false,
});

var Fn = {
  // Valida el rut con su cadena completa "XXXXXXXX-X"
  validaRut: function (rutCompleto) {
    if (!/^[0-9]+-[0-9kK]{1}$/.test(rutCompleto))
      return false;
    var tmp = rutCompleto.split('-');
    var digv = tmp[1];
    var rut = tmp[0];
    if (digv == 'K') digv = 'k';
    return (Fn.dv(rut) == digv);
  },
  dv: function (T) {
    var M = 0, S = 1;
    for (; T; T = Math.floor(T / 10))
      S = (S + T % 10 * (9 - M++ % 6)) % 11;
    return S ? S - 1 : 'k';
  }
}

function validarRut() {


  if (Fn.validaRut($("#rut").val())) {
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

function validar(mirut) {

  $.ajax({
    url: "http://localhost/hospital/control_proveedor/validar",
    type: "POST",
    data: { id: mirut },
    success: function (respuesta) {
      if (respuesta === "Rut existe") {
        $('#rut').val("");
        swal("Error!", "Este rut ya esta registrado", "error");// a trves swift una libreria permite crear mensajes bonitos       
        document.getElementById("rut").focus();
      } else {



      }

    }
  });

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

function solorut(e) {
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = "1234567890-";


  if (letras.indexOf(tecla) == -1) {
    return false;
  }
}







function mostrarProveedores() {
  $.ajax({
    url: "http://localhost/hospital/control_compra_ingreso/devolverarray",
    type: "POST",
    dataType: "json",
    success: function (response) {

      filas = "";
      filas2 = "";
      $.each(response.proveedor, function (key, item) {
        filas2 += '<option id="' + item.rut_proveedor + '" value="' + item.nombre_proveedor + '" />' + item.rut_proveedor + '';
      });

      var my_list2 = document.getElementById("misproveedores2");
      my_list2.innerHTML = filas2;
    }
  });

}

function cambiarlote() {

  $.ajax({
    url: "http://localhost/hospital/control_salida/lotes",
    type: "POST",
    dataType: "json",
    success: function (response) {


    }
  });

}


function mostrarProductos() {

  $.ajax({
    url: "http://localhost/hospital/control_compra_ingreso/devolverproductos",
    type: "POST",
    dataType: "json",
    success: function (response) {

      filas = "";
      $.each(response.misproductos, function (key, item) {
        filas += '<option id="' + item.codigo_barra + '" data-codigo="' + item.cod_interno_prod + '" value="' + item.nombre + '" /> STOCK ( ' + item.cantidad + ' )';
      });

      var my_list = document.getElementById("buscandoprod");
      my_list.innerHTML = filas;
    }
  });

}



function borrardatalist() {

  var parent = document.getElementById("misproveedores2");
  var childArray = parent.children;
  var cL = childArray.length;
  while (cL > 0) {
    cL--;
    parent.removeChild(childArray[cL]);
  }
}


function borrardatalist2() {

  var parent = document.getElementById("buscandoprod");
  var childArray = parent.children;
  var cL = childArray.length;
  while (cL > 0) {
    cL--;
    parent.removeChild(childArray[cL]);
  }
}


$(function () {
  $('#Agregandogrilla').click(function () {
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
  $('#ingresararticulo').get(0).reset();//resetea  los campos del formulario
  $("#msg-error").hide();
  $("#msgerrorut").hide();
  $("#msg-error2").hide();

}

//evitar enter codigo de barras
$('#buscarproducto').keypress(function (e) {
  if (e.which == 13) {
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


*/





///guardar
$("select[name=cod_combo]").change(function () {
  $('input[name=combocorrelativo]').val($(this).val());
  var varieble = $("#combocorrelativo").val();
  if (varieble === 'Elige una opcion') {
    $("#combocorrelativo").val("");
  }
});

$("select[name=medida]").change(function () {
  $('input[name=seleccion]').val($(this).val());
  var varieble = $("#seleccion").val();
  if (varieble === 'Seleccione una opcion') {
    $("#seleccion").val("");
  }

});

$('#codigobarra').keypress(function (e) {
  if (e.which == 13) {
    return false;
  }
});
$('#nombre').keypress(function (e) {
  if (e.which == 13) {
    return false;
  }
});


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

    $("#tbproductos td:nth-child(2)").each(function () {
                theneto = 0;
                var val = $(this).text().replace(" ", "").replace(",-", "");
                theneto += parseFloat(val);
                desc = $("#descuento").val();
                if ($("#cod_prevision").val() >= 4) {
                    i = i + 1;

                    midesc = parseFloat(theneto);
                    $('#second_table tr:nth-child(' + i + ') td:nth-child(3)').text(midesc.toFixed(0));
                }
                else {
                    i = i + 1;

                    midesc = parseFloat(theneto * (desc / 100));
                    $('#second_table tr:nth-child(' + i + ') td:nth-child(3)').text(midesc.toFixed(0));
                }
            });

$(document.body).delegate(".delRowBtn", "click", function () {

  $(this).closest("tr").remove();


});

function numerofolio() {
  $.ajax({
    url: "http://localhost/hospital/control_salida/devolverfolio",
    type: "POST",
    dataType: "json",
    success: function (response) {


      var filas2 = "";
      $.each(response.folio, function (key, item) {
        filas2 += item.codsalida;

      });


      nuevofolio = parseInt(filas2) + 1;
      $("#nsalida").val(nuevofolio);

    }
  });
}

function listarproductos() {
  var text2 = document.getElementById("buscarproducto"),
    element2 = document.getElementById("buscandoprod");
  var nombreproduct = $("#buscandoprod option[value='" + $('#buscarproducto').val() + "']").attr('value');
  var correlativoprod = $("#buscandoprod option[value='" + $('#buscarproducto').val() + "']").attr('data-codigo');

  var comprobar2 = ""


  if (element2.querySelector("option[value='" + text2.value + "']")) {
    comprobar2 = "bien";

  }
  else {
    comprobar2 = "mal";
  }


  if (comprobar2 === "bien") {
    $.ajax({
      url: "http://localhost/hospital/control_salida/editando",
      type: "POST",
      data: { buscar: correlativoprod },
      dataType: "json",
      success: function (response) {

        filas = "";
        $.each(response.obtener, function (key, item) {
          filas += "<tr class='active tdcolordanger' ><td >" + item.cod_interno_prod + "</td><td>" + item.nombre + "</td><td>0</td><td>N/N</td><td>0</td><td>0</td><td>0</td><td><button href='" + item.folio + "'  id='eliminar' onclick=''  class= 'addBtn delRowBtn  btn btn-danger '>X</button></td></tr>";
        });

        $("#tbproductos tbody").append(filas);


      }
    });



  } else {

    document.getElementById("buscarproducto").focus();
    swal("Error!", "Vuelva ingresar el producto articulo", "error");

  }
}

function guardarsalida() {
  numerofolio();
  var tiposalidacod = document.getElementsByName("combo_salida")[0].value;
  var tiposalidanombre = $("#combo_salida option:selected").text();
  var npedido = $("#npedido").val();
  var nsalida = $("#nsalida").val();
  var tipodeptocod = document.getElementsByName("combo_depto")[0].value;
  var tipodeptonombre = $("#combo_depto option:selected").text();
  var fecha = $("#datetimepicker1").val();
  var hora = $("#hora").val();
  var comentarios = $("#Comentarios").val();

  var opcion = document.getElementsByName("combo_salida")[0].value;
  switch (opcion) {

    case "1"://pedidos
      if (tiposalidacod == 0) {
        swal("Error!", "Ingrese un tipo de salida", "error");
      } else if (nsalida === "") {
        swal("Error!", "Ingrese un N° Folio", "error");
      } else if (tipodeptocod == 0) {
        swal("Error!", "Ingrese un Depto", "error");
      } else if (fecha === "") {
        swal("Error!", "Ingrese un fecha", "error");
      } else {
        event.preventDefault();
        $.ajax({

          url: "http://localhost/hospital/control_salida/guardarsalida",
          type: "POST",
          data: { minsalida: nsalida, minpedido: npedido, mitiposalidacod: tiposalidacod, mitiposalidanombre: tiposalidanombre, mitipodeptocod: tipodeptocod, mitipodeptonombre: tipodeptonombre, mifecha: fecha, micomentario: comentarios },
          dataType: "json",
          success: function (respuesta) {
            guardardetalle();
            console.log(respuesta);
            $("#msg-error3").hide();
            $("#msg-bien").show();
            swal("Exito!", "Ingreso guardado.", "success");
            window.location.hash = '#msg-bien';
            desabilitarcontroles();
            $("#imprimirsalida").prop("disabled", false);
            $("#combo_salida").prop("disabled", true);
            $("#tbproductos").find("input,button,textarea,select").attr("disabled", "disabled");

          },
          error: function () {
            console.log('error');// solo ingresa a esta parte
            $("#msg-error3").show();
            $("#msg-bien").hide();
            swal("Algo fallo!", "Intentelo mas tarde verifique su conexion.", "error");
            window.location.hash = '#msg-error3';
          }
        });
      }
      break;

    case "2"://ajuste inventario
      if (tiposalidacod == 0) {
        swal("Error!", "Ingrese un tipo de salida", "error");
      } else if (nsalida === "") {
        swal("Error!", "Ingrese un N° Folio", "error");
      } else if (fecha === "") {
        swal("Error!", "Ingrese un fecha", "error");
      } else {
        event.preventDefault();
        $.ajax({

          url: "http://localhost/hospital/control_salida/guardarajusteinventario",
          type: "POST",
          data: { minsalida: nsalida, minpedido: npedido, mitiposalidacod: tiposalidacod, mitiposalidanombre: tiposalidanombre, mitipodeptocod: tipodeptocod, mitipodeptonombre: tipodeptonombre, mifecha: fecha, micomentario: comentarios },
          dataType: "json",
          success: function (respuesta) {
        guardardetalledirecto();
            console.log(respuesta);
            $("#msg-error3").hide();
            $("#msg-bien").show();
            swal("Exito!", "Ingreso guardado.", "success");
            window.location.hash = '#msg-bien';
            desabilitarcontroles();
            $("#imprimirsalida").prop("disabled", false);
            $("#combo_salida").prop("disabled", true);
            $("#tbproductos").find("input,button,textarea,select").attr("disabled", "disabled");

          },
          error: function () {
            console.log('error');// solo ingresa a esta parte
            $("#msg-error3").show();
            $("#msg-bien").hide();
            swal("Algo fallo!", "Intentelo mas tarde verifique su conexion.", "error");
            window.location.hash = '#msg-error3';
          }
        });
      }
      break;

    case "3"://Salida directa
      if (tiposalidacod == 0) {
        swal("Error!", "Ingrese un tipo de salida", "error");
      } else if (nsalida === "") {
        swal("Error!", "Ingrese un N° Folio", "error");
      } else if (fecha === "") {
        swal("Error!", "Ingrese un fecha", "error");
      } else {
        event.preventDefault();
        $.ajax({

          url: "http://localhost/hospital/control_salida/guardarajusteinventario",
          type: "POST",
          data: { minsalida: nsalida, minpedido: npedido, mitiposalidacod: tiposalidacod, mitiposalidanombre: tiposalidanombre, mitipodeptocod: tipodeptocod, mitipodeptonombre: tipodeptonombre, mifecha: fecha, micomentario: comentarios },
          dataType: "json",
          success: function (respuesta) {
        guardardetalledirecto();
            console.log(respuesta);
            $("#msg-error3").hide();
            $("#msg-bien").show();
            swal("Exito!", "Ingreso guardado.", "success");
            window.location.hash = '#msg-bien';
            desabilitarcontroles();
            $("#imprimirsalida").prop("disabled", false);
            $("#combo_salida").prop("disabled", true);
            $("#tbproductos").find("input,button,textarea,select").attr("disabled", "disabled");

          },
          error: function () {
            console.log('error');// solo ingresa a esta parte
            $("#msg-error3").show();
            $("#msg-bien").hide();
            swal("Algo fallo!", "Intentelo mas tarde verifique su conexion.", "error");
            window.location.hash = '#msg-error3';
          }
        });
      }
      break;

      case "4"://Salida directa
       if (tiposalidacod == 0) {
        swal("Error!", "Ingrese un tipo de salida", "error");
      } else if (nsalida === "") {
        swal("Error!", "Ingrese un N° Folio", "error");
      } else if (fecha === "") {
        swal("Error!", "Ingrese un fecha", "error");
      } else {
        event.preventDefault();
        $.ajax({

          url: "http://localhost/hospital/control_salida/guardarajusteinventario",
          type: "POST",
          data: { minsalida: nsalida, minpedido: npedido, mitiposalidacod: tiposalidacod, mitiposalidanombre: tiposalidanombre, mitipodeptocod: tipodeptocod, mitipodeptonombre: tipodeptonombre, mifecha: fecha, micomentario: comentarios },
          dataType: "json",
          success: function (respuesta) {
        guardardetalledirecto();
            console.log(respuesta);
            $("#msg-error3").hide();
            $("#msg-bien").show();
            swal("Exito!", "Ingreso guardado.", "success");
            window.location.hash = '#msg-bien';
            desabilitarcontroles();
            $("#imprimirsalida").prop("disabled", false);
            $("#combo_salida").prop("disabled", true);
            $("#tbproductos").find("input,button,textarea,select").attr("disabled", "disabled");

          },
          error: function () {
            console.log('error');// solo ingresa a esta parte
            $("#msg-error3").show();
            $("#msg-bien").hide();
            swal("Algo fallo!", "Intentelo mas tarde verifique su conexion.", "error");
            window.location.hash = '#msg-error3';
          }
        });
      }
       break;
    default:  swal("Algo fallo!", "Eliga tipo de salida.", "error");
  }

}


function guardardetalle() {
  var miJSON = "";
  var datostabla = { datos: [] };
  var obj = JSON.parse(JSON.stringify(datostabla));
  $("#tbproductos tbody tr").each(function (index) {
    var micodinterno, minombre, milote, mifechavenc, micantidad, mivalor, micantentreg;
    $(this).children("td").each(function (index2) {
      switch (index2) {
        case 0: micodinterno = $(this).text();
          break;
        case 1: minombre = $(this).text();
          break;
        case 2: milote = $(this).text();
          break;
        case 3: mifechavenc = $(this).text();
          break;
        case 4: micantidad = $(this).text();
          break;
        case 5: micantentreg = $(this).text();
          break;
        case 6: mivalor = $(this).text();
          break;

      }

    })
  var tipodeptocod = document.getElementsByName("combo_depto")[0].value;
  var tipodeptonombre = $("#combo_depto option:selected").text();
  var nsalida = $("#nsalida").val();
    var actfecha= $("#datetimepicker1").val();
    //  var obj = JSON.parse('[datostabla]');
    obj['datos'].push({ "nsalida": nsalida,"fecha":actfecha,"cod_depto":tipodeptocod,"nom_depto":tipodeptonombre, "codinterno": micodinterno, "nombre": minombre, "lote": milote, "fechavenc": mifechavenc, "cantidad": micantidad, "valor": mivalor, "entrega": micantentreg });

    //var miJSON = JSON.encode(obj);
    //alert(campo1 + ' - ' + campo2 + ' - ' + campo3);
  })

  $.post('http://localhost/hospital/control_salida/guardardetalle', { sendData: JSON.stringify(obj) }, function (res) {
    console.log(res);
  }, "json");

}

function guardardetalledirecto() {
  var miJSON = "";
  var datostabla = { datos: [] };
  var obj = JSON.parse(JSON.stringify(datostabla));
  $("#tbproductos tbody tr").each(function (index) {
    var micodinterno, minombre, milote, mifechavenc, micantidad, mivalor, micantentreg;
    $(this).children("td").each(function (index2) {
      switch (index2) {
        case 0: micodinterno = $(this).text();
          break;
        case 1: minombre = $(this).text();
          break;
        case 2: milote = $(this).text();
          break;
        case 3: mifechavenc = $(this).text();
          break;
        case 4: micantidad = $(this).text();
          break;
        case 5: micantentreg = $(this).text();
          break;
        case 6: mivalor = $(this).text();
          break;

      }

    })
  var tiposalidacod = document.getElementsByName("combo_salida")[0].value;
  var tiposalidanombre = $("#combo_salida option:selected").text();
    var nsalida = $("#nsalida").val();
    var actfecha= $("#datetimepicker1").val();
    //  var obj = JSON.parse('[datostabla]');
    obj['datos'].push({ "nsalida": nsalida,"fecha":actfecha,"tipo_salida":tiposalidacod,"salida_nombre":tiposalidanombre, "codinterno": micodinterno, "nombre": minombre, "lote": milote, "fechavenc": mifechavenc, "cantidad": micantidad, "valor": mivalor, "entrega": micantentreg });

    //var miJSON = JSON.encode(obj);
    //alert(campo1 + ' - ' + campo2 + ' - ' + campo3);
  })

  $.post('http://localhost/hospital/control_salida/guardardetalledirecto', { sendData: JSON.stringify(obj) }, function (res) {
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

$("#nombre , #lote , #nombre").on('input', function (evt) {
  var input = $(this);
  var start = input[0].selectionStart;
  $(this).val(function (_, val) {
    return val.toUpperCase();
  });
  input[0].selectionStart = input[0].selectionEnd = start;
});