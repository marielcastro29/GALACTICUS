var suc_id = $("#SUC_IDx").val();

$(document).ready(function () {
  $("#table_data").DataTable({
    aProcessing: true,
    aServerSide: true,
    dom: "Bfrtip",
    buttons: [],
    ajax: {
      url: "../../controller/compra.php?op=listarcompra",
      type: "post",
      data: { suc_id: suc_id },
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
});

function ver(compr_id){

  $('#detalle_data').DataTable({
      "aProcessing": true,
      "aServerSide": true,
      dom: 'Bfrtip',
      buttons: ["excelHtml5"],
      "ajax":{
          url:"../../controller/compra.php?op=listardetalle",
          type:"post",
          data:{compr_id:compr_id}
      },
      "bDestroy": true,
      "responsive": true,
      "bInfo":true,
      "iDisplayLength": 10,
      "order": [[ 0, "asc" ]],
      "language": {
          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "Ningún dato disponible en esta tabla",
          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix":    "",
          "sSearch":         "Buscar:",
          "sUrl":            "",
          "sInfoThousands":  ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
              "sFirst":    "Primero",
              "sLast":     "Último",
              "sNext":     "Siguiente",
              "sPrevious": "Anterior"
          },
          "oAria": {
              "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
              "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          }
      },
  });

  $.post(
    "../../controller/compra.php?op=calculo",
    { compr_id: compr_id },
    function (data) {
      data = JSON.parse(data);
      $("#txtsubtotal").html(parseFloat(data.COMPR_SUBTOTAL).toFixed(2));
      $("#txtigv").html(parseFloat(data.COMPR_IVA).toFixed(2));
      $("#txttotal").html(parseFloat(data.COMPR_TOTAL).toFixed(2));
    }
  );
  
  $('#modaldetalle').modal('show');
}



function redireccionarDocumento(compr_id) {
  const nuevaURL = "../../view/ViewCompra/index.php?compr_id=" + compr_id;
  window.location.href = nuevaURL;
}
