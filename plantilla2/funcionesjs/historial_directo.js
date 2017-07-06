$(document).on("ready", main);


function main() {

    $.ajaxPrefilter(function(options, original_Options, jqXHR) {
        options.async = true;
    });
    mostrarDatos("", 1, 10, "cod_compra");
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
        valorBuscar = document.getElementsByName("buscando")[0].value;
        valoroption = $("#cantidadpag").val();
        textobuscar = $("#busqueda").val();
        mostrarDatos(textobuscar, valorhref, valoroption, valorBuscar);
    });

    $("#cantidadpag").change(function() {
        valoroption = $(this).val();
        textobuscar = $("#busqueda").val();
        valorBuscar = document.getElementsByName("buscando")[0].value;
        mostrarDatos(textobuscar, 1, valoroption, valorBuscar);
    });
}
$("select[name=buscando]").change(function() {
    valoroption = $("#cantidadpag").val();
    textobuscar = $("#busqueda").val();
    valorBuscar = document.getElementsByName("buscando")[0].value;
    mostrarDatos(textobuscar, 1, valoroption, valorBuscar);
});

function mostrarDatos(valorBuscar, pagina, cantidad, valorcombo) {

    $.ajax({
        url: "http://localhost/hospital/control_historial_directo/mostrar",
        type: "POST",
        data: { buscar: valorBuscar, nropagina: pagina, cantidad: cantidad, valorcombos: valorcombo },
        dataType: "json",
        success: function(response) {

            filas = "";
            $.each(response.obtener, function(key, item) {
                filas += "<tr class='active' ><td >" + item.cod_compra + "</td><td>" + item.tipo_documento + "</td><td>" + item.numero_documento + "</td><td>" + item.nombre_proveedor + "</td><td>" + item.fecha + "</td><td>" + item.nombre_usuario + "</td><td> <button href='" + item.cod_compra + "'  id='editando'  onclick='editandos(this);' class='btn btn-success'>Ver</button></td></tr>";
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
    var url = "http://localhost/hospital/control_reporte/reportboletas/" + codseleccionado + ""
    var a = document.createElement("a");
    a.target = "_blank";
    a.href = url;
    a.click();
}