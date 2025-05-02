<?php
/* TODO: Llamando Clases */
require_once("../config/conexion.php");
require_once("../models/Usuario.php");
/* TODO: Inicializando clase */
$usuario = new Usuario();

switch ($_GET["op"]) {
    /* TODO: Guardar y editar, guardar cuando el ID este vacio, y Actualizar cuando se envie el ID */
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
        }
        break;

    /* TODO: Listado de registros formato JSON para Datatable JS */
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

    /* TODO:Mostrar informacion de registro segun su ID */
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

    /* TODO: Cambiar Estado a 0 del Registro */
    case "eliminar";
        $usuario->delete_usuario($_POST["usu_id"]);
        break;
    /* TODO:Actualizar contraseña del Usuario */
    case "actualizar";
        $usuario->update_usuario_pass($_POST["usu_id"], $_POST["usu_pass"]);
        break;
}
