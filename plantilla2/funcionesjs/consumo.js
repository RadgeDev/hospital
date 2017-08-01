$(document).on("ready", main);


function main() {

    $.ajaxPrefilter(function(options, original_Options, jqXHR) {
        options.async = true;
    });
    $("#msg-error").hide();
    $("body").on("click", ".paginacion li a", function(e) {
        e.preventDefault();
        valorhref = $(this).attr("href");
        bodega = document.getElementsByName("combo_pedido")[0].value;
        inicio = $("#fechainicio").val();
        fin = $("#fechafin").val();
        cantidad = $("#cantidadpag").val();
        mostrarDatos(bodega, valorhref, cantidad, inicio,fin);
    });

    $("#cantidadpag").change(function() {
      bodega = document.getElementsByName("combo_pedido")[0].value;
      inicio = $("#fechainicio").val();
      fin = $("#fechafin").val();
      cantidad = $("#cantidadpag").val();
      pagina="1";
      mostrarDatos(bodega, pagina, cantidad, inicio,fin);
    });
    }

function buscarmostrardatos(){
bodega = document.getElementsByName("combo_pedido")[0].value;
  inicio = $("#fechainicio").val();
  fin = $("#fechafin").val();
  cantidad = $("#cantidadpag").val();
  pagina="1";
 mostrarDatos(bodega, pagina, cantidad, inicio,fin);
}



function mostrarDatos(bodega, pagina, cantidad, inicio,fin) {

    $.ajax({
        url: "http://localhost/hospital/control_consumo/mostrar",
        type: "POST",
        data: { mibodega: bodega, mipagina: pagina, micantidad: cantidad, miinicio: inicio,mifin:fin },
        dataType: "json",
        success: function(response) {

            filas = "";
            $.each(response.obtener, function(key, item) {
                filas += "<tr class='active' ><td >" + item.ano + "</td><td>" + item.mes + "</td><td>" + item.cod_producto + "</td><td>" + item.nombre + "</td><td>" + item.nombrebodega + "</td><td> "  + item.totales + "</td></tr>";
            });

            $("#tbproductos tbody").html(filas);
            linkseleccionado = Number(pagina);
            //total registros
            totalregistros = response.totalregistros;
            //cantidad de registros por pagina
            cantidadregistros = response.cantidad;

            numerolinks = Math.ceil(totalregistros / cantidadregistros);
            paginador = "<ul class='pagination'>";
            if (linkseleccionado > 1) {
                paginador += "<li><a href='1'>&laquo;</a></li>";
                paginador += "<li><a href='" + (linkseleccionado - 1) + "' '>&lsaquo;</a></li>";

            } else {
                paginador += "<li class='disabled'><a href='#'>&laquo;</a></li>";
                paginador += "<li class='disabled'><a href='#'>&lsaquo;</a></li>";
            }
            //muestro de los enlaces 
            //cantidad de link hacia atras y adelante
            cant = 2;
            //inicio de donde se va a mostrar los links
            pagInicio = (linkseleccionado > cant) ? (linkseleccionado - cant) : 1;
            //condicion en la cual establecemos el fin de los links
            if (numerolinks > cant) {
                //conocer los links que hay entre el seleccionado y el final
                pagRestantes = numerolinks - linkseleccionado;
                //defino el fin de los links
                pagFin = (pagRestantes > cant) ? (linkseleccionado + cant) : numerolinks;
            } else {
                pagFin = numerolinks;
            }

            for (var i = pagInicio; i <= pagFin; i++) {
                if (i == linkseleccionado)
                    paginador += "<li class='active'><a href='javascript:void(0)'>" + i + "</a></li>";
                else
                    paginador += "<li><a href='" + i + "'>" + i + "</a></li>";
            }
            //condicion para mostrar el boton sigueinte y ultimo
            if (linkseleccionado < numerolinks) {
                paginador += "<li><a href='" + (linkseleccionado + 1) + "' >&rsaquo;</a></li>";
                paginador += "<li><a href='" + numerolinks + "'>&raquo;</a></li>";

            } else {
                paginador += "<li class='disabled'><a href='#'>&rsaquo;</a></li>";
                paginador += "<li class='disabled'><a href='#'>&raquo;</a></li>";
            }

            paginador += "</ul>";
            $(".paginacion").html(paginador);

        }
    });
}


function editandos(obj) {
    var codseleccionado = obj.getAttribute("href");
    var url = "http://localhost/hospital/control_reporte/report_salidas/" + codseleccionado + ""
    var a = document.createElement("a");
    a.target = "_blank";
    a.href = url;
    a.click();
}