var suc_id = $("#SUC_IDx").val();
var usu_id = $("#USU_IDx").val();

$(document).ready(function () {


  $("#cli_id").select2();

  $("#cat_id").select2();

  $("#prod_id").select2();

  $("#pag_id").select2();

  $("#mon_id").select2();

  $("#doc_id").select2();

  $.post(
    "../../controller/documento.php?op=combo",
    { doc_tipo: "Venta" },
    function (data) {
      console.log(data);
      $("#doc_id").html(data);
    }
  );

  $.post(
    "../../controller/cliente.php?op=combo",
    { suc_id: suc_id },
    function (data) {
      $("#cli_id").html(data);
    }
  );

  $.post(
    "../../controller/categoria.php?op=combo",
    { suc_id: suc_id },
    function (data) {
      $("#cat_id").html(data);
    }
  );

  $.post("../../controller/pago.php?op=combo", function (data) {
    $("#pag_id").html(data);
  });

  $.post(
    "../../controller/moneda.php?op=combo",
    { suc_id: suc_id },
    function (data) {
      $("#mon_id").html(data);
    }
  );

  $("#cli_id").change(function () {
    $("#cli_id").each(function () {
      cli_id = $(this).val();

      console.log("cliente id: ", cli_id);
      if (cli_id == 0) {
        $("#cli_ruc").val("");
        $("#cli_direcc").val("");
        $("#cli_telf").val("");
        $("#cli_correo").val("");
      } else {
        $.post(
          "../../controller/cliente.php?op=mostrar",
          { cli_id: cli_id },
          function (data) {
            data = JSON.parse(data);
            $("#cli_ruc").val(data.CLI_RUC);
            $("#cli_direcc").val(data.CLI_DIRECC);
            $("#cli_telf").val(data.CLI_TELF);
            $("#cli_correo").val(data.CLI_CORREO);
          }
        );
      }
    });
  });

  $("#cat_id").change(function () {
    $("#cat_id").each(function () {
      cat_id = $(this).val();
      console.log("categoria id: ", cat_id);
      if (!cat_id ||cat_id == "Seleccionar" || cat_id == 0) {
        $("#prod_id").empty(); // Limpiar el contenido del select
        $("#prod_id").append("<option selected>Seleccionar</option>"); // Agregar la opción por defecto
        $("#prod_pventa").val("");
        $("#prod_stock").val("");
        $("#detv_cant").val("");
      } else {
        $.post(
          "../../controller/producto.php?op=combo",
          { cat_id: cat_id },
          function (data) {
            $("#prod_id").html(data);
          }
        );
      }
    });
  });

  $("#prod_id").change(function () {
    $("#prod_id").each(function () {
      prod_id = $(this).val();
      if(prod_id>0){
      $.post(
        "../../controller/producto.php?op=mostrar",
        { prod_id: prod_id },
        function (data) {
          data = JSON.parse(data);
          $("#prod_pventa").val(data.PROD_PVENTA);
          $("#prod_stock").val(data.PROD_STOCK);
          $("#und_nom").val(data.UND_NOM);
        }
      );
    }
    });
  });
});

