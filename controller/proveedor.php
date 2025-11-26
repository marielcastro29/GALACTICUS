<?php
/* TODO: Llamando Clases */
require_once("../config/conexion.php");
require_once("../models/Proveedor.php");
/* TODO: Inicializando clase */
$proveedor = new Proveedor();

switch ($_GET["op"]) {
   /* TODO: Guardar y editar, guardar cuando el ID este vacio, y Actualizar cuando se envie el ID */
case "guardaryeditar":
    
    $tipo_persona_id = $_POST["tipo_persona"];
    $sucursal_id = $_POST["sucursal_id"];
    $primer_nombre = $_POST["primer_nombre"]; // Nombre (Natural) o Razón Social (Jurídica)
    $segundo_nombre = isset($_POST["segundo_nombre"]) ? $_POST["segundo_nombre"] : null;
    $primer_apellido = isset($_POST["primer_apellido"]) ? $_POST["primer_apellido"] : null;
    $segundo_apellido = isset($_POST["segundo_apellido"]) ? $_POST["segundo_apellido"] : null;
    $ruc = isset($_POST["ruc"]) ? $_POST["ruc"] : null; 
    $cedula = isset($_POST["cedula"]) ? $_POST["cedula"] : null; 
    $fecha_nacimiento = isset($_POST["fecha_nacimiento"]) ? $_POST["fecha_nacimiento"] : null;
    $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : null;
    $correo = isset($_POST["correo"]) ? $_POST["correo"] : null;
    $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : null;
    
    
    if (empty($_POST["prov_id"])) {
        // --- INSERCIÓN (ID está vacío) ---
        $proveedor->insert_proveedor(
            $tipo_persona_id,
            $primer_nombre,
            $segundo_nombre,
            $primer_apellido,
            $segundo_apellido,
            $ruc,
            $cedula,
            $fecha_nacimiento,
            $telefono,
            $correo,
            $direccion,
            $sucursal_id
        );
    } else {
        $proveedor->update_proveedor(
            $_POST["prov_id"], // ID del proveedor que se actualiza
            $tipo_persona_id,
            $primer_nombre,
            $segundo_nombre,
            $primer_apellido,
            $segundo_apellido,
            $ruc,
            $cedula,
            $fecha_nacimiento,
            $telefono,
            $correo,
            $direccion,
            $sucursal_id
        );
    }
    break;

    /* TODO: Listado de registros formato JSON para Datatable JS */
    case "listar":
        $datos = $proveedor->get_proveedor_x_suc_id($_POST["suc_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["NOMBRE_COMPLETO"];

            if ($row["TIPO_ENTIDAD"] === 'Jurídica') {
                $tipo_id = 'RUC';
                $numero_id = $row["RUC"];
                $clase_badge = 'bg-primary';
            } else {
                $tipo_id = 'CÉDULA';
                $numero_id = $row["CEDULA"];
                $clase_badge = 'bg-success';
            }

            $identificacion_html =
                "<span class='badge rounded-pill " . $clase_badge . "'>" . $tipo_id . "</span>"." ".$numero_id;
            $sub_array[] = $identificacion_html; 
            $sub_array[] = $row["TELEFONO"];
            $sub_array[] = $row["CORREO"];
            $sub_array[] = $row["DIRECCION"];
            $sub_array[] = '<button type="button" onClick="editar(' . $row["PROVEEDOR_ID"] . ')" id="' . $row["PROVEEDOR_ID"] . '" class="btn btn-warning btn-icon waves-effect waves-light"><i class="ri-edit-2-line"></i></button>';
            $sub_array[] = '<button type="button" onClick="eliminar(' . $row["PROVEEDOR_ID"] . ')" id="' . $row["PROVEEDOR_ID"] . '" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i></button>';
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
    /*
    case "mostrar":
        $datos = $proveedor->get_proveedor_x_prov_id($_POST["prov_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["PROV_ID"] = $row["PROV_ID"];
                $output["EMP_ID"] = $row["EMP_ID"];
                $output["PROV_NOM"] = $row["PROV_NOM"];
                $output["PROV_RUC"] = $row["PROV_RUC"];
                $output["PROV_TELF"] = $row["PROV_TELF"];
                $output["PROV_DIRECC"] = $row["PROV_DIRECC"];
                $output["PROV_CORREO"] = $row["PROV_CORREO"];
            }
            echo json_encode($output);
        }
        break;
        */
    case "mostrar":
    // El método get_proveedor_x_prov_id ejecuta el SP_L_PROVEEDOR_BY_ID y devuelve un array.
    $datos = $proveedor->get_proveedor_x_prov_id($_POST["prov_id"]);
    
    // Verificamos que se haya encontrado el proveedor.
    if (is_array($datos) && count($datos) > 0) {
        // array_shift() extrae el primer (y único) array asociativo del resultado.
        $output = array_shift($datos);
        
        // $output ahora tiene todas las claves del SP (PROV_ID, PRIMER_NOMBRE, TIPO_ENTIDAD, TIPO_PERSONA_ID, etc.)
        // y se envía directamente al frontend.
        echo json_encode($output);
    }
    break;

    /* TODO: Cambiar Estado a 0 del Registro */
    case "eliminar";
        $proveedor->delete_proveedor($_POST["prov_id"]);
        break;
    /* TODO: Listado de Proveedor combobox */
    /*
    case "combo";
        $datos = $proveedor->get_proveedor_x_emp_id($_POST["emp_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            $html = "";
            $html .= "<option value='0' selected>Seleccionar</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["PROV_ID"] . "'>" . $row["PROV_NOM"] . "</option>";
            }
            echo $html;
        }
        break;
        */
}
