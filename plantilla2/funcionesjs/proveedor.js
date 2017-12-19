$(document).on("ready", main);


function main() {
    mostrarDatos("", 1, 10, "rut_proveedor");
    $("#msg-error").hide();


    $("input[name=busqueda]").keyup(function() {
        textobuscar = $(this).val();
        valoroption = $("#cantidad").val();
        var valorcombo = $("#buscando").val();

        mostrarDatos(textobuscar, 1, valoroption, valorcombo);
    });

    $("body").on("click", ".paginacion li a", function(e) {
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = $("input[name=busqueda]").val();
        valoroption = $("#cantidad").val();
        mostrarDatos(valorBuscar, valorhref, valoroption, "rut_proveedor");
    });

    $("#cantidad").change(function() {
        valoroption = $(this).val();
        valorBuscar = $("input[name=busqueda]").val();
        mostrarDatos(valorBuscar, 1, valoroption, "rut_proveedor");
    });
}

function mostrarDatos(valorBuscar, pagina, cantidad, valorcombo) {

    $.ajax({
        url: "http://localhost/hospital/control_proveedor/mostrar",
        type: "POST",
        data: { buscar: valorBuscar, nropagina: pagina, cantidad: cantidad, valorcombos: valorcombo },
        dataType: "json",
        success: function(response) {

            filas = "";
            $.each(response.clientes, function(key, item) {
                filas += "<tr class='active' ><td >" + item.rut_proveedor + "</td><td>" + item.nombre_proveedor + "</td><td>" + item.razon_social + "</td><td>" + item.direccion + "</td><td>" + item.telefono + "</td><td>" + item.correo + "</td><td> <button href='" + item.rut_proveedor + "'  id='editando'  onclick='editandos(this);' class='btn btn-warning' data-toggle='modal' data-target='#myModalEditar'>E</button> <button href='" + item.rut_proveedor + "'  id='eliminando'  onclick='eliminar(this);' class='btn btn-danger' >X</button></td></tr>";
            });

            $("#tbclientes tbody").html(filas);
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




function validar(mirut) {

    $.ajax({
        url: "http://localhost/hospital/control_proveedor/validar",
        type: "POST",
        data: { id: mirut },
        success: function(respuesta) {
            if (respuesta === "Rut existe") {
                $('#rut').val("");
                swal("Error!", "Este rut ya esta registrado", "error"); // a trves swift una libreria permite crear mensajes bonitos       
                document.getElementById("rut").focus();
            } else {



            }

        }
    });

}


var Fn = {
    // Valida el rut con su cadena completa "XXXXXXXX-X"
    validaRut: function(rutCompleto) {
        if (!/^[0-9]+-[0-9kK]{1}$/.test(rutCompleto))
            return false;
        var tmp = rutCompleto.split('-');
        var digv = tmp[1];
        var rut = tmp[0];
        if (digv == 'K') digv = 'k';
        return (Fn.dv(rut) == digv);
    },
    dv: function(T) {
        var M = 0,
            S = 1;
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
    letras = "1234567890-kK";


    if (letras.indexOf(tecla) == -1) {
        return false;
    }
}


$("#proveedorGuardar").submit(function(event) {

    event.preventDefault();

    $.ajax({
        url: $("#proveedorGuardar").attr("action"),
        type: $("#proveedorGuardar").attr("method"),
        data: $("#proveedorGuardar").serialize(),
        success: function(respuesta) {

            if (respuesta === "Registro Guardado") {

                $('#myModalproveedor').modal('hide'); //esconde formulario modal
                swal("Genial!", "Datos ingresados Correctamente", "success"); // a trves swift una libreria permite crear mensajes bonitos
                $('#proveedorGuardar').get(0).reset(); //resetea  los campos del formulario
            } else if (respuesta === "No se pudo guardar los datos") {
                swal("Error", "Error revise si los datos estan correctos", "error");
            } else {

                $("#msg-error").show();
                $(".list-errors").html(respuesta);
            }
            mostrarDatos("", 1, 10, "rut_proveedor");
        }
    });
});


$("#cerrando").click(cerrarModal);

$("#editando").click(editandos);


function editandos(obj) {
    var rutseleccionado = obj.getAttribute("href");
    $("#msg-error2").hide();
    event.preventDefault();
    // alert(rutseleccionado);
    $.ajax({
        url: "http://localhost/hospital/control_proveedor/editando",
        type: "POST",
        data: { id: rutseleccionado },
        dataType: "json",
        success: function(respuesta) {
            $.each(respuesta.obtener, function(key, item) {
                $("#selecrut").val(item.rut_proveedor);
                $("#selecnombre").val(item.nombre_proveedor);
                $("#selecrazon").val(item.razon_social);
                $("#selecdireccion").val(item.direccion);
                $("#selectelefono").val(item.telefono);
                $("#seleccorreo").val(item.correo);
            });

        }

    });



}


function cerrarModal() {
    $("#msg-error").hide();
    $("#msgerrorut").hide();
    $('#proveedorGuardar').get(0).reset(); //resetea  los campos del formulario
}


$("#actualizaron").click(actualizar);

function actualizar() {

    $("#usuarioEditar").submit(function(event) {

        event.preventDefault();
    });
    $.ajax({
        url: "http://localhost/hospital/control_proveedor/actualizar",
        type: "POST",
        data: $("#usuarioEditar").serialize(),
        success: function(respuesta) {
            if (respuesta === "Registro Actualizado") {
                $('#usuarioEditar').get(0).reset(); //resetea  los campos del formulario
                $('#myModalEditar').modal('hide'); //esconde formulario modal
                swal("Genial!", "Datos Editados Correctamente", "success"); // a trves swift una libreria permite crear mensajes bonitos

            } else if (respuesta === "Error al Actualizar") {
                $('#usuarioEditar').get(0).reset(); //resetea  los campos del formulario
                $('#myModalEditar').modal('hide'); //esconde formulario modal
                swal("Error", respuesta, "error");
            } else {

                $("#msg-error2").show();
                $(".list-errors").html(respuesta);
            }
            mostrarDatos("", 1, 10, "rut_proveedor");
        }
    });

}


function eliminar(obj) {

    rutseleccionado = obj.getAttribute("href");

    swal({
            title: "Estas seguro que deseas eliminar?",
            text: "Quieres eliminar al RUT: " + rutseleccionado,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, deseo borrarlo!",
            closeOnConfirm: false
        },
        function() {

            eliminando(rutseleccionado);
            swal("Eliminado!", "Registro eliminado.", "success");
        });

}

function eliminando(borrarrut) {
    alert(borrarrut);
    $.ajax({

        url: "http://localhost/hospital/control_proveedor/eliminar",
        type: "POST",
        data: { mirut: borrarrut },
        success: function(respuesta) {

            if (respuesta === "Registro Eliminado") {
                swal("Genial!", respuesta, "success"); // a trves swift una libreria permite crear mensajes bonitos

            } else {
                swal("Error", respuesta, "error");
            }
            mostrarDatos("", 1, 10, "rut_proveedor");
        }
    });
}

function exportarexcel() {


    var miJSON = "";
    var datostabla = { datos: [] };
    var obj = JSON.parse(JSON.stringify(datostabla));
    $("#tbclientes tbody tr").each(function(index) {
        var mirut, minombre, mirazon, midireccion, mitelefono, micorreo;
        $(this).children("td").each(function(index2) {
            switch (index2) {
                case 0:
                    mirut = $(this).text();
                    break;
                case 1:
                    minombre = $(this).text();
                    break;
                case 2:
                    mirazon = $(this).text();
                    break;
                case 3:
                    midireccion = $(this).text();
                    break;
                case 4:
                    mitelefono = $(this).text();
                    break;
                case 5:
                    micorreo = $(this).text();
                    break;

            }

        })


        //  var obj = JSON.parse('[datostabla]');
        obj['datos'].push({ "rut": mirut, "nombre": minombre, "razon": mirazon, "direccion": midireccion, "telefono": mitelefono, "correo": micorreo });

        //var miJSON = JSON.encode(obj);
        //alert(campo1 + ' - ' + campo2 + ' - ' + campo3);
    })
    var url = "http://localhost/hospital/control_proveedor/excel"
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
        $a.attr("download", "Reporte Proveedor " + fechatotal + ' ' + time + ".xls");
        $a[0].click();
        $a.remove();
    }, "json");
}