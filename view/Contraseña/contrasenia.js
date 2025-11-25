var usu_id = $('#USU_IDx').val();

$(document).on("click", "#btnguardar", function () {
    // Obtener ID y valores de los inputs
    var usu_id = $("#usu_id").val() || window.usu_id; 
    var pass_actual = $("#txtpass").val().trim();       // Input de Contraseña ANTERIOR
    var pass_nueva  = $("#txtpassconfirm").val().trim(); // Input de Contraseña NUEVA

    // Validar que no estén vacíos
    if (pass_actual === "" || pass_nueva === "") {
        return Swal.fire({
            title: 'Error',
            text: 'Por favor, completa ambos campos.',
            icon: 'error'
        });
    }

    // Validar longitud de la NUEVA contraseña (mínimo 8 caracteres)
    if (pass_nueva.replace(/\s/g, '').length < 8) {
        return Swal.fire({
            title: 'Error',
            text: 'La nueva contraseña debe tener al menos 8 caracteres.',
            icon: 'error'
        });
    }

    // Validar que la nueva no sea igual a la actual
    if (pass_actual === pass_nueva) {
        return Swal.fire({
            title: 'Aviso',
            text: 'La nueva contraseña no puede ser igual a la anterior.',
            icon: 'warning'
        });
    }

    var $btn = $(this);
    $btn.prop('disabled', true);

    Swal.fire({
        title: 'Espere',
        text: 'Verificando y actualizando...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // --- AJAX ---
    $.ajax({
        url: "../../controller/usuario.php?op=actualizar_contrasenia",
        method: "POST",
        dataType: "json",
        data: {
            usu_id: usu_id,
            pass_old: pass_actual, // Enviamos la actual para verificar
            pass_new: pass_nueva   // Enviamos la nueva para guardar
        },
        success: function (response) {
            Swal.close();
            if (response && response.success) {
                Swal.fire({
                    title: '¡Correcto!',
                    text: response.message || 'Contraseña actualizada correctamente.',
                    icon: 'success'
                }).then(() => {
                    // Limpiar campos al terminar
                    $("#txtpass").val("");
                    $("#txtpassconfirm").val("");
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    // Aquí mostraremos si la contraseña actual era incorrecta
                    text: response.message || 'No se pudo actualizar.',
                    icon: 'error'
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.close();
            var msg = 'Error en la conexión';
            try {
                var json = JSON.parse(xhr.responseText);
                if (json.message) msg = json.message;
            } catch (e) { }

            Swal.fire({
                title: 'Error del Servidor',
                text: msg,
                icon: 'error'
            });
        },
        complete: function () {
            $btn.prop('disabled', false);
        }
    });
});

/*
$(document).on("click", "#btnguardar", function () {
    var usu_id = $("#usu_id").val() || window.usu_id; // asegúrate de tener el id del usuario
    var pass = $("#txtpass").val().trim();
    var newpass = $("#txtpassconfirm").val().trim();

    // Validaciones cliente
    function tieneNoEspacios(str) {
        return /\S/.test(str); // true si hay al menos un carácter que no sea espacio
    }

    if (!tieneNoEspacios(pass) || !tieneNoEspacios(newpass)) {
        return Swal.fire({
            title: 'Error',
            text: 'Campos vacíos',
            icon: 'error'
        });
    }


    //Validar longitud de caracteres no-espacio:
    if (newpass.replace(/\s/g, '').length < 8) {
        return Swal.fire({
            title: 'Error',
            text: 'La contraseña debe contener al menos 8 caracteres no espaciales',
            icon: 'error'
        });
    }

    var $btn = $(this);
    $btn.prop('disabled', true);

    Swal.fire({
        title: 'Espere',
        text: 'Actualizando contraseña...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: "../../controller/usuario.php?op=actualizar",
        method: "POST",
        dataType: "json",
        data: {
            usu_id: usu_id,
            usu_pass: newpass
        },
        success: function (response) {
            Swal.close();
            if (response && response.success) {
                Swal.fire({
                    title: 'Correcto!',
                    text: response.message || 'Actualizado correctamente',
                    icon: 'success'
                });
                // limpiar campos si quieres:
                $("#txtpass, #txtpassconfirm").val("");
            } else {
                Swal.fire({
                    title: 'Error',
                    text: (response && response.message) ? response.message : 'No se pudo actualizar la contraseña',
                    icon: 'error'
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.close();
            var msg = 'Error en la conexión';
            // Intentar extraer mensaje JSON del servidor
            try {
                var json = JSON.parse(xhr.responseText);
                if (json.message) msg = json.message;
            } catch (e) { /* no JSON  }*/
/*
            Swal.fire({
                title: 'Error',
                text: msg + ' (Código: ' + xhr.status + ')',
                icon: 'error'
            });
        },
        complete: function () {
            $btn.prop('disabled', false);
        }
    });
});
*/

$(document).on("click", ".toggle-eye", function () {
    let inputId = $(this).data("target");
    let input = $("#" + inputId);
    let icon = $(this).find("i");

    if (input.attr("type") === "password") {
        input.attr("type", "text");
        icon.removeClass("ri-eye-off-line").addClass("ri-eye-line");
    } else {
        input.attr("type", "password");
        icon.removeClass("ri-eye-line").addClass("ri-eye-off-line");
    }
});

