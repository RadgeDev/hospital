$(document).on("ready", main);


function main() {

    $.ajaxPrefilter(function(options, original_Options, jqXHR) {
        options.async = true;
    });
    $("#msg-error").hide();
    $("body").on("click", ".paginacion li a", function(e) {
        e.preventDefault();
        valorhref = $(this).attr("href");
        bodega = document.getElementsByName("combo_depto")[0].value;
        inicio = $("#fechainicio").val();
        fin = $("#fechafin").val();
        cantidad = $("#cantidadpag").val();
        if(bodega=="0"){
 swal("Algo fallo!", "Escoga un depto  valido.", "error");
}else if(inicio ==""){
   swal("Algo fallo!", "Escoga una Fecha inicio  valida.", "error");  
}else if(fin ==""){
   swal("Algo fallo!", "Escoga una Fecha termino  valida.", "error");  
}else {
        mostrarDatos(bodega, valorhref, cantidad, inicio,fin);
}
    });

    $("#cantidadpag").change(function() {
      bodega = document.getElementsByName("combo_depto")[0].value;
      inicio = $("#fechainicio").val();
      fin = $("#fechafin").val();
      cantidad = $("#cantidadpag").val();
      pagina="1";
      if(bodega=="0"){
 swal("Algo fallo!", "Escoga un depto  valido.", "error");
}else if(inicio ==""){
   swal("Algo fallo!", "Escoga una Fecha inicio  valida.", "error");  
}else if(fin ==""){
   swal("Algo fallo!", "Escoga una Fecha termino  valida.", "error");  
}else {
      mostrarDatos(bodega, pagina, cantidad, inicio,fin);
}
    });
    }

function buscarmostrardatos(){
bodega = document.getElementsByName("combo_depto")[0].value;
  inicio = $("#fechainicio").val();
  fin = $("#fechafin").val();
  cantidad = $("#cantidadpag").val();
  pagina="1";

if(bodega=="0"){
 swal("Algo fallo!", "Escoga un depto  valido.", "error");
}else if(inicio ==""){
   swal("Algo fallo!", "Escoga una Fecha inicio  valida.", "error");  
}else if(fin ==""){
   swal("Algo fallo!", "Escoga una Fecha termino  valida.", "error");  
}else {

 mostrarDatos(bodega, pagina, cantidad, inicio,fin);
}
}



function mostrarDatos(bodega, pagina, cantidad, inicio,fin) {

    $.ajax({
        url: "http://localhost/hospital/control_consumo_depto/mostrar",
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


function exportardatos(){
bodega = document.getElementsByName("combo_depto")[0].value;
inicio = $("#fechainicio").val();
fin = $("#fechafin").val();

if(bodega=="0"){
 swal("Algo fallo!", "Escoga un depto  valido.", "error");
}else if(inicio ==""){
   swal("Algo fallo!", "Escoga una Fecha inicio  valida.", "error");  
}else if(fin ==""){
   swal("Algo fallo!", "Escoga una Fecha termino  valida.", "error");  
}else {

          $.ajax({
                url: "http://localhost/hospital/control_consumo_depto/reportefechas",
                type: "POST",
                data: { fechainicio: inicio, fechafin: fin, mibodega: bodega },
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
                    $a.attr("download", "Reporte Consumo  Depto " + fechatotal + ' ' + time + ".xls");
                    $a[0].click();
                    $a.remove();


                }
            });
}
}

