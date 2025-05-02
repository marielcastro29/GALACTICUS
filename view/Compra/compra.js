var suc_id = $("#SUC_IDx").val();
var usu_id = $("#USU_IDx").val();

$(document).ready(function () {
  $("#prov_id").select2();

  $("#cat_id").select2();

  $("#prod_id").select2();

  $("#pag_id").select2();

  $("#mon_id").select2();

  $("#doc_id").select2();

  $.post(
    "../../controller/documento.php?op=combo",
    { doc_tipo: "Compra" },
    function (data) {
      $("#doc_id").html(data);
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


  $("#cat_id").change(function () {
    $("#cat_id").each(function () {
      var cat_id = $(this).val();
      console.log("cat_id", cat_id);
  
      if (!cat_id ||cat_id == "Seleccionar" || cat_id == 0) { // Si no se ha seleccionado una categoría
        // Limpiar el combobox prod_id
        limpiarDatosProducto();
      } else {
        llenarComboboxProducto();
      }
    });
  });
  

  $("#prod_id").change(function () {
    $("#prod_id").each(function () {
      prod_id = $(this).val();

      //para que no lance error cuando se limpien los campos y cambie del valor en el que estaba a 0 
      if(prod_id>0){
      $.post(
        "../../controller/producto.php?op=mostrar",
        { prod_id: prod_id },
        function (data) {
          data = JSON.parse(data);
          $("#prod_pventa").val(data.PROD_PVENTA);
          $("#prod_stock").val(data.PROD_STOCK);
          $("#prod_pcompra").val("");
          $("#detc_cant").val("");
        }
      );
    }
    });
  });
});

$(document).on("click", "#btnagregar", function () {
  var prod_id = $("#prod_id").val(); //id del producto
  var prod_nombre = $("#prod_id option:selected").text(); //nombre del producto
  var prod_pcompra = parseFloat($("#prod_pcompra").val()) || 0;//precio de compra
  var prod_pventa = parseFloat($("#prod_pventa").val()) || 0;//precio de venta
  var detc_cant = parseFloat($("#detc_cant").val()) || 0; //cantidad
  var total = (prod_pcompra * detc_cant).toFixed(2); //total

  console.log("prod_pcompra: ",prod_pcompra,"rod_pcompra>prod_pventa",prod_pcompra,">",prod_pventa);

  if ((prod_id=="Seleccionar") || (prod_nombre=="Seleccionar") || !prod_pcompra || !detc_cant) {
    Swal.fire({
      title: "Error",
      text: "Por favor, complete todos los campos correctamente.",
      icon: "error",
    });
  } else {

    errores = [];//definimos un arreglo para guardar errores como que la cantidad sea negativa o 0 o que precio de compra mayor al de ventas

    if(detc_cant<=0){
      errores.push("La cantidad de compra no es correcta");
    }

    
    if(prod_pcompra>prod_pventa){
      errores.push("El precio de compra supera al de venta, edita en la seccion de productos el precio");
    }

    if(errores.length>0){
      Swal.fire({
        title: "Error",
        text: errores.join(""), //unimos cada uno de los errores con un salto de linea
        icon: "error",
      });
    } else {
      if(prod_id>0){
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
            <td>${prod_pcompra}</td>
            <td>${detc_cant}</td>
            <td>${total}</td>
            <td><button type="button" class="btn btn-danger btn-icon waves-effect waves-light btn-delete"><i class="ri-delete-bin-5-line"></i></button></td>
        </tr>
    `);

          // Limpiar los campos de entrada
          $("#prod_pcompra").val("");
          $("#detc_cant").val("");
          $("#prod_pventa").val("");
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

function limpiarDatosProducto(){

$("#prod_id").empty(); // Limpiar el contenido del select
$("#prod_id").append('<option selected>Seleccionar</option>'); // Agregar la opción por defecto
$("#prod_pventa").val("");
$("#prod_stock").val("");
$("#prod_pcompra").val("");
$("#detc_cant").val("");

}

function llenarComboboxProducto(){
  $.post(
    "../../controller/producto.php?op=combo",
    { cat_id: cat_id },
    function (data) {
      // Limpiar el contenido del select antes de agregar nuevas opciones
      $("#prod_id").html(data); // Actualizar el select con las opciones obtenidas
    }
  );
}
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

// Eliminar una fila de la tabla
$(document).on("click", ".btn-delete", function () {
  $(this).closest("tr").remove();
  actualizarTotales();
});


function listar(prod_id, detc_cant) {
  $("#table_data").DataTable({
    aProcessing: true,
    aServerSide: true,
    dom: "Bfrtip",
    buttons: [],
    ajax: {
      url: "../../controller/compra.php?op=listardetalle",
      type: "post",
      data: { prod_id: prod_id, detc_cant: detc_cant },
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

function eliminar(button) {
  swal
    .fire({
      title: "Eliminar!",
      text: "¿Desea eliminar el registro?",
      icon: "warning", // Usualmente se usa 'warning' cuando el mensaje es de advertencia
      confirmButtonText: "Sí",
      showCancelButton: true,
      cancelButtonText: "No",
    })
    .then((result) => {
      if (result.value) {
        // Obtener la fila más cercana al botón que activó el evento
        var row = button.closest("tr"); // 'button' es el parámetro que representa el botón de eliminar
        row.remove(); // Eliminar la fila de la tabla

        //actualizar el contador de la tabla
        var table = $("#table_data").DataTable();
        table.page.info();
      }
    });
}

$(document).on("click", "#btnguardar", function () {
  // Crear un arreglo donde se van a guardar temporalmente los productos
  var productos = [];
  // Obtener el valor de suc_id
  var doc_id = $("#doc_id").val();
  var pag_id = $("#pag_id").val();
  var mon_id = $("#mon_id").val();
  var comentario_compra = $("#compr_coment").val();
  //var cat_id = $("#cat_id").val();
  //var product_id = $("#prod_id").val();

  console.log("Documento de compra: " + doc_id);
  console.log("Tipo de pago: " + pag_id);
  console.log("Moneda: " + mon_id);
  console.log("Comentario: " + comentario_compra);
  console.log("Usuario: " + usu_id);
  console.log("Sucursal: " + suc_id);

  // Recoger los productos de la tabla
  $("#table_data tbody tr").each(function () {
    var prod_id = $(this).find("td:eq(2)").text().trim();
    var precio_compra = $(this).find("td:eq(4)").text().trim();
    var cantidad = $(this).find("td:eq(5)").text().trim();

    // Guardar los detalles del producto en el arreglo
    productos.push({
      prod_id: prod_id,
      precio_compra: precio_compra,
      cantidad: cantidad,
    });
  });

  console.log("ARRAY DE PRODUCTOS: ");
  console.log(productos);

  console.log("LENGTH PRODUCTOS", productos.length);

  // si no hay sucursal,documento,pago,moneda,usuario y productos esta vacio
  if (
    !suc_id ||
    (doc_id=="Seleccionar") ||
    (pag_id=="Seleccionar") ||
    (mon_id=="Seleccionar") ||
    !usu_id ||
    productos.length === 0
  ) {
    //SI ESTA
    Swal.fire({
      title: "Error",
      text: "Falta información para registrar la compra",
      icon: "warning",
      confirmButtonText: "Cerrar",
    });
  } else {
    if (
      doc_id > 0 &&
      pag_id > 0 &&
      mon_id > 0
    ) {

      
      //los indices deben ser mayor a 0 para que la opcion no sea seleccionar
      // Enviar los datos a `compra.php`
      $.ajax({
        url: "../../controller/compra.php?op=registrar", // Llamar a la opción "registrar"
        type: "POST",
        data: {
          suc_id: suc_id,
          doc_id: doc_id,
          pag_id: pag_id,
          mon_id: mon_id,
          usu_id: usu_id,
          compr_coment: comentario_compra,
          productos: JSON.stringify(productos), // Convertir array a JSON
        },
        success: function (respuesta) {
          console.log("Respuesta del servidor:", respuesta);

          Swal.fire({
            title: "¡Éxito!",
            text: "Compra registrada correctamente",
            icon: "success",
            confirmButtonText: "OK",
          });
          // Limpiar los campos
          $("#prod_pcompra").val("");
          $("#detc_cant").val("");
          $("#prod_pventa").val("");
          $("#prod_stock").val("");
          $("#cat_id").val("0").trigger("change");
          $("#prod_id").val("0").trigger("change");
          $("#doc_id").val("0").trigger("change");
          $("#mon_id").val("0").trigger("change");
          $("#pag_id").val("0").trigger("change");
          $("#table_data tbody").empty(); // Limpiamos la tabla
          $("#txtsubtotal").text(""); // Limpiando los th
          $("#txtigv").text("");
          $("#txttotal").text("");
          $("#compr_coment").val("");
          
        },
        error: function (error) {
          console.log("Error al registrar la compra:", error);
          Swal.fire({
            title: "Error al registrar!",
            text: "No se ha podido registrar la compra",
            icon: "error",
            confirmButtonText: "Cerrar",
          });
        },
      });
    }else{
      Swal.fire({
        title: "Error",
        text: "Falta información para registrar la compra",
        icon: "warning",
        confirmButtonText: "Cerrar",
      });
    }
  }
});


/*
    TM_COMPRA
    COMPR_ID
    SUC_ID
    PAG_ID
    COMPR_COMENT
    USU_ID
    MON_ID
    DOC_ID
    FECH_CREA
    EST

    TD_COMPRA_DETALLE
    DETC_ID
    COMPR_ID
    PROD_ID
    PROD_PCOMPRA
    DETC_CANT
    FECH_CREA
    EST
    */