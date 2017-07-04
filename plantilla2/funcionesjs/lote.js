$(document).on("ready", main);


function main() {

    $.ajaxPrefilter(function(options, original_Options, jqXHR) {
        options.async = true;
    });
    mostrarDatos("", 1, 10, "nombre");
    $("#msg-error").hide();


    $("input[name=busqueda]").keyup(function() {
        textobuscar = $(this).val();
        valoroption = $("#cantidadpag").val();
        var valorcombo = document.getElementsByName("buscando")[0].value;
        mostrarDatos(textobuscar, 1, valoroption, valorcombo);
    });



    $("body").on("click", ".paginacion li a", function(e) {
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = document.getElementsByName("combo_stock")[0].value;
        valoroption = $("#cantidadpag").val();
        mostrarDatos2(valorBuscar, valorhref, valoroption, "cod_interno_prod");
    });

    $("#cantidadpag").change(function() {
        valoroption = $(this).val();
        valorBuscar = document.getElementsByName("combo_stock")[0].value;
        mostrarDatos2(valorBuscar, 1, valoroption, "cod_interno_prod");
    });
}
$("select[name=combo_stock]").change(function() {
    valoroption = $("#cantidadpag").val();
    valorBuscar = document.getElementsByName("combo_stock")[0].value;
    mostrarDatos2(valorBuscar, 1, valoroption, "cod_interno_prod");
});

