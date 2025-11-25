// Función para limpiar caracteres especiales y evitar errores de HTML
function escapeHtml(str) {
  if (str === null || str === undefined) return "";
  return String(str)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

function buildCard(row) {
  // 1. Mapeo de Datos del SP a variables
  var id = row.USU_ID;

  // Nombre completo: Concatenamos Primer Nombre + Primer Apellido
  var nombre = row.PER_PRIMER_NOMBRE || "";
  var apellido = row.PER_PRIMER_APELLIDO || "";
  var displayName = (nombre + " " + apellido).trim();
  if (!displayName) displayName = row.USU_USERNAME; // Fallback

  var rol = row.ROL_NOMBRE || "Sin Rol";
  var salario = row.EMP_SALARIO
    ? parseFloat(row.EMP_SALARIO).toFixed(2)
    : "0.00";
  var correo = row.PER_CORREO || "Sin correo";

  // Manejo de Imagen
  var imagenNombre = row.USU_IMAGEN;

  //var imgSrc = '../../assets/usuario/no_imagen.png'; // Imagen por defecto
  var imgSrc = "../../assets/usuario/no_imagen.jpg"; // Imagen por defecto
  if (imagenNombre) {
    imgSrc = "../../assets/usuario/" + escapeHtml(imagenNombre);
  }

  // 2. Construcción del HTML (Usando TU plantilla exacta)
  var html = "";
  html += '<div class="col">'; // Columna de la grilla
  html += '<div class="card card-body h-100">'; // Card

  // --- Cabecera: Imagen y Nombres ---
  html += '<div class="d-flex mb-4 align-items-center">';
  html += '<div class="flex-shrink-0">';
  html +=
    '<img src="' + imgSrc + '" alt="" class="avatar-sm rounded-circle" />';
  html += "</div>";
  html += '<div class="flex-grow-1 ms-2">';
  html += '<h5 class="card-title mb-1">' + escapeHtml(displayName) + "</h5>";
  html += '<p class="text-muted mb-0">' + escapeHtml(rol) + "</p>";
  html += "</div>";
  html += "</div>";

  // --- Cuerpo: Salario y Detalle ---
  html += '<h6 class="mb-1">C$ ' + salario + "</h6>";
  html += '<p class="card-text text-muted">' + escapeHtml(correo) + "</p>";

  // --- Botones: Editar y Eliminar (Reemplazando "See Details") ---
  html += '<div class="d-flex gap-2 mt-3">';
  html +=
    '<button type="button" onclick="editarUsuario(' +
    id +
    ')" class="btn btn-soft-primary btn-sm w-50"><i class="ri-edit-2-line align-bottom me-1"></i> Editar</button>';
  html +=
    '<button type="button" onclick="eliminarUsuario(' +
    id +
    ')" class="btn btn-soft-danger btn-sm w-50"><i class="ri-delete-bin-line align-bottom me-1"></i> Eliminar</button>';
  html += "</div>";

  html += "</div>"; // Fin card
  html += "</div>"; // Fin col
  return html;
}

function renderUsuarios(rows) {
  var $container = $("#usuarios_cards"); // El ID del contenedor en tu HTML
  $container.empty();

  if (!Array.isArray(rows) || rows.length === 0) {
    $container.html(
      '<div class="col-12"><div class="alert alert-warning">No se encontraron usuarios en esta sucursal.</div></div>'
    );
    return;
  }

  var html = "";
  rows.forEach(function (r) {
    html += buildCard(r);
  });
  $container.html(html);
}

function cargarUsuarios() {
  // Obtenemos el ID de la sucursal del input hidden
  var suc_id = $("#SUC_IDx").val();

  // Validación simple
  if (!suc_id) {
    console.error("No se encontró SUC_IDx");
    return;
  }

  $.ajax({
    url: "../../controller/usuario.php?op=listar_cards",
    method: "POST",
    dataType: "json",
    data: { suc_id: suc_id },
  })
    .done(function (data) {
      // Manejo robusto de la respuesta (Array vs Objeto)
      var rows = [];
      if (Array.isArray(data)) {
        rows = data;
      } else if (data && typeof data === "object") {
        rows = Object.values(data);
      }
      renderUsuarios(rows);
    })
    .fail(function (xhr, status, err) {
      console.error("Error AJAX:", xhr.responseText);
    });
}

function eliminarUsuario(usu_id) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "No podrás revertir esta acción",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(
        "../../controller/usuario.php?op=eliminar",
        { usu_id: usu_id },
        function (data) {
          cargarUsuarios(); // Recargar las cards
          Swal.fire("¡Eliminado!", "El usuario ha sido eliminado.", "success");
        }
      );
    }
  });
}


$(document).ready(function () {
  cargarUsuarios();
});
// formulario de nuevos registros de usuario
// Función del botón "Nuevo Usuario"

$(document).on("click", "#btnnuevo", function () {
  window.location.href = "nuevo.php";
});


function abrirNuevoUsuario() {
    window.location.href = "nuevo.php";
}

// Función del botón "Editar" en las cards
function editarUsuario(usu_id) {
    window.location.href = "nuevo.php?id=" + usu_id;
}
