var choicesRol, choicesContrato;
// nuevo.js (integrado con Opción B)

/**
 * Itera sobre un objeto FormData e imprime sus claves y valores en la consola.
 * @param {FormData} formData - El objeto FormData a inspeccionar.
 */
function debugFormData(formData) {
  console.log("--- DEBUGGING FormData CONTENT ---");
  var entries = formData.entries();
  var entry = entries.next();

  // Iterar sobre todas las entradas
  while (!entry.done) {
    var key = entry.value[0];
    var value = entry.value[1];

    if (value instanceof File) {
      // Manejar archivos (como la imagen)
      console.log(
        "KEY: " +
          key +
          " | VALUE: [File: " +
          value.name +
          " (" +
          value.size +
          " bytes)]"
      );
    } else {
      // Manejar campos de texto
      console.log("KEY: " + key + " | VALUE: " + value);
    }
    entry = entries.next();
  }
  console.log("----------------------------------");
}

$(document).ready(function () {
  cargar_combos();
  /* 1. Obtener el ID de la URL (si existe) */
  const urlParams = new URLSearchParams(window.location.search);
  const usu_id = urlParams.get("id");

  // variable global para mantener la contraseña actual traída del servidor
  window._existing_password = "";

  /* 2. Lógica Inicial: Crear vs Editar */
  if (usu_id) {
    // --- MODO EDICIÓN ---
    console.log("Modo Edición: ID " + usu_id);

    // Mostrar paneles de Info y Actividad (si estaban ocultos por defecto en PHP)
    $("#info_panel").show();
    $("#activity_panel").show();

    // Asignar valor al input hidden
    $("#usu_id").val(usu_id);

    // Cambiar título de la página (opcional)
    $(".page-title-box h4").text("Editar Usuario");

    // Cargar los datos
    cargarDatosUsuario(usu_id);
  } else {
    // --- MODO CREAR ---
    console.log("Modo Creación");

    // Ocultar paneles que no sirven para usuario nuevo
    $("#info_panel").hide();
    $("#activity_panel").hide();

    // Limpiar formulario
    $("#usu_id").val("");
    // Si tienes un form global:
    if ($("#form_mantenimiento").length) $("#form_mantenimiento")[0].reset();
  }
});