$(document).on("click", "#btnagregar", function () {
  /*
    
TABLAS DE VENTAS

TM_VENTAS
SUC ID
PAG ID
CLIENTE ID
MONEDA ID 
DOC ID
COMENTARIO 
USU ID

TD_VENTA_DETALLE
VENTA ID
PROD ID
CANTIDAD
PRECIO _VENTA
*/
  var prod_pventa = parseFloat($("#prod_pventa").val()) || 0;//precio de venta
  var prod_id = $("#prod_id").val(); //id del producto
  console.log("id del producto:", prod_id);
  var prod_nombre = $("#prod_id option:selected").text(); //nombre del producto
  console.log("nombre del producto:", prod_nombre);
  var detv_cant = parseFloat($("#detv_cant").val()) || 0; //cantidad de venta
  console.log("cantidad del producto:", detv_cant);
  var total = (prod_pventa * detv_cant).toFixed(2); //total
  console.log("total:", total);
  var prod_stock = parseFloat($("#prod_stock").val()) || 0;

  if (
    prod_id == "Seleccionar" ||
    prod_nombre == "Seleccionar" ||
    !prod_pventa ||
    !detv_cant
  ) {
    Swal.fire({
      title: "Error",
      text: "Por favor, complete todos los campos correctamente.",
      icon: "error",
    });
  } else {
   // console.log("prod_stock === 1 && (detv_cant  === prod_stock",(prod_stock === 1 && (detv_cant  === prod_stock)),"prod_stock: ",prod_stock,"detv_cant: ",detv_cant)
    if ((prod_stock && detv_cant) == 1) {
      Swal.fire({
        title: "Advertencia",
        text:
          "Stock bajo",
        icon: "warning",
      });
    }
    //si la cantidad de compra super al stock enviar una alerta que indique que no hay suficiente producto en existencia
    if (detv_cant > prod_stock) {
      Swal.fire({
        title: "Error",
        text:
          prod_stock == 0
            ? "Lo sentimos, este producto no está disponible"
            : "La cantidad que desea comprar no está disponible en inventario. Para " +
              prod_nombre +
              " solo hay " +
              (prod_stock == 1
                ? "una unidad disponible."
                : prod_stock + " unidades disponibles."),
        icon: "error",
      });
    } else {
      if (prod_id > 0) {
        $.post(
          "../../controller/producto.php?op=get_info_producto",
          { prod_id: prod_id },
          function (data) {
            data = JSON.parse(data);
            var prod_img = data[0].PROD_IMG
              ? `../../assets/producto/${data[0].PROD_IMG}`
              : "../../assets/producto/no_imagen.png";

            // Agregar la fila a la tabla con la imagen del producto
            $("#table_data tbody").append(`
          <tr>
              <td><img src="${prod_img}" alt="Imagen" class="img-thumbnail" width="50"></td>
              <td>${$("#cat_id option:selected").text()} </td>
              <td style="display: none;">${prod_id}</td>
              <td>${prod_nombre}</td>
              <td>${prod_pventa}</td>
              <td>${detv_cant}</td>
              <td>${total}</td>
              <td><button type="button" class="btn btn-danger btn-icon waves-effect waves-light btn-delete"><i class="ri-delete-bin-5-line"></i></button></td>
          </tr>
      `);

            // Limpiar los campos de entrada
            $("#prod_pventa").val("");
            $("#detv_cant").val("");
            $("#prod_stock").val("");

            $("#cat_id").val("0").trigger("change");
            $("#prod_id").val("0").trigger("change");
            // Actualizar el total
            actualizarTotales();
          }
        );
      }
      //enviar alertas
    }
  }
});

// Función para actualizar los cálculos en la tabla
function actualizarTotales() {
  var subtotal = 0;
  $("#table_data tbody tr").each(function () {
    var totalFila = parseFloat($(this).find("td:eq(5)").text());
    subtotal += totalFila;
  });

  var iva = (subtotal * 0.15).toFixed(2);
  var total = (subtotal + parseFloat(iva)).toFixed(2);

  $("#txtsubtotal").text(subtotal.toFixed(2));
  $("#txtigv").text(iva);
  $("#txttotal").text(total);
}

//cuando se elimina una fila se debe remover de la tabla y volver a actualizar los totales
$(document).on("click", ".btn-delete", function () {
  $(this).closest("tr").remove();
  actualizarTotales();
});

