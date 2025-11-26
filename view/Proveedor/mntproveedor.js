var suc_id = $("#SUC_IDx").val();

function init() {
    $("#mantenimiento_form").on("submit", function (e) {
        guardaryeditar(e);
    });
}

// ====================================================================
// FUNCIÓN AUXILIAR DE LIMPIEZA
// ====================================================================
function limpiarCamposEspecificos(fieldsContainer) {
    // Seleccionamos todos los elementos de formulario que contienen datos
    const elements = fieldsContainer.querySelectorAll('input, textarea, select');

    elements.forEach((element) => {
        // Limpiamos solo los campos que almacenan valor (ignorando botones, hidden, radios, etc.)
        if (element.type !== 'button' && element.type !== 'submit' && element.type !== 'hidden' && element.type !== 'radio' && element.type !== 'checkbox') {
            element.value = "";
        }
    });
}
/*
function limpiarCamposEspecificos(fieldsContainer) {
    const inputs = fieldsContainer.querySelectorAll(
        'input[type="text"], input[type="date"], input[type="email"]'
    );
    inputs.forEach((input) => {
        input.value = "";
    });
}
*/

// ====================================================================
// FUNCIÓN DE VISIBILIDAD CON LÓGICA CONDICIONAL
// ====================================================================
function toggleFields() {
    const radioNatural = document.getElementById("radioNatural");
    const naturalFields = document.getElementById("natural_fields");
    const juridicaFields = document.getElementById("juridica_fields");
    
    // Referencia al contenedor de Teléfono, Correo, Dirección
    const commonFields = document.getElementById("common_fields"); 
    
    const esRegistroNuevo = $("#prov_id").val() === "";

    if (radioNatural.checked) {
        // MOSTRAR NATURAL
        naturalFields.style.display = "block";
        juridicaFields.style.display = "none";
        
        if (esRegistroNuevo) {
            // LIMPIAMOS LOS CAMPOS JURÍDICOS (ocultos)
            limpiarCamposEspecificos(juridicaFields);
            // LIMPIAMOS LOS CAMPOS COMUNES, ya que el usuario lo requiere en nuevo registro
            limpiarCamposEspecificos(commonFields); 
        }
        
    } else {
        // MOSTRAR JURÍDICA
        naturalFields.style.display = "none";
        juridicaFields.style.display = "block";
        
        if (esRegistroNuevo) {
            // LIMPIAMOS LOS CAMPOS NATURALES (ocultos)
            limpiarCamposEspecificos(naturalFields);
            // LIMPIAMOS LOS CAMPOS COMUNES, ya que el usuario lo requiere en nuevo registro
            limpiarCamposEspecificos(commonFields); 
        }
    }
}


/*
function toggleFields() {
    const radioNatural = document.getElementById("radioNatural");
    const naturalFields = document.getElementById("natural_fields");
    const juridicaFields = document.getElementById("juridica_fields");
    
    // Verificamos si es un registro nuevo revisando si el input hidden ID está vacío
    const esRegistroNuevo = $("#prov_id").val() === "";

    if (radioNatural.checked) {
        // MOSTRAR NATURAL
        naturalFields.style.display = "block";
        juridicaFields.style.display = "none";
        
        // SOLO LIMPIAR SI ES NUEVO
        if (esRegistroNuevo) {
            limpiarCamposEspecificos(juridicaFields);
        }
        
    } else {
        // MOSTRAR JURÍDICA
        naturalFields.style.display = "none";
        juridicaFields.style.display = "block";
        
        // SOLO LIMPIAR SI ES NUEVO
        if (esRegistroNuevo) {
            limpiarCamposEspecificos(naturalFields);
        }
    }
}
*/
// ====================================================================
// FUNCIONES AJAX
// ====================================================================

function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#mantenimiento_form")[0]);
    formData.append("suc_id", $("#SUC_IDx").val());

    $.ajax({
        url: "../../controller/proveedor.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data);
            $("#table_data").DataTable().ajax.reload();
            $("#modalmantenimiento").modal("hide");

            swal.fire({
                title: "Proveedor",
                text: "Operación realizada con éxito",
                icon: "success",
            });
        },
        error: function(xhr) {
            console.error("Error:", xhr.responseText);
        }
    });
}

