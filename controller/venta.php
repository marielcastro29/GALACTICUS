<?php
/* TODO: Llamando Clases */
require_once("../config/conexion.php");
require_once("../models/Venta.php");
/* TODO: Inicializando clase */
$venta = new Venta();

switch ($_GET["op"]) {

    case "registrar":
        //$suc_id, $usu_id, $doc_id, $pag_id, $mon_id, $cli_id, $vent_coment
        $id_venta = $venta->insert_venta(
            $_POST["suc_id"],
            $_POST["usu_id"],
            $_POST["doc_id"],
            $_POST["pag_id"],
            $_POST["mon_id"],
            $_POST["cli_id"],
            $_POST["vent_coment"]
        );

        echo "ID VENTA: " . $id_venta;

        if (!empty($id_venta)) {

            echo "ID COMPRA NO ESTA VACIO: " . $id_venta;

            if (isset($_POST["productos"])) {

                $productos = json_decode($_POST["productos"], true);

                echo "ARREGLOS PRODUCTOS NO ESTA VACIO: ";

                foreach ($productos as $producto) {

                    $prod_id = $producto["prod_id"];
                    echo "PRODUCTO ID: " . $prod_id;

                    $precio_venta = $producto["precio_venta"];
                    echo "PRECIO DE VENTA PRODUCTO: " . $precio_venta;

                    $cantidad = $producto["cantidad"];
                    echo "CANTIDAD DE COMPRA PRODUCTO: " . $cantidad;

                    //$vent_id,$prod_id,$prod_pventa,$detv_cant
                    $venta->insert_detalle_venta($id_venta, $prod_id, $precio_venta, $cantidad);
                }
            }
        }

        break;
    case "calculo":
        $datos = $venta->get_venta_calculo($_POST["vent_id"]);
        foreach ($datos as $row) {
            $output["VENT_SUBTOTAL"] = $row["Subtotal"];
            $output["VENT_IVA"] = $row["IVA"];
            $output["VENT_TOTAL"] = $row["TOTAL"];
        }
        echo json_encode($output);
        break;
    /* TODO: Eliminar detalle */
    case "eliminardetalle":
        $venta->delete_venta_detalle($_POST["detv_id"]);
        break;
    /* TODO: Listar detalle de venta  */
    case "listardetalle":
        $datos = $venta->get_venta_detalle($_POST["vent_id"]);
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
            $sub_array[] = $row["CAT_NOM"];
            $sub_array[] = $row["PROD_NOM"];
            $sub_array[] = $row["MON_SIMBOLO"] . " " . $row["PROD_PVENTA"];
            $sub_array[] = $row["DETV_CANT"];
            $sub_array[] = $row["MON_SIMBOLO"] . " " . ($row["PROD_PVENTA"] * $row["DETV_CANT"]);
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
    /* TODO: Listar formato de detalle de venta por ID */
    case "listardetalleformato";
        $datos = $venta->get_venta_detalle($_POST["vent_id"]);
        foreach ($datos as $row) {
?>
            <tr>
                <td>
                    <?php
                    if ($row["PROD_IMG"] != '') {
                    ?>
                        <?php
                        echo "<div class='d-flex align-items-center'>" .
                            "<div class='flex-shrink-0 me-2'>" .
                            "<img src='../../assets/producto/" . $row["PROD_IMG"] . "' alt='' class='avatar-xs rounded-circle'>" .
                            "</div>" .
                            "</div>";
                        ?>
                    <?php
                    } else {
                    ?>
                        <?php
                        echo "<div class='d-flex align-items-center'>" .
                            "<div class='flex-shrink-0 me-2'>" .
                            "<img src='../../assets/producto/no_imagen.png' alt='' class='avatar-xs rounded-circle'>" .
                            "</div>" .
                            "</div>";
                        ?>
                    <?php
                    }
                    ?>
                </td>
                <td><?php echo $row["CAT_NOM"]; ?></td>
                <td><?php echo $row["PROD_NOM"]; ?></td>
                <td><?php echo $row["PROD_PVENTA"]; ?></td>
                <td><?php echo $row["DETV_CANT"]; ?></td>
            </tr>
            <?php
        }
        break;
    /* TODO: Mostrar informacion de venta por ID */
    case "mostrar":
        $datos = $venta->get_view_venta($_POST["vent_id"]);
        foreach ($datos as $row) {
            $output["SUC_NOM"] = $row["SUC_NOM"];
            // echo "SUC_NOM: ". $row["SUC_NOM"];

            $output["SUC_CORREO"] = $row["SUC_CORREO"];
            // echo "SUC_CORREO: ". $row["SUC_CORREO"];

            $output["SUC_TELEFONO"] = $row["SUC_TELEFONO"];
            // echo "SUC_TELEFONO: ". $row["SUC_TELEFONO"];

            $output["SUC_DIRECCION"] = $row["SUC_DIRECCION"];
            // echo "SUC_DIRECCION: ". $row["SUC_DIRECCION"];

            $output["VENT_ID"] = $row["VENT_ID"];
            // echo "VENT_ID: ". $row["VENT_ID"];

            $output["FECHA"] = date("d-m-Y", strtotime($row["FECHA"]));
            // echo "FECHA: ". $row["FECHA"];


            $output["PAG_NOM"] = $row["PAG_NOM"];
            //  echo "PAG_NOM: ". $row["PAG_NOM"];

            $output["CLI_NOM"] = $row["CLI_NOM"];
            // echo "CLI_NOM: ". $row["CLI_NOM"];

            $output["CLI_RUC"] = $row["CLI_RUC"];
            //echo "CLI_RUC: ". $row["CLI_RUC"];

            $output["CLI_DIRECC"] = $row["CLI_DIRECC"];
            //  echo "CLI_DIRECC: ". $row["CLI_DIRECC"];

            $output["CLI_CORREO"] = $row["CLI_CORREO"];
            // echo "CLI_CORREO: ". $row["CLI_CORREO"];

            $output["USU_NOM"] = $row["USU_NOM"];
            // echo "USU_NOM: ". $row["USU_NOM"];

            $output["USU_APE"] = $row["USU_APE"];
            // echo "USU_APE: ". $row["USU_APE"];

            $output["MON_SIMBOLO"] = $row["MON_SIMBOLO"];
            // echo "MON_SIMBOLO: ". $row["MON_SIMBOLO"];

            $output["MON_NOM"] = $row["MON_NOM"];
            //  echo "MON_NOM: ". $row["MON_NOM"];

            $output["MON_NOM"] = $row["MON_NOM"];
            // echo "MON_NOM: ". $row["MON_NOM"];

            $output["VENT_TOTAL"] = $row["VENT_TOTAL"];

            $output["VENT_COMENT"] = $row["VENT_COMENT"];

            $output["MON_SIMBOLO"] = $row["MON_SIMBOLO"];
        }
        echo json_encode($output);
        break;
    /* TODO: Listar venta por sucursal */
    case "listarventa":
        $datos = $venta->get_venta_listado($_POST["suc_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = "V-" . (($row["VENT_ID"] > 0 && $row["VENT_ID"] < 10) ? "0" : "") . $row["VENT_ID"]; //No. Venta
            /*
                                                           <th>No. Venta</th>
                                                <th>Fecha</th>
                                                <th>Tipo Pago</th>
                                                <th>Subtotal</th>
                                                <th>IVA</th>
                                                <th>Total</th>
                                                <th>Comentario</th>
                                                <th>Cliente</th>
                                                <th>Usuario</th>
            */
            $sub_array[] = date("d-m-Y", strtotime($row["FECH_CREA"])); //Fecha
            $sub_array[] = $row["PAG_NOM"]; //Tipo Pago
            $sub_array[] = $row["MON_SIMBOLO"] . " " . $row["SUBTOTAL"]; //Subtotal
            $sub_array[] = $row["MON_SIMBOLO"] . " " . round(($row["SUBTOTAL"] * 0.15), 2); //IVA
            $sub_array[] = $row["MON_SIMBOLO"] . " " . round(($row["SUBTOTAL"]) + ($row["SUBTOTAL"] * 0.15), 2); //Total
            $sub_array[] = $row["VENT_COMENT"]; //Comentario
            $sub_array[] = $row["CLI_NOM"]; //Cliente
            //Usuario
            if ($row["USU_IMG"] != '') {
                $sub_array[] =
                    "<div class='d-flex flex-column align-items-center'>" .
                    "<div class='flex-shrink-0 me-2'>" .
                    "<img src='../../assets/usuario/" . $row["USU_IMG"] . "' alt='' class='avatar-xs rounded-circle'>" .
                    "</div>" .
                    "<div class='flex-shrink-0 me-2 mt-2''>" .
                    "<p>" . $row["USU_NOM"] . " " . $row["USU_APE"] . "</p>" .
                    "</div>" .
                    "</div>";
            } else {
                $sub_array[] =
                    "<div class='d-flex flex-column align-items-center'>" .
                    "<div class='flex-shrink-0 me-2'>" .
                    "<img src='../../assets/usuario/no_imagen.png' alt='' class='avatar-xs rounded-circle'>" .
                    "</div>" .
                    "<div class='flex-shrink-0 me-2 mt-2''>" .
                    "<p>" . $row["USU_NOM"] . " " . $row["USU_APE"] . "</p>" .
                    "</div>" .
                    "</div>";
            }
            //$sub_array[] = '<a href="../ViewVenta/?v=' . $row["VENT_ID"] . '" target="_blank" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-printer-line"></i></a>';
            //<button type="button" class="btn btn-info waves-effect waves-light">Info</button>
            $sub_array[] = '<button type="button" onClick="redireccionarDocumento(' . $row["VENT_ID"] . ')" id="' . $row["VENT_ID"] . '" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-eye-line"></i></button>';
            $sub_array[] = '<button type="button" onClick="ver(' . $row["VENT_ID"] . ')" id="' . $row["VENT_ID"] . '" class="btn btn-primary btn-info waves-effect waves-light"><i class="ri-settings-2-line"></i></button>';
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
    /* TODO: Listar to5 productos mas vendidos */
    case "listartopproducto":
        $datos = $venta->get_venta_top_productos($_POST["suc_id"]);
        if (!empty($datos)) {
            foreach ($datos as $row) {
            ?>
                <li class="list-group-item">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0 me-3">
                            <div>
                                <?php
                                $img = ($row["PROD_IMG"] != '') ? $row["PROD_IMG"] : 'no_imagen.png';
                                echo "<img class='image avatar-xs rounded-circle' alt='' src='../../assets/producto/$img'>";
                                ?>
                            </div>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <h5 class="contact-name fs-13 mb-1">
                                <a href="#" class="link text-dark"><?php echo $row["PROD_NOM"]; ?></a>
                            </h5>
                            <p class="contact-born text-muted mb-0">
                                Categoría: <?php echo $row["CAT_NOM"]; ?> | Cant: <?php echo $row["CANT"]; ?> | Stock: <?php echo $row["PROD_STOCK"]; ?>
                            </p>
                        </div>
                        <div class="flex-shrink-0 ms-2">
                            <div class="fs-11 text-muted">
                                <?php echo $row["MON_NOM"] . ' ' . $row["TOTAL"]; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php
            }
        } else {
            ?>
            <li class="list-group-item text-center text-muted">
                Sin productos vendidos
            </li>
            <?php
        }
        break;


    case "montosemanal":
        $datos = $venta->get_monto_semanal($_POST["suc_id"]);
        if (!empty($datos)) {
            foreach ($datos as $row) {
            ?>
                <tr>
                    <th scope="row">

                        <?php echo $row['MON_SIMBOLO']; ?>

                    </th>

                    <td>
                        <?php echo $row['TotalVenta']; ?>
                    </td>
                </tr>
<?php
            }
        } else {
            echo
            "
            <tr>
            <th scope='row'>
            Sin ventas
            </th>

            <td>
            </td>
        </tr>";
        }
        break;
}
?>