function mostrarDatos(valorBuscar, pagina, cantidad, valorcombo) {

    $.ajax({
        url: "http://localhost/hospital/control_lote/mostrar",
        type: "POST",
        data: { buscar: valorBuscar, nropagina: pagina, cantidad: cantidad, valorcombos: valorcombo },
        dataType: "json",
        success: function(response) {

            filas = "";
            $.each(response.obtener, function(key, item) {
                filas += "<tr class='active' ><td >" + item.id + "</td><td>" + item.lote + "</td><td>" + item.cod_producto + "</td><td>" + item.nombre + "</td><td>" + item.fecha_vencimiento + "</td><td>" + item.cantidad + "</td><td>" + item.precio + "</td><td>" + item.nombre_proveedor + "</td><td>" + item.estado + "</td></tr>";
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

function entrefechas() {
    valoroption = $("#cantidadpag").val();
    valorfecha = $("#fechainicio").val();
    valorfecha2 = $("#fechafin").val();
    mostrarfechas(valorfecha, 1, valoroption, valorfecha2);
}

function mostrarfechas(valorBuscar, pagina, cantidad, valorcombo) {

    $.ajax({
        url: "http://localhost/hospital/control_lote/mostrarfecha",
        type: "POST",
        data: { buscar: valorBuscar, nropagina: pagina, cantidad: cantidad, valorcombos: valorcombo },
        dataType: "json",
        success: function(response) {

            filas = "";
            $.each(response.obtener, function(key, item) {
                filas += "<tr class='active' ><td >" + item.id + "</td><td>" + item.lote + "</td><td>" + item.cod_producto + "</td><td>" + item.nombre + "</td><td>" + item.fecha_vencimiento + "</td><td>" + item.cantidad + "</td><td>" + item.precio + "</td><td>" + item.nombre_proveedor + "</td><td>" + item.estado + "</td></tr>";
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

function mostrarDatos2(valorBuscar, pagina, cantidad, valorcombo) {
    $("#tbproductos tbody").html("");
    $.ajax({
        url: "http://localhost/hospital/control_lote/mostrar2",
        type: "POST",
        data: { buscar: valorBuscar, nropagina: pagina, cantidad: cantidad, valorcombos: valorcombo },
        dataType: "json",
        success: function(response) {

            filas = "";
            var color = "";
            var colores = document.getElementsByName("combo_stock")[0].value;
            if (colores == "1") {
                color = "red";
            } else if (colores == "2") {
                color = "#C8670D";
            } else if (colores == "3") {
                color = "green";
            } else {
                color = "black";
            }


            $.each(response.obtener, function(key, item) {
                filas += "<tr class='active'style='color:" + color + ";font-weight:bold;' ><td >" + item.cod_interno_prod + "</td><td>" + item.codigo_barra + "</td><td>" + item.cod_bodega + "</td><td>" + item.nombre + "</td><td>" + item.cantidad +
                    "</td><td>" + item.stock_critico + "</td><td>" + item.stock_minimo +
                    "</td><td>" + item.stock_maximo +
                    "</td></tr>";
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
            $(".paginacion").html("");
            $(".paginacion").html(paginador);

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

function solonumeros(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "1234567890.,";


    if (letras.indexOf(tecla) == -1) {
        return false;
    }
}




function exportarexcel() {


    var miJSON = "";
    var datostabla = { datos: [] };
    var obj = JSON.parse(JSON.stringify(datostabla));
    $("#tbclientes tbody tr").each(function(index) {
        var micodinterno, micodbarra, micodbodega, minombre, micantidad, miprecio, miunidad;
        $(this).children("td").each(function(index2) {
            switch (index2) {
                case 0:
                    micodinterno = $(this).text();
                    break;
                case 1:
                    micodbarra = $(this).text();
                    break;
                case 2:
                    micodbodega = $(this).text();
                    break;
                case 3:
                    minombre = $(this).text();
                    break;
                case 4:
                    micantidad = $(this).text();
                    break;
                case 5:
                    miprecio = $(this).text();
                    break;
                case 6:
                    miunidad = $(this).text();
                    break;

            }

        })


        //  var obj = JSON.parse('[datostabla]');
        obj['datos'].push({ "cod_interno_prod": micodinterno, "codigo_barra": micodbarra, "nombre": minombre, "cantidad": micantidad, "precio": miprecio, "cod_bodega": micodbodega, "unidad_medida": miunidad });

        //var miJSON = JSON.encode(obj);
        //alert(campo1 + ' - ' + campo2 + ' - ' + campo3);
    })
    var url = "http://localhost/hospital/control_lote/excel"
    $.post(url, { sendData: JSON.stringify(obj) }, function(data) {
        var $a = $("<a>");
        $a.attr("href", data.file);
        $("body").append($a);
        var date = new Date();
        var dia = date.getDate();
        var mes = ("0" + (date.getMonth() + 1));
        var anio = date.getFullYear();
        var fechatotal = dia + "/" + mes + "/" + anio;
        var time = date.toLocaleTimeString();
        $a.attr("download", "Reporte Productos " + fechatotal + ' ' + time + ".xls");
        $a[0].click();
        $a.remove();
    }, "json");

}



//crea reporte
function reporte_bodega_min() {
    var valorcombobodegas = document.getElementsByName("combo_bodegas")[0].value;

    $.ajax({
        url: "http://localhost/hospital/control_lote/reportebodegaminimo",
        type: "POST",
        data: { codigo: valorcombobodegas },
        dataType: "json",
        success: function(data) {
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            var date = new Date();
            var dia = date.getDate();
            var mes = ("0" + (date.getMonth() + 1));
            var anio = date.getFullYear();
            var fechatotal = dia + "/" + mes + "/" + anio;
            var time = date.toLocaleTimeString();
            var bodega = $("#combo_bodegas option:selected").text();
            $a.attr("download", "Reporte Stock Minimo Bodega " + bodega + ' ' + fechatotal + ' ' + time + ".xls");
            $a[0].click();
            $a.remove();


        }
    });
}

//crea reporte
function reporte_bodega_cri() {
    var valorcombobodegas = document.getElementsByName("combo_bodegas")[0].value;

    $.ajax({
        url: "http://localhost/hospital/control_lote/reportebodegacritico",
        type: "POST",
        data: { codigo: valorcombobodegas },
        dataType: "json",
        success: function(data) {
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            var date = new Date();
            var dia = date.getDate();
            var mes = ("0" + (date.getMonth() + 1));
            var anio = date.getFullYear();
            var fechatotal = dia + "/" + mes + "/" + anio;
            var time = date.toLocaleTimeString();
            var bodega = $("#combo_bodegas option:selected").text();
            $a.attr("download", "Reporte Stock Critico Bodega " + bodega + ' ' + fechatotal + ' ' + time + ".xls");
            $a[0].click();
            $a.remove();


        }
    });
}


//crea reporte
function reporte_bodega_max() {
    var valorcombobodegas = document.getElementsByName("combo_bodegas")[0].value;

    $.ajax({
        url: "http://localhost/hospital/control_lote/reportebodegamaximo",
        type: "POST",
        data: { codigo: valorcombobodegas },
        dataType: "json",
        success: function(data) {
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            var date = new Date();
            var dia = date.getDate();
            var mes = ("0" + (date.getMonth() + 1));
            var anio = date.getFullYear();
            var fechatotal = dia + "/" + mes + "/" + anio;
            var time = date.toLocaleTimeString();
            var bodega = $("#combo_bodegas option:selected").text();
            $a.attr("download", "Reporte Stock Maximo Bodega " + bodega + ' ' + fechatotal + ' ' + time + ".xls");
            $a[0].click();
            $a.remove();


        }
    });
}