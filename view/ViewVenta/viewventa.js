$(document).ready(function () {
    // Función para obtener parámetros de la URL
    function obtenerParametroURL(nombre) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(nombre);
    }

    // Obtener vent_id desde la URL
    var vent_id = obtenerParametroURL('vent_id');

    if (vent_id) {
        console.log("VENT_ID recibido en viewventa.js:", vent_id);
        llenarDocumento(vent_id); // Llamamos a la función para llenar los datos
    } else {
        console.error("Error: vent_id no encontrado en la URL.");
    }

    // Función para llenar los datos de la venta
    function llenarDocumento(vent_id) {
        $.post("../../controller/venta.php?op=mostrar", { vent_id: vent_id }, function (data) {
            data = JSON.parse(data);
            $('#txtsucursal').html(data.SUC_NOM);
            $('#txtcorreo').html(data.SUC_CORREO);
            $('#txttelf').html(data.SUC_TELEFONO);
            $('#txtdirecc').html(data.SUC_DIRECCION);
            $('#vent_id').html(data.VENT_ID);
            $('#fech_crea').html(data.FECHA);
            $('#pag_nom').html(data.PAG_NOM);
            $('#txttotal').html(data.MON_SIMBOLO + " " + data.VENT_TOTAL);
            $('#vent_subtotal').html(data.VENT_TOTAL);
            $('#vent_igv').html(((parseFloat(data.VENT_TOTAL)) * 0.15).toFixed(2));
            $('#vent_total').html(((parseFloat(data.VENT_TOTAL)) + ((parseFloat(data.VENT_TOTAL)) * 0.15)).toFixed(2));
            $('#vent_coment').html(data.VENT_COMENT);
            console.log("COMENTARIO DE VENTA: ",data.VENT_COMENT);
            $('#usu_nom').html(data.USU_NOM + ' ' + data.USU_APE);
            $('#mon_nom').html(data.MON_NOM);
            $('#cli_nom').html("<b>Nombre: </b>" + data.CLI_NOM);
            $('#cli_ruc').html("<b>RUC: </b>" + data.CLI_RUC);
            $('#cli_direcc').html("<b>Dirección: </b>" + data.CLI_DIRECC);
            $('#cli_correo').html("<b>Correo: </b>" + data.CLI_CORREO);
        });

        $.post("../../controller/venta.php?op=listardetalleformato", {vent_id:vent_id}, function (data) {
            console.log("Datos de listdetalle recibidos:", data);
            $('#listdetalle').html(data);
        });
        

        actualizarTotales();
    }
});


function actualizarTotales() {
    var subtotal = 0;
    var columnaTotal = 0;
  
    $("#detalle_data thead th").each(function (index) {
      if ($(this).text().trim() == "Total") {
        // Compara el texto del encabezado
        columnaTotal = index; // Guarda el índice de la columna "total"
      }
    });
  
    $("#detalle_data tbody tr").each(function () {
      var valorCelda = $(this).find("td").eq(columnaTotal).text().trim(); // Usa el índice de la columna
      console.log("Valor del subtotal: ", valorCelda);
  
      // Eliminar el símbolo de dólar y convertir a número
      var totalFila = parseFloat(
        valorCelda.replace("$", "").replace(",", "").trim()
      );
  
      // Verificar si es un número válido
      if (!isNaN(totalFila)) {
        subtotal += totalFila;
      }
    });
  
    var iva = (subtotal * 0.15).toFixed(2);
    var total = (subtotal + parseFloat(iva)).toFixed(2);
  
    console.log("subtotal", iva);
    console.log("iva", iva);
    console.log("total", total);
  
    $("#txtsubtotal").text(subtotal.toFixed(2));
    $("#txtigv").text(iva);
    $("#txttotal").text(total);
  }
  