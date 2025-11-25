<?php
/* TODO: Llamando Clases */
require_once("../config/conexion.php");
require_once("../models/Sucursal.php");
/* TODO: Inicializando clase */
$sucursal = new Sucursal();

switch ($_GET["op"]) {
    /* TODO: Guardar y editar, guardar cuando el ID este vacio, y Actualizar cuando se envie el ID */
    case "guardaryeditar":
        if (empty($_POST["suc_id"])) {//$suc_nom, $suc_dir, $suc_tel, $suc_cor
            $sucursal->insert_sucursal($_POST["suc_nom"],$_POST["suc_dir"],$_POST["suc_tel"],$_POST["suc_cor"] );
        } else {
            $sucursal->update_sucursal($_POST["suc_id"], $_POST["suc_nom"],$_POST["suc_dir"],$_POST["suc_tel"],$_POST["suc_cor"]);
        }
        break;

    /* TODO: Listado de registros formato JSON para Datatable JS */
    case "listar":
        $datos = $sucursal->get_sucursal();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["NOMBRE"];
            $sub_array[] = $row["CORREO"];
            $sub_array[] = $row["TELEFONO"];
            $sub_array[] = $row["DIRECCION"];
            $sub_array[] = $row["FECHA_CREACION"];
            $sub_array[] = '<button type="button" onClick="editar(' . $row["ID"] . ')" id="' . $row["ID"] . '" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-edit-2-line"></i></button>';
            $sub_array[] = '<button type="button" onClick="eliminar(' . $row["ID"] . ')" id="' . $row["ID"] . '" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i></button>';
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
        $datos = $sucursal->get_sucursal_x_suc_id($_POST["suc_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["SUC_ID"] = $row["ID"];
                $output["SUC_NOM"] = $row["NOMBRE"];
                $output["SUC_COR"] = $row["CORREO"];
                $output["SUC_TEL"] = $row["TELEFONO"];
                $output["SUC_DIR"] = $row["DIRECCION"];
            }
            echo json_encode($output);
        }
        break;

    /* TODO: Cambiar Estado a 0 del Registro */
    case "eliminar";
        $sucursal->delete_sucursal($_POST["suc_id"]);
        break;
    /* TODO: Listar Combo */
    case "combo";
        $datos = $sucursal->get_sucursal();
        if (is_array($datos) == true and count($datos) > 0) {
            $html = "";
            $html .= "<option selected>Seleccionar</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["ID"] . "'>" . $row["NOMBRE"] . "</option>";
            }
            echo $html;
        }
        break;
}
