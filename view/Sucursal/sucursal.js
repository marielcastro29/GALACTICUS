var session_suc_id = $('#SUC_IDx').val();

function init(){
    $("#mantenimiento_form").on("submit", function(e){
        guardaryeditar(e);
    });
}

function guardaryeditar(e){
    e.preventDefault();

    // FormData a partir del formulario (incluye el input hidden #suc_id)
    var formData = new FormData($("#mantenimiento_form")[0]);

    // Asegurarnos de que el valor actual del modal esté presente (sobrescribe si ya existe)
    // Esto soluciona el problema de leer una variable global inicial vacía.
    formData.set('suc_id', $('#suc_id').val() || '');

    $.ajax({
        url: "../../controller/sucursal.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){
            $('#table_data').DataTable().ajax.reload();
            $('#modalmantenimiento').modal('hide');

            swal.fire({
                title: 'Sucursal',
                text: 'Registro Confirmado',
                icon: 'success'
            });
        }
    });
}

$(document).ready(function(){

    $('#table_data').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [],
        "ajax":{
            url:"../../controller/sucursal.php?op=listar",
            type:"post",
            data: { suc_id: session_suc_id } // si tu servidor necesita la sucursal de sesión para filtrar
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
});

function editar(suc_id){
    $.post("../../controller/sucursal.php?op=mostrar", { suc_id: suc_id }, function(data){
        data = JSON.parse(data);
        $('#suc_id').val(data.SUC_ID);
        $('#suc_nom').val(data.SUC_NOM);
        $('#suc_cor').val(data.SUC_COR);
        $('#suc_tel').val(data.SUC_TEL);
        $('#suc_dir').val(data.SUC_DIR);

        $('#lbltitulo').html('Editar Registro');
        $('#modalmantenimiento').modal('show');
    }).fail(function(xhr){
        console.error('Error editar:', xhr.responseText);
        swal.fire('Error', 'No se pudo cargar el registro.', 'error');
    });
}

function eliminar(suc_id){
    swal.fire({
        title: "Eliminar!",
        text: "Desea Eliminar el Registro?",
        icon: "error",
        confirmButtonText : "Si",
        showCancelButton : true,
        cancelButtonText: "No",
    }).then((result) => {
        if (result.value){
            $.post("../../controller/sucursal.php?op=eliminar", { suc_id: suc_id }, function(data){
                // opcional: console.log(data);
                $('#table_data').DataTable().ajax.reload(null, false);
                swal.fire({
                    title:'Sucursal',
                    text: 'Registro Eliminado',
                    icon: 'success'
                });
            }).fail(function(xhr){
                console.error('Error eliminar:', xhr.responseText);
                swal.fire('Error', 'No se pudo eliminar el registro.', 'error');
            });
        }
    });
}

$(document).on("click", "#btnnuevo", function(){
    // limpiar modal
    $('#suc_id').val('');
    $('#suc_nom').val('');
    $('#suc_cor').val('');
    $('#suc_tel').val('');
    $('#suc_dir').val('');
    $('#lbltitulo').html('Nuevo Registro');
    $("#mantenimiento_form")[0].reset();
    $('#modalmantenimiento').modal('show');
});

init();