function eliminar(detv_id, vent_id) {
  swal
    .fire({
      title: "Eliminar!",
      text: "Desea Eliminar el Registro?",
      icon: "error",
      confirmButtonText: "Si",
      showCancelButton: true,
      cancelButtonText: "No",
    })
    .then((result) => {
      if (result.value) {
        $.post(
          "../../controller/venta.php?op=eliminardetalle",
          { detv_id: detv_id },
          function (data) {
            console.log(data);
          }
        );

        $.post(
          "../../controller/venta.php?op=calculo",
          { vent_id: vent_id },
          function (data) {
            data = JSON.parse(data);
            $("#txtsubtotal").html(data.VENT_SUBTOTAL);
            $("#txtigv").html(data.VENT_IGV);
            $("#txttotal").html(data.VENT_TOTAL);
          }
        );

        listar(vent_id);

        swal.fire({
          title: "Venta",
          text: "Registro Eliminado",
          icon: "success",
        });
      }
    });
}

function listar(vent_id) {
  $("#table_data").DataTable({
    aProcessing: true,
    aServerSide: true,
    dom: "Bfrtip",
    buttons: [],
    ajax: {
      url: "../../controller/venta.php?op=listardetalle",
      type: "post",
      data: { vent_id: vent_id },
    },
    bDestroy: true,
    responsive: true,
    bInfo: true,
    iDisplayLength: 10,
    order: [[0, "asc"]],
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo:
        "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
  });
}

$(document).on("click", "#btnguardar", function () {
  var productos = [];

  // Obtener valores de los inputs y combobox
  var doc_id = $("#doc_id").val();
  var pag_id = $("#pag_id").val();
  var mon_id = $("#mon_id").val();
  var cli_id = $("#cli_id").val();
  var comentario_venta = $("#vent_coment").val();

  console.log("Documento de compra:", doc_id);
  console.log("Tipo de pago:", pag_id);
  console.log("Moneda:", mon_id);
  console.log("Cliente:", cli_id);
  console.log("Usuario:", usu_id);
  console.log("Sucursal:", suc_id);

  // Recoger productos de la tabla
  $("#table_data tbody tr").each(function () {
    var prod_id = $(this).find("td:eq(2)").text().trim();
    var precio_venta = $(this).find("td:eq(4)").text().trim();
    var cantidad = $(this).find("td:eq(5)").text().trim();

    productos.push({
      prod_id: prod_id,
      precio_venta: precio_venta,
      cantidad: cantidad,
    });
  });

  console.log("ARRAY DE PRODUCTOS:", productos);
  console.log("LENGTH PRODUCTOS:", productos.length);

  // Validar si hay campos vacíos o no seleccionados
  if (
    !suc_id ||
    !usu_id ||
    productos.length === 0 ||
    doc_id == "0" ||
    pag_id == "0" ||
    mon_id == "0" ||
    cli_id == "0"
  ) {
    Swal.fire({
      title: "Error",
      text: "Falta información para registrar la venta",
      icon: "warning",
      confirmButtonText: "Cerrar",
    });
  } else {
    // Enviar datos mediante AJAX
    $.ajax({
      url: "../../controller/venta.php?op=registrar",
      type: "POST",
      data: {
        suc_id: suc_id,
        doc_id: doc_id,
        pag_id: pag_id,
        mon_id: mon_id,
        cli_id: cli_id,
        usu_id: usu_id,
        vent_coment: comentario_venta,
        productos: JSON.stringify(productos),
      },
      success: function (respuesta) {
        console.log("Respuesta del servidor:", respuesta);
        Swal.fire({
          title: "¡Éxito!",
          text: "Venta registrada correctamente",
          icon: "success",
          confirmButtonText: "OK",
        });

        // Limpiar campos y resetear combobox
        $("#table_data tbody").empty();
        $("#txtsubtotal, #txtigv, #txttotal").text("");
        $("#vent_coment, #detv_cant, #prod_pventa, #prod_stock").val("");
        $("#doc_id, #mon_id, #pag_id, #cli_id, #cat_id, #prod_id")
          .val("0")
          .trigger("change");
      },
      error: function (error) {
        console.log("Error al registrar la venta:", error);
        Swal.fire({
          title: "Error al registrar",
          text: "No se ha podido registrar la venta",
          icon: "error",
          confirmButtonText: "Cerrar",
        });
      },
    });
  }
});