function cargar_combos() {
  var suc_id = $("#SUC_IDx").val() || "";

  // --- ROLES ---
  $.post(
    "../../controller/rol.php?op=combo",
    { suc_id: suc_id },
    function (data) {
      // Limpiar instancia previa
      if (choicesRol) choicesRol.destroy();

      $("#usu_roles").html(data);

      console.log(data);
      // Validar que el elemento existe para evitar el error "Expected one of the following types..."
      var element = document.getElementById("id");
      if (element) {
        choicesRol = new Choices(element, {
          searchEnabled: true,
          itemSelectText: "",
          shouldSort: false,
        });
      }
    }
  );

  // --- TIPO CONTRATO ---
  $.post("../../controller/tipoContrato.php?op=combo", function (data) {
    if (choicesContrato) choicesContrato.destroy();

    console.log(data);

    $("#emp_tipo_contrato").html(data);

    var element = document.getElementById("emp_tipo_contrato");
    if (element) {
      choicesContrato = new Choices(element, {
        searchEnabled: false,
        itemSelectText: "",
        shouldSort: false,
      });
    }
  });
}
/* Función para pedir datos al Controller y llenar inputs */
function cargarDatosUsuario(id) {
  $.post(
    "../../controller/usuario.php?op=mostrar",
    { usu_id: id },
    function (data) {
      data = typeof data === "string" ? JSON.parse(data) : data;
      console.log("mostrar ->", data); // Para depurar en consola

      // guardar contraseña actual en variable global para reenviarla si el usuario no cambia la contraseña
      window._existing_password = data.USU_PASS || data.usu_pass || "";

      $("#username").text(data.USU_USERNAME || data.usu_username || "");
      $("#rolname").text(data.ROL_NOMBRE || data.rol_nombre || "");

      // --- LLENAR DATOS PERSONALES ---
      $("#per_primer_nombre").val(
        data.PER_PRIMER_NOMBRE || data.per_primer_nombre || ""
      );
      $("#per_segundo_nombre").val(
        data.PER_SEGUNDO_NOMBRE || data.per_segundo_nombre || ""
      );
      $("#per_primer_apellido").val(
        data.PER_PRIMER_APELLIDO || data.per_primer_apellido || ""
      );
      $("#per_segundo_apellido").val(
        data.PER_SEGUNDO_APELLIDO || data.per_segundo_apellido || ""
      );
      $("#per_cedula").val(data.PER_CEDULA || data.per_cedula || "");
      $("#per_correo").val(data.PER_CORREO || data.per_correo || "");
      $("#per_telefono").val(data.PER_TELEFONO || data.per_telefono || "");
      $("#per_direccion").val(data.PER_DIRECCION || data.per_direccion || "");

      // Fechas
      $("#per_fecha_nacimiento").val(
        data.PER_FECHA_NACIMIENTO || data.per_fecha_nacimiento || ""
      );

      // --- LLENAR DATOS EMPLEADO ---
      $("#emp_salario").val(data.EMP_SALARIO || data.emp_salario || "");
      $("#emp_fecha_contratacion").val(
        data.EMP_FECHA_CONTRATACION || data.emp_fecha_contratacion || ""
      );
      $("#emp_fecha_fin_contrato").val(
        data.EMP_FECHA_FIN_CONTRATO || data.emp_fecha_fin_contrato || ""
      );

      // Selects
      //console.log("id de contrato: ", data.emp_tipo_contrato);
      //tipoContratoId = data.emp_tipo_contrato;

      // Usando data.emp_tipo_contrato directamente (asumiendo que corregiste el nombre de la variable en la llamada)
      //$("#emp_tipo_contrato").val(data.emp_tipo_contrato).trigger("change").trigger("change.select2");
      //var tipoContratoId = data.emp_tipo_contrato;

      // Para emp_tipo_contrato: Usar la API de Choices.js para setear el valor
      var tipoContratoId = data.emp_tipo_contrato;
      if (choicesContrato && tipoContratoId) {
        choicesContrato.setChoiceByValue(tipoContratoId.toString());
      }

      $("#emp_tipo_contrato").val(tipoContratoId).trigger("change");
      //$("#sucursal_id").val(data.SUC_ID || data.suc_id || '').trigger('change');
      $("#usu_roles")
        .val(data.ROL_ID || data.rol_id || "")
        .trigger("change");

      // --- LLENAR DATOS USUARIO ---
      $("#usu_nombre").val(data.USU_USERNAME || data.usu_username || "");
      $("#rolname").val(data.ROL_NOMBRE || data.rol_nombre || "");

      console.log("datos", data);

      // --- IMAGEN ---
      if (data.USU_IMAGEN || data.usu_imagen) {
        var img = data.USU_IMAGEN || data.usu_imagen;
        $(".user-profile-image").attr("src", "../../assets/usuario/" + img);
      }

      // --- ACTUALIZAR TEXTOS DEL PERFIL (Panel Izquierdo) ---
      $(".profile-user h5").text(
        (data.PER_PRIMER_NOMBRE || data.per_primer_nombre || "") +
          " " +
          (data.PER_PRIMER_APELLIDO || data.per_primer_apellido || "")
      );
      // Actualizar tabla de info lateral si existe
      if ($("#info_panel table tr").length >= 4) {
        $("#info_panel table tr:eq(0) td").text(
          (data.PER_PRIMER_NOMBRE || data.per_primer_nombre || "") +
            " " +
            (data.PER_PRIMER_APELLIDO || data.per_primer_apellido || "")
        );
        $("#info_panel table tr:eq(1) td").text(
          data.PER_CORREO || data.per_correo || ""
        );
        $("#info_panel table tr:eq(2) td").text(
          data.PER_TELEFONO || data.per_telefono || ""
        );
        $("#info_panel table tr:eq(3) td").text(
          data.SUC_NOMBRE || data.suc_nombre || ""
        );
      }
    }
  ).fail(function (xhr) {
    console.error("Error al cargar datos usuario:", xhr.responseText);
    Swal.fire("Error", "No se pudo cargar los datos del usuario", "error");
  });
}

/* ---------------------------------------------------
   FUNCIÓN 3: Recolector de Datos (LA MAGIA)
   --------------------------------------------------- */
// Esta función busca inputs dentro de un contenedor (div, form, tab) y los agrega al FormData
function recolectarDatosDeContenedor(selector, formData) {
  var container = document.querySelector(selector);
  if (!container) return;

  // Buscamos todos los elementos de formulario habilitados
  var elementos = container.querySelectorAll(
    "input:not([disabled]), select:not([disabled]), textarea:not([disabled])"
  );

  elementos.forEach(function (el) {
    var name = el.name || el.id; // Si no tiene name, usa el ID
    if (!name) return; // Si no tiene ninguno, saltar

    // Caso especial: Archivos
    if (el.type === "file") {
      // Los archivos se procesan aparte, o aquí si están dentro del tab
      if (el.files.length > 0) formData.append(name, el.files[0]);
    }
    // Caso especial: Radio/Checkbox
    else if (el.type === "radio" || el.type === "checkbox") {
      if (el.checked) formData.append(name, el.value);
    }
    // Caso normal: Texto, select, number, etc.
    else {
      formData.append(name, el.value);
    }
  });
}

/* ---------------------------------------------------
   EVENTO: Click en botón Guardar
   --------------------------------------------------- */
$(document).on("click", "#btnGuardarUsuario", function (e) {
  e.preventDefault();

  // 1. Crear el objeto FormData vacío
  var finalFD = new FormData();

  // 2. Recolectar datos de las 3 pestañas (usando los IDs de los DIVs de las tabs)
  recolectarDatosDeContenedor("#personalDetails", finalFD);
  recolectarDatosDeContenedor("#changePassword", finalFD);
  recolectarDatosDeContenedor("#experience", finalFD);

  // 3. Recolectar campos ocultos (IDs) que suelen estar fuera de las tabs
  // Asegúrate de que estos inputs existan en tu HTML con estos IDs
  var idsOcultos = [
    "usu_id",
    "empleado_id",
    "persona_id",
    "SUC_IDx",
    "sucursal_id",
  ];
  idsOcultos.forEach(function (id) {
    var el = document.getElementById(id);
    if (el) finalFD.append(el.name || el.id, el.value);
  });

  // 4. Recolectar Imagen (si está en el sidebar)
  var fileInput = document.getElementById("profile-img-file-input");
  if (fileInput && fileInput.files.length > 0) {
    finalFD.append("usu_img", fileInput.files[0]); // El nombre 'usu_img' debe coincidir con lo que espera PHP
  }

  // 5. Validaciones de Contraseña
  var newPass = $("#newpasswordInput").val();
  var confirmPass = $("#confirmpasswordInput").val();
  var usu_id = $("#usu_id").val();
  var esNuevo = !usu_id || usu_id.trim() === "";

  if (esNuevo) {
    // CREAR: Contraseña obligatoria
    if (!newPass) {
      Swal.fire(
        "Atención",
        "La contraseña es obligatoria para usuarios nuevos.",
        "warning"
      );
      return;
    }
    if (newPass !== confirmPass) {
      Swal.fire("Error", "Las contraseñas no coinciden.", "error");
      return;
    }
    finalFD.append("contrasenia", newPass); // Usar nombre exacto del SP/Controller
  } else {
    // EDITAR: Contraseña opcional
    if (newPass) {
      if (newPass !== confirmPass) {
        Swal.fire("Error", "Las contraseñas no coinciden.", "error");
        return;
      }
      finalFD.append("contrasenia", newPass);
    } else {
      // Enviar la contraseña existente (o cadena vacía si el SP lo maneja)
      // Si tu SP maneja string vacío como "no cambiar", manda vacío.
      // Si tu controlador PHP requiere el hash viejo, mándalo.
      // Asumiendo que el SP ignora si está vacío:
      finalFD.append("contrasenia", "");
    }
  }

  debugFormData(finalFD);

  // antes de enviar AJAX, agrega/valida campos críticos
  // (poner esto justo antes del $.ajax call)

  console.log("Contenido final antes de enviar:");
  console.log("usu_id=", $("#usu_id").val());
  console.log("SUC_IDx=", $("#SUC_IDx").val());
  console.log("usu_roles (select) =", $("#usu_roles").val());
  console.log("emp_tipo_contrato =", $("#emp_tipo_contrato").val());

  // Asegurar rol_id: (si usas Choices.js obtén el valor de choicesRol si aplica)
  var rolId = $("#usu_roles").val();
  if (!rolId && typeof choicesRol !== "undefined" && choicesRol) {
    try {
      rolId = choicesRol.getValue(true);
    } catch (e) {
      /* ignore */
    }
  }
  if (!rolId) {
    // si tu aplicación necesita rol para editar/crear, valida aquí
    console.warn(
      "No se seleccionó rol_id. Añadiendo vacío (backend debe validar)."
    );
  }
  finalFD.append("rol_id", rolId || "");

  // Asegurar sucursal (la sacamos del hidden en header SUC_IDx)
  var sucursal = $("#SUC_IDx").val() || $("#SUC_ID").val() || "";
  finalFD.append("sucursal_id", sucursal);

  // Tipo de contrato => obligatorio si tu tabla EMPLEADOS requiere FK
  var tipoContrato = $("#emp_tipo_contrato").val();
  if (!tipoContrato) {
    // si estás en edición quizás quieras permitir vacío pero evitar la FK error.
    // Mejor: informar al usuario:
    Swal.fire("Error", "Selecciona un tipo de contrato válido", "error");
    return; // interrumpir envío hasta que seleccione
  }
  finalFD.append("emp_tipo_contrato", tipoContrato);

  // PRUEBA: listar el contenido del FormData en consola (útil para depurar)
  console.log("FormData entries:");
  for (var pair of finalFD.entries()) {
    console.log(pair[0] + ": " + pair[1]);
  }

  // 6. Enviar al Servidor
  $.ajax({
    url: "../../controller/usuario.php?op=guardaryeditar",
    type: "POST",
    data: finalFD,
    contentType: false,
    processData: false,
    beforeSend: function () {
      $("#btnGuardarUsuario")
        .prop("disabled", true)
        .html('<i class="ri-loader-4-line ri-spin"></i> Guardando...');
    },
    success: function (response) {
      $("#btnGuardarUsuario")
        .prop("disabled", false)
        .html('<i class="ri-save-3-line me-1"></i> Guardar');
      console.log("Respuesta Servidor:", response);

      // Verificar respuesta (ajusta según lo que devuelve tu PHP: "ok", "Creado", o JSON)
      // Asumiremos éxito si no hay error HTTP, pero idealmente parsea la respuesta
      Swal.fire({
        title: "¡Listo!",
        text: "La información se guardó correctamente.",
        icon: "success",
      }).then((result) => {
        if (result.isConfirmed) {
          // window.location.href = "index.php";
        }
      });
    },
    error: function (xhr) {
      $("#btnGuardarUsuario").prop("disabled", false).text("Guardar");
      console.error("Error AJAX:", xhr.responseText);
      Swal.fire(
        "Error",
        "Hubo un problema al comunicarse con el servidor.",
        "error"
      );
    },
  });
});
