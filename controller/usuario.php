<?php
/* TODO: Llamando Clases */
require_once("../config/conexion.php");
require_once("../models/Usuario.php");
/* TODO: Inicializando clase */
$usuario = new Usuario();

switch ($_GET["op"]) {
    case "guardaryeditar":
        
        // 1. LÓGICA DE LA IMAGEN
        $usu_img = "";
        if (isset($_FILES["usu_img"]["name"]) && $_FILES["usu_img"]["name"] != '') {
            $extension = pathinfo($_FILES["usu_img"]["name"], PATHINFO_EXTENSION);
            $new_name = uniqid() . '.' . $extension; // Nombre único
            $destination = '../assets/usuario/' . $new_name;
            
            if(move_uploaded_file($_FILES["usu_img"]["tmp_name"], $destination)){
                $usu_img = $new_name;
            }
        } else {
            // Si no se sube imagen:
            // En CREAR: Queda vacía (o null)
            // En EDITAR: Enviamos vacío para que el SP sepa que no debe borrar la anterior
            $usu_img = ""; 
        }

        // 2. LÓGICA DE LA CONTRASEÑA
        // Si viene texto, lo encriptamos. Si viene vacío, lo dejamos vacío.
        $usu_pass = "";
        if (!empty($_POST["usu_pass"])) {
            $usu_pass = password_hash($_POST["usu_pass"], PASSWORD_DEFAULT);
        }

        // 3. LÓGICA DE FECHAS (Evitar error de SQL con strings vacíos)
        $fecha_nac = !empty($_POST["per_fecha_nacimiento"]) ? $_POST["per_fecha_nacimiento"] : null;
        $fecha_cont = !empty($_POST["emp_fecha_contratacion"]) ? $_POST["emp_fecha_contratacion"] : null;
        $fecha_fin  = !empty($_POST["emp_fecha_fin_contrato"]) ? $_POST["emp_fecha_fin_contrato"] : null;

        /* --- VALIDACIÓN: CREAR O EDITAR --- */
        if (empty($_POST["usu_id"])) {
            
            // --- INSERTAR NUEVO USUARIO ---
            $usuario->insert_usuario(
                $_POST["sucursal_id"], // Viene del input hidden o sesión
                $_POST["per_primer_nombre"],
                $_POST["per_segundo_nombre"],
                $_POST["per_primer_apellido"],
                $_POST["per_segundo_apellido"],
                $_POST["per_cedula"],
                $_POST["per_telefono"],
                $_POST["per_correo"],
                $_POST["per_direccion"],
                $fecha_nac,
                $_POST["emp_tipo_contrato"],
                $_POST["emp_salario"],
                $fecha_cont,
                // Nota: Insert no suele llevar fecha fin (es activo por defecto)
                $_POST["usu_nombre"], // Username
                $usu_pass,            // Contraseña ya hasheada
                $_POST["rol_id"],
                $usu_img
            );
            echo "Creado";

        } else {
            
            // --- ACTUALIZAR USUARIO EXISTENTE ---
            $usuario->update_usuario(
                $_POST["usu_id"],
                $_POST["sucursal_id"],
                $_POST["per_primer_nombre"],
                $_POST["per_segundo_nombre"],
                $_POST["per_primer_apellido"],
                $_POST["per_segundo_apellido"],
                $_POST["per_cedula"],
                $_POST["per_telefono"],
                $_POST["per_correo"],
                $_POST["per_direccion"],
                $fecha_nac,
                $_POST["emp_tipo_contrato"],
                $_POST["emp_salario"],
                $fecha_cont,
                $fecha_fin,           // En Update SÍ enviamos fecha fin (para desactivar)
                $_POST["usu_nombre"],
                $usu_pass,            // Si está vacío, el SP mantiene la anterior
                $_POST["rol_id"],
                $usu_img              // Si está vacío, el SP mantiene la anterior
            );
            echo "Actualizado";
        }
        break;
    /* TODO: Guardar y editar, guardar cuando el ID este vacio, y Actualizar cuando se envie el ID */
    /*
    case "guardaryeditar":
        if (empty($_POST["usu_id"])) {

            
            if ($_FILES["usu_img"]["name"] != '') {
                $usu_img = $usuario->upload_image(); // Llamar a la función para cargar la imagen
            } else {
                $usu_img = null; // Si no se sube una imagen, asignar null
            }

            $usuario->insert_usuario(
                $_POST["suc_id"],
                $_POST["usu_correo"],
                $_POST["usu_nom"],
                $_POST["usu_ape"],
                $_POST["usu_dni"],
                $_POST["usu_telf"],
                $_POST["usu_pass"],
                $_POST["rol_id"],
                $usu_img
            );
        } else {
            if ($_FILES["usu_img"]["name"] != '') {
                $usu_img = $usuario->upload_image(); // Llamar a la función para cargar la imagen
            } else {
                $usu_img = null; // Si no se sube una imagen, asignar null
            }
            $usuario->update_usuario(
                $_POST["usu_id"],
                $_POST["suc_id"],
                $_POST["usu_correo"],
                $_POST["usu_nom"],
                $_POST["usu_ape"],
                $_POST["usu_dni"],
                $_POST["usu_telf"],
                $_POST["usu_pass"],
                $_POST["rol_id"],
                $usu_img
            );

            /*
            if(!empty($_POST["usu_img"])){
                echo "la imagen no esta vacia";
                $_SESSION["USU_IMG"] = $_POST["usu_img"];
            }

            header("Refresh:0"); // Recarga la página 
            exit();
            */
    /* }
        break;*/

    /* TODO: Listado de registros formato JSON para Datatable JS */
    /*
    case "listar":
        $datos = $usuario->get_usuario_x_suc_id($_POST["suc_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();

            if ($row["USU_IMG"] != '') {
                $sub_array[] =
                    "<div class='d-flex align-items-center'>" .
                    "<div class='flex-shrink-0 me-2'>" .
                    "<img src='../../assets/usuario/" . $row["USU_IMG"] . "' alt='' class='avatar-xs rounded-circle'>" .
                    "</div>" .
                    "</div>";
            } else {
                $sub_array[] =
                    "<div class='d-flex align-items-center'>" .
                    "<div class='flex-shrink-0 me-2'>" .
                    "<img src='../../assets/usuario/no_imagen.png' alt='' class='avatar-xs rounded-circle'>" .
                    "</div>" .
                    "</div>";
            }
            $sub_array[] = $row["USU_CORREO"];
            $sub_array[] = $row["USU_NOM"];
            $sub_array[] = $row["USU_APE"];
            $sub_array[] = $row["USU_DNI"];
            $sub_array[] = $row["USU_TELF"];
            $sub_array[] = $row["USU_PASS"];
            $sub_array[] = $row["ROL_NOM"];
            $sub_array[] = date("d-m-Y", strtotime($row["FECH_CREA"]))." ".date("h:i:s", strtotime($row["FECH_CREA"])) ;;
            $sub_array[] = '<button type="button" onClick="editar(' . $row["USU_ID"] . ')" id="' . $row["USU_ID"] . '" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-edit-2-line"></i></button>';
            $sub_array[] = '<button type="button" onClick="eliminar(' . $row["USU_ID"] . ')" id="' . $row["USU_ID"] . '" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i></button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;
*/
    /* TODO:Mostrar informacion de registro segun su ID */
    /*
    case "mostrar":
        $datos = $usuario->get_usuario_x_usu_id($_POST["usu_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["USU_ID"] = $row["USU_ID"];
                $output["SUC_ID"] = $row["SUC_ID"];
                $output["USU_NOM"] = $row["USU_NOM"];
                $output["USU_APE"] = $row["USU_APE"];
                $output["USU_CORREO"] = $row["USU_CORREO"];
                $output["USU_DNI"] = $row["USU_DNI"];
                $output["USU_TELF"] = $row["USU_TELF"];
                $output["USU_PASS"] = $row["USU_PASS"];
                $output["ROL_ID"] = $row["ROL_ID"];
                if ($row["USU_IMG"] != '') {
                    $output["USU_IMG"] = '<img src="../../assets/usuario/' . $row["USU_IMG"] . '" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"></img><input type="hidden" name="hidden_usuario_imagen" value="' . $row["USU_IMG"] . '" />';
                } else {
                    $output["USU_IMG"] = '<img src="../../assets/usuario/no_imagen.png" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"></img><input type="hidden" name="hidden_usuario_imagen" value="" />';
                }
            }
            echo json_encode($output);
        }
        break;
*/
    /* TODO: Cambiar Estado a 0 del Registro */
    case "eliminar";
        $usuario->delete_usuario($_POST["usu_id"]);
        break;
    /* TODO:Actualizar contraseña del Usuario */
    case 'actualizar_contrasenia':
        // Recibir datos del JS
        $usu_id   = $_POST["usu_id"];
        $pass_old = $_POST["pass_old"]; // La que escribió el usuario
        $pass_new = $_POST["pass_new"]; // La nueva

        // Obtener la contraseña REAL que está en la base de datos actualmente
        $datos_usuario = $usuario->get_usuario_x_usu_id($usu_id);

        if (empty($datos_usuario)) {
            echo json_encode(["success" => false, "message" => "Usuario no encontrado."]);
            break;
        }
        // Si encuentra el usuario:
        $pass_en_bd = $datos_usuario[0]['CONTRASENIA'];

        // ¿La contraseña actual coincide con la de la BD?
        if ($pass_old != $pass_en_bd) {
            echo json_encode(["success" => false, "message" => "La contraseña anterior es incorrecta."]);
            break;
        }

        /* // OPCIÓN B: Si usas Hash (RECOMENDADO - password_verify)
    if (!password_verify($pass_old, $pass_en_bd)) {
         echo json_encode(["success" => false, "message" => "La contraseña actual es incorrecta."]);
         break;
    }
    */

        // Si pasó la validación anterior, llamamos a tu SP de actualizar
        // Si usas hash, recuerda encriptar la nueva: $new_hased = password_hash($pass_new, PASSWORD_DEFAULT);

        $resultado = $usuario->update_usuario_pass($usu_id, $pass_new);
        if ($resultado) {
            echo json_encode(["success" => true, "message" => "Contraseña actualizada exitosamente."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar en BD."]);
        }
        break;
    //LLenar los cards con los usuarios de la sucursal
    case "listar_cards":
        $suc_id = isset($_POST['suc_id']) ? $_POST['suc_id'] : '';

        // Llamamos al modelo usando el método que ejecuta tu SP: SP_L_USUARIO_BY_SUCURSAL_ID
        $datos = $usuario->get_usuario_x_suc_id($suc_id);

        // Limpiamos buffer y enviamos JSON puro
        header('Content-Type: application/json');
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
        break;
/*
    case "guardaryeditar":

        // 1. LÓGICA DE LA IMAGEN
        $imagen = "";
        if (!empty($_FILES['profile-img-file-input']['name'])) {
            // Si el usuario subió una nueva imagen
            $upload_dir = "../assets/usuario/";
            $ext = pathinfo($_FILES['profile-img-file-input']['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . "." . $ext; // Nombre único para evitar colisiones

            if (move_uploaded_file($_FILES['profile-img-file-input']['tmp_name'], $upload_dir . $filename)) {
                $imagen = $filename;
            }
        } else {
            // Si estamos editando y no subió imagen, usamos la que ya tenía (esto se maneja en el SP o en la lógica del IF abajo)
            // Si es $_POST["imagen_hidden"] quien trae el nombre anterior
            $imagen = isset($_POST["imagen_oculta"]) ? $_POST["imagen_oculta"] : "";
        }

        // 2. LÓGICA DE LA CONTRASEÑA
        $pass_final = "";
        if (empty($_POST["usu_id"])) {
            // CASO: NUEVO USUARIO -> La contraseña es obligatoria y se encripta
            $pass_final = password_hash($_POST["contrasenia"], PASSWORD_DEFAULT);
        } else {
            // CASO: EDITAR USUARIO
            if (empty($_POST["contrasenia"])) {
                // Si está vacío, dejamos la variable vacía para indicar al modelo que NO actualice este campo
                $pass_final = "";
            } else {
                // Si escribió algo, lo encriptamos para actualizar
                $pass_final = password_hash($_POST["contrasenia"], PASSWORD_DEFAULT);
            }
        }

        /* ===================================================
           ENVIAR AL MODELO
        =================================================== */
        /*
        if (empty($_POST["usu_id"])) {
            /* --- CREAR NUEVO --- */
            /*
            $usuario->insert_usuario(
                // Datos Persona
                $_POST["primer_nombre"],
                $_POST["segundo_nombre"],
                $_POST["primer_apellido"],
                $_POST["segundo_apellido"],
                $_POST["correo"],
                $_POST["telefono"],
                $_POST["cedula"],
                $_POST["fecha_nacimiento"],
                $_POST["direccion"],
                // Datos Empleado (Asumiendo estos campos en tu form)
                $_POST["sucursal_id"],
                $_POST["emp_salario"], // Asegúrate de tener este name en el HTML
                $_POST["emp_fecha_contratacion"], // Asegúrate de tener este name en el HTML
                // Datos Usuario
                $_POST["rol_id"],
                $_POST["username"],
                $pass_final, // Contraseña ya hasheada
                $imagen
            );
            echo "Creado"; // Mensaje simple para AJAX

        } else {
            /* --- EDITAR EXISTENTE --- */
        /*
            $usuario->update_usuario(
                $_POST["usu_id"],
                // Datos Persona
                $_POST["primer_nombre"],
                $_POST["segundo_nombre"],
                $_POST["primer_apellido"],
                $_POST["segundo_apellido"],
                $_POST["correo"],
                $_POST["telefono"],
                $_POST["cedula"],
                $_POST["fecha_nacimiento"],
                $_POST["direccion"],
                // Datos Empleado
                $_POST["sucursal_id"],
                $_POST["emp_salario"],
                $_POST["emp_fecha_contratacion"],
                // Datos Usuario
                $_POST["rol_id"],
                $_POST["username"],
                $pass_final, // Si está vacío, el modelo sabrá no tocarlo
                $imagen
            );
            echo "Actualizado";
        }
        break;
*/
    case "mostrar":
    $datos = $usuario->get_usuario_x_id($_POST["usu_id"]);
    
    if (is_array($datos) == true and count($datos) > 0) {
        foreach ($datos as $row) {
            $output["usu_id"] = $row["USU_ID"];
            
            // Persona
            $output["per_primer_nombre"] = $row["PER_PRIMER_NOMBRE"];
            $output["per_segundo_nombre"] = $row["PER_SEGUNDO_NOMBRE"];
            $output["per_primer_apellido"] = $row["PER_PRIMER_APELLIDO"];
            $output["per_segundo_apellido"] = $row["PER_SEGUNDO_APELLIDO"];
            $output["per_cedula"] = $row["PER_CEDULA"];
            $output["per_telefono"] = $row["PER_TELEFONO"];
            $output["per_correo"] = $row["PER_CORREO"];
            $output["per_direccion"] = $row["PER_DIRECCION"];
            // Formato Fecha para inputs date (YYYY-MM-DD)
            $output["per_fecha_nacimiento"] = $row["PER_FECHA_NACIMIENTO"];

            // Empleado
            $output["emp_salario"] = $row["EMP_SALARIO"];
            $output["emp_tipo_contrato"] = $row["TIPO_CONTRATO_ID"];
            $output["emp_fecha_contratacion"] = $row["EMP_FECHA_CONTRATACION"];
            
            if($row["EMP_FECHA_FIN_CONTRATO"]){
                $output["emp_fecha_fin_contrato"] = $row["EMP_FECHA_FIN_CONTRATO"];
            } else {
                $output["emp_fecha_fin_contrato"] = "";
            }

            // Usuario
            $output["usu_username"] = $row["USU_USERNAME"];
            $output["rol_id"] = $row["ROL_ID"];
            $output["rol_nombre"] = $row["ROL_NOMBRE"];
            $output["sucursal_id"] = $row["SUCURSAL_ID"];
            $output["usu_imagen"] = $row["USU_IMAGEN"];

             $output["suc_nombre"] = $row["SUC_NOMBRE"];
             $output["suc_nombre"] = $row["SUC_NOMBRE"];
        }
        echo json_encode($output);
    }
    break;
    
}