/*
function editar(prov_id) {
    $.post(
        "../../controller/proveedor.php?op=mostrar",
        { prov_id: prov_id },
        function (data) {
            data = JSON.parse(data);

            // 1. Limpiar formulario
            $("#mantenimiento_form")[0].reset();

            // 2. Asignar ID (IMPORTANTE: Al tener valor, toggleFields sabrá que es edición)
            $("#prov_id").val(data.PROV_ID);

            // 3. Datos Comunes
            $("#telefono").val(data.TELEFONO);
            $("#correo").val(data.CORREO);
            $("#direccion").val(data.DIRECCION);

            const tipoPersonaId = parseInt(data.TIPO_PERSONA_ID);

            // 4. Lógica de Tipo de Persona
            if (tipoPersonaId === 1) { // NATURAL
                $("#radioNatural").prop("checked", true);
                $("#primer_nombre").val(data.PRIMER_NOMBRE);
                $("#segundo_nombre").val(data.SEGUNDO_NOMBRE);
                $("#primer_apellido").val(data.PRIMER_APELLIDO);
                $("#segundo_apellido").val(data.SEGUNDO_APELLIDO);
                $("#cedula").val(data.CEDULA);
                $("#fecha_nacimiento").val(data.FECHA_NACIMIENTO);
                
                // Pre-llenar datos ocultos para facilitar cambio de tipo (Opcional)
                $("#razon_social").val(data.PRIMER_NOMBRE + " " + (data.PRIMER_APELLIDO || ""));

            } else if (tipoPersonaId === 2) { // JURÍDICA
                $("#radioJuridica").prop("checked", true);
                $("#razon_social").val(data.PRIMER_NOMBRE);
                $("#ruc_juridico").val(data.RUC);
                
                // Pre-llenar datos ocultos
                $("#primer_nombre").val(data.PRIMER_NOMBRE);
            }

            // 5. Actualizar visibilidad (No borrará nada porque prov_id tiene valor)
            toggleFields();

            $("#lbltitulo").html("Editar Registro");
            $("#modalmantenimiento").modal("show");
        }
    );
}
*/
function editar(prov_id) {
    $.post(
        "../../controller/proveedor.php?op=mostrar",
        { prov_id: prov_id },
        function (data) {
            data = JSON.parse(data);

            // 1. Limpiar el formulario y establecer el ID
            $("#mantenimiento_form")[0].reset();
            // IMPORTANTE: Al tener valor, toggleFields detectará el modo 'Edición' y NO limpiará
            $("#prov_id").val(data.PROV_ID);

            // 2. Cargar datos comunes (Teléfono, Correo, Dirección)
            $("#telefono").val(data.TELEFONO);
            $("#correo").val(data.CORREO);
            $("#direccion").val(data.DIRECCION);

            const tipoPersonaId = parseInt(data.TIPO_PERSONA_ID);

            // 3. Cargar datos específicos y seleccionar Radio Button
            if (tipoPersonaId === 1) { // NATURAL
                $("#radioNatural").prop("checked", true);
                $("#primer_nombre").val(data.PRIMER_NOMBRE);
                $("#segundo_nombre").val(data.SEGUNDO_NOMBRE);
                $("#primer_apellido").val(data.PRIMER_APELLIDO);
                $("#segundo_apellido").val(data.SEGUNDO_APELLIDO);
                $("#cedula").val(data.CEDULA);
                $("#fecha_nacimiento").val(data.FECHA_NACIMIENTO);
                
                // Opcional: Pre-llenar Razón Social por si cambian a Jurídica
                $("#razon_social").val(data.PRIMER_NOMBRE + " " + (data.PRIMER_APELLIDO || ""));

            } else if (tipoPersonaId === 2) { // JURÍDICA
                $("#radioJuridica").prop("checked", true);
                // Razón Social se mapea a PRIMER_NOMBRE
                $("#razon_social").val(data.PRIMER_NOMBRE); 
                $("#ruc_juridico").val(data.RUC);
                
                // Opcional: Pre-llenar Primer Nombre por si cambian a Natural
                $("#primer_nombre").val(data.PRIMER_NOMBRE);
            }

            // 4. Actualizar visibilidad. No se ejecutará la limpieza porque prov_id tiene valor.
            toggleFields();

            // 5. Mostrar Modal
            $("#lbltitulo").html("Editar Registro");
            $("#modalmantenimiento").modal("show");
        }
    );
}

function eliminar(prov_id) {
    swal.fire({
        title: "Eliminar!",
        text: "¿Desea Eliminar al Proveedor?",
        icon: "warning",
        confirmButtonText: "Si",
        showCancelButton: true,
        cancelButtonText: "No",
    }).then((result) => {
        if (result.value) {
            $.post(
                "../../controller/proveedor.php?op=eliminar",
                { prov_id: prov_id },
                function (data) {
                    console.log(data);
                    $("#table_data").DataTable().ajax.reload();
                    swal.fire({
                        title: "Proveedor",
                        text: "Registro Eliminado",
                        icon: "success",
                    });
                }
            );
        }
    });
}

$(document).on("click", "#btnnuevo", function () {
    $("#mantenimiento_form")[0].reset();
    $("#prov_id").val(""); // IMPORTANTE: Vaciar ID para que toggleFields sepa que es nuevo
    
    // Valor por defecto Natural
    $("#radioNatural").prop("checked", true);
    
    // Ejecutar toggleFields (Limpiará los campos de Jurídica porque es nuevo)
    toggleFields();

    $("#lbltitulo").html("Nuevo proveedor");
    $("#modalmantenimiento").modal("show");
});

$(document).ready(function () {
    $("#table_data").DataTable({
        aProcessing: true,
        aServerSide: true,
        dom: "Bfrtip",
        buttons: ["copyHtml5", "excelHtml5", "csvHtml5"],
        ajax: {
            url: "../../controller/proveedor.php?op=listar",
            type: "post",
            data: { suc_id: $("#SUC_IDx").val() },
        },
        bDestroy: true,
        responsive: true,
        bInfo: true,
        iDisplayLength: 10,
        order: [[0, "desc"]],
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
        },
    });

    const radioNatural = document.getElementById("radioNatural");
    const radioJuridica = document.getElementById("radioJuridica");

    // Listeners para el cambio manual
    radioNatural.addEventListener("change", toggleFields);
    radioJuridica.addEventListener("change", toggleFields);
});

init();