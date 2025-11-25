// perfil.js - versión lista para usar
var choicesRol, choicesContrato;

$(document).ready(function () {
  // cargar combos primero
  cargar_combos();

  // obtener id desde el input oculto del header (session user id)
  var sessionId = $('#USU_IDx').val() || '';
  console.log(sessionId);

  // Si no existe en session, intentar leer ?id=... por si el link lo envía
  if (!sessionId) {
    const urlParams = new URLSearchParams(window.location.search);
    sessionId = urlParams.get('id') || '';
  }

  if (sessionId && sessionId.trim() !== '') {
    // marcar el hidden del formulario y cargar datos
    $('#usu_id').val(sessionId);
    // mostrar paneles (si están ocultos por defecto)
    $('#info_panel').show();
    $('#activity_panel').show();

    // cargar datos del usuario usando el id de sesión
    cargarDatosUsuario(sessionId);
  } else {
    // modo creación (raro en perfil, pero por consistencia)
    $('#info_panel').hide();
    $('#activity_panel').hide();
    $('#usu_id').val('');
  }
});

function cargar_combos() {
  var suc_id = $('#SUC_IDx').val() || '';

  // ROLES (depende de sucursal)
  $.post('../../controller/rol.php?op=combo', { suc_id: suc_id }, function (data) {
    $('#usu_roles').html(data);

    // inicializar Choices si lo usas (asegúrate de tener choices.js cargado)
    if (typeof Choices !== 'undefined') {
      if (choicesRol) {
        try { choicesRol.destroy(); } catch(e){/*ignore*/ }
      }
      var elRol = document.getElementById('usu_roles');
      if (elRol) {
        choicesRol = new Choices(elRol, {
          searchEnabled: true,
          itemSelectText: '',
          shouldSort: false
        });
      }
    }
  }).fail(function(xhr){
    console.error('Error cargando roles:', xhr.responseText);
  });

  // TIPOS DE CONTRATO (si no depende de sucursal, no enviar suc_id)
  $.post('../../controller/tipoContrato.php?op=combo', function (data) {
    $('#emp_tipo_contrato').html(data);

    if (typeof Choices !== 'undefined') {
      if (choicesContrato) {
        try { choicesContrato.destroy(); } catch(e){/*ignore*/ }
      }
      var elContrato = document.getElementById('emp_tipo_contrato');
      if (elContrato) {
        choicesContrato = new Choices(elContrato, {
          searchEnabled: false,
          itemSelectText: '',
          shouldSort: false
        });
      }
    }
  }).fail(function(xhr){
    console.error('Error cargando tipos de contrato:', xhr.responseText);
  });
}

function cargarDatosUsuario(id) {
  if (!id) {
    console.warn('cargarDatosUsuario: id vacío');
    return;
  }

  $.post('../../controller/usuario.php?op=mostrar', { usu_id: id }, function (data) {
    // Si el controller devuelve texto, parsear; si ya es objeto, usarlo
    data = (typeof data === 'string') ? JSON.parse(data) : data;
    console.log('mostrar ->', data);

    // proteger por si faltan campos
    window._existing_password = data.USU_PASS || data.usu_pass || '';

    // perfil izquierdo
    $('#username').text((data.PER_PRIMER_NOMBRE || data.per_primer_nombre || '') + ' ' + (data.PER_PRIMER_APELLIDO || data.per_primer_apellido || ''));
    $('#rolname').text(data.ROL_NOMBRE || data.rol_nombre || '');

    // llenar inputs personales
    $('#per_primer_nombre').val(data.PER_PRIMER_NOMBRE || data.per_primer_nombre || '');
    $('#per_segundo_nombre').val(data.PER_SEGUNDO_NOMBRE || data.per_segundo_nombre || '');
    $('#per_primer_apellido').val(data.PER_PRIMER_APELLIDO || data.per_primer_apellido || '');
    $('#per_segundo_apellido').val(data.PER_SEGUNDO_APELLIDO || data.per_segundo_apellido || '');
    $('#per_cedula').val(data.PER_CEDULA || data.per_cedula || '');
    $('#per_correo').val(data.PER_CORREO || data.per_correo || '');
    $('#per_telefono').val(data.PER_TELEFONO || data.per_telefono || '');
    $('#per_direccion').val(data.PER_DIRECCION || data.per_direccion || '');
    $('#per_fecha_nacimiento').val(data.PER_FECHA_NACIMIENTO || data.per_fecha_nacimiento || '');

    // empleado
    $('#emp_salario').val(data.EMP_SALARIO || data.emp_salario || '');
    $('#emp_fecha_contratacion').val(data.EMP_FECHA_CONTRATACION || data.emp_fecha_contratacion || '');
    $('#emp_fecha_fin_contrato').val(data.EMP_FECHA_FIN_CONTRATO || data.emp_fecha_fin_contrato || '');

    // selects: tipo contrato (si usas Choices.js, setear por su API)
    var tipoContratoId = data.EMP_TIPO_CONTRATO_ID || data.TIPO_CONTRATO_ID || data.emp_tipo_contrato || '';
    if (choicesContrato && tipoContratoId) {
      try { choicesContrato.setChoiceByValue(tipoContratoId.toString()); } catch(e){/*ignore*/ }
    }
    $('#emp_tipo_contrato').val(tipoContratoId).trigger('change');

    // roles
    var rolId = data.ROL_ID || data.rol_id || '';
    if (choicesRol && rolId) {
      try { choicesRol.setChoiceByValue(rolId.toString()); } catch(e){/*ignore*/ }
    }
    $('#usu_roles').val(rolId).trigger('change');

    // usuario
    $('#usu_nombre').val(data.USU_USERNAME || data.usu_username || '');

    // imagen de perfil
    if (data.USU_IMAGEN || data.usu_imagen) {
      var img = data.USU_IMAGEN || data.usu_imagen;
      $('.user-profile-image').attr('src', '../../assets/usuario/' + img);
      $('.header-profile-user').attr('src', '../../assets/usuario/' + img);
    }

    // actualizar tabla lateral (info panel)
    if ($('#info_panel table tr').length >= 4) {
      $('#info_panel table tr:eq(0) td').text((data.PER_PRIMER_NOMBRE || data.per_primer_nombre || '') + ' ' + (data.PER_PRIMER_APELLIDO || data.per_primer_apellido || ''));
      $('#info_panel table tr:eq(1) td').text(data.PER_CORREO || data.per_correo || '');
      $('#info_panel table tr:eq(2) td').text(data.PER_TELEFONO || data.per_telefono || '');
      $('#info_panel table tr:eq(3) td').text(data.SUC_NOMBRE || data.suc_nombre || '');
    }

  }).fail(function(xhr){
    console.error('Error al cargar datos usuario:', xhr.responseText);
    Swal.fire('Error','No se pudo cargar los datos del usuario','error');
  });
}

/* -------------------------
  EVENTO GUARDAR (igual que antes)
   ------------------------- */
$(document).on('click', '#btnGuardarUsuario', function (e) {
  e.preventDefault();
  // aquí va tu lógica de recolección y envío (la misma que ya tienes)
  // ... (mantén tu implementacion actual de guardado)
  // Si quieres, puedo pegar tu bloque de guardado aquí y adaptarlo para perfil.
  console.log('Botón Guardar presionado');
});
