<?php
/* TODO: Llamando Clases */
require_once("../config/conexion.php");
require_once("../models/Producto.php");
/* TODO: Inicializando clase */
$producto = new Producto();

switch ($_GET["op"]) {
    /* TODO: Guardar y editar, guardar cuando el ID este vacio, y Actualizar cuando se envie el ID */
    case "guardaryeditar":
        if (empty($_POST["prod_id"])) {
            /*
           $suc_id,$cat_id,$prod_nom,$prod_descrip,
                                        $mon_id,$prod_pventa,
                                        $prov_id,$prod_img
            */

            if ($_FILES["prod_img"]["name"] != '') {
                $prod_img = $producto->upload_image(); // Llamar a la función para cargar la imagen
            } else {
                $prod_img = null; // Si no se sube una imagen, asignar null
            }

            $producto->insert_producto(
                $_POST["suc_id"],
                $_POST["cat_id"],
                $_POST["prod_nom"],
                $_POST["prod_descrip"],
                $_POST["mon_id"],
                $_POST["prod_pventa"],
                $_POST["prov_id"],
                $prod_img
            );
        } else {
            /*
                $prod_id,$suc_id,$cat_id,
                                        $prod_nom,$prod_descrip,$prov_id,
                                        $mon_id,$prod_pventa, $prod_img)
                */

            if ($_FILES["prod_img"]["name"] != '') {
                $prod_img = $producto->upload_image(); // Llamar a la función para cargar la imagen
            } else {
                $prod_img = null; // Si no se sube una imagen, asignar null
            }

            $producto->update_producto(
                $_POST["prod_id"],
                $_POST["suc_id"],
                $_POST["cat_id"],
                $_POST["prod_nom"],
                $_POST["prod_descrip"],
                $_POST["prov_id"],
                $_POST["mon_id"],
                $_POST["prod_pventa"],
                $prod_img
            );
        }
        break;

    /* TODO: Listado de registros formato JSON para Datatable JS */
    case "listar":
        $datos = $producto->get_producto_x_suc_id($_POST["suc_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();

            if ($row["PROD_IMG"] != '') {
                $sub_array[] =
                    "<div class='d-flex align-items-center'>" .
                    "<div class='flex-shrink-0 me-2'>" .
                    "<img src='../../assets/producto/" . $row["PROD_IMG"] . "' alt='' class='avatar-xs rounded-circle'>" .
                    "</div>" .
                    "</div>";
            } else {
                $sub_array[] =
                    "<div class='d-flex align-items-center'>" .
                    "<div class='flex-shrink-0 me-2'>" .
                    "<img src='../../assets/producto/no_imagen.png' alt='' class='avatar-xs rounded-circle'>" .
                    "</div>" .
                    "</div>";
            }

            $sub_array[] = $row["PROD_NOM"];
            $sub_array[] = $row["CAT_NOM"];
            $sub_array[] = $row["PROV_NOM"];
            $sub_array[] = $row["MON_SIMBOLO"] . " " . $row["PRECIO_VENTA"];
            $sub_array[] = $row["PROD_STOCK"];
            $sub_array[] = '<button type="button" onClick="editar(' . $row["PROD_ID"] . ')" id="' . $row["PROD_ID"] . '" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-edit-2-line"></i></button>';
            $sub_array[] = '<button type="button" onClick="eliminar(' . $row["PROD_ID"] . ')" id="' . $row["PROD_ID"] . '" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i></button>';
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

    case "mostrar":
        $datos=$producto->get_producto_x_prod_id($_POST["prod_id"]);
        if (is_array($datos)==true and count($datos)>0){
            foreach($datos as $row){                
                $output["PROD_ID"] = $row["PROD_ID"];
                $output["CAT_ID"] = $row["CAT_ID"];
                $output["PROD_NOM"] = $row["PROD_NOM"];
                $output["PROD_DESCRIP"] = $row["PROD_DESCRIP"];
                $output["MON_ID"] = $row["MON_ID"];
                $output["PROV_ID"] = $row["PROV_ID"];
                $output["PROD_PVENTA"] = $row["PRECIO_VENTA"];
                $output["PROD_STOCK"] = $row["PROD_STOCK"];
                if($row["PROD_IMG"] != ''){
                    $output["PROD_IMG"] = '<img src="../../assets/producto/'.$row["PROD_IMG"].'" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"></img><input type="hidden" name="hidden_producto_imagen" value="'.$row["PROD_IMG"].'" />';
                }else{
                    $output["PROD_IMG"] = '<img src="../../assets/producto/no_imagen.png" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"></img><input type="hidden" name="hidden_producto_imagen" value="" />';
                }

            }
            echo json_encode($output);
        }
        break;

    /* TODO: Cambiar Estado a 0 del Registro */
    case "eliminar";
        $producto->delete_producto($_POST["prod_id"]);
        break;
    /* TODO: Listado de Productos */
    case "combo";
        $datos = $producto->get_producto_x_cat_id($_POST["cat_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            $html = "";
            $html .= "<option selected>Seleccionar</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["PROD_ID"] . "'>" . $row["PROD_NOM"] . "</option>";
            }
            echo $html;
        }
        break;
    /* TODO: Listar consumo de Productos */
    case "get_info_producto":

        $producto = new Producto();

        $datos = $producto->get_info_producto($_POST["prod_id"]);

        echo json_encode($datos);
        break;
}
