<?php
/* TODO: Llamando Clases */
require_once("../config/conexion.php");
require_once("../models/Compra.php");
require_once("../models/Producto.php");
/* TODO: Inicializando clase */
$compra = new Compra();

switch ($_GET["op"]) {

    /* TODO: Registrar Compra */
    case "registrar":

        //$suc_id, $pag_id, $compr_coment, $usu_id, $mon_id, $doc_id
        $id_compra = $compra->insert_compra(
            $_POST["suc_id"],
            $_POST["pag_id"],
            $_POST["compr_coment"],
            $_POST["usu_id"],
            $_POST["mon_id"],
            $_POST["doc_id"]
        );

        echo "ID COMPRA: " . $id_compra;

        if (!empty($id_compra)) {

            echo "ID COMPRA NO ESTA VACIO: " . $id_compra;

            if (isset($_POST["productos"])) {

                $productos = json_decode($_POST["productos"], true);

                echo "ARREGLOS PRODUCTOS NO ESTA VACIO: ";

                foreach ($productos as $producto) {

                    $prod_id = $producto["prod_id"];
                    echo "PRODUCTO ID: " . $prod_id;

                    $precio_compra = $producto["precio_compra"];
                    echo "PRECIO DE COMPRA PRODUCTO: " . $prod_id;

                    $cantidad = $producto["cantidad"];
                    echo "CANTIDAD DE COMPRA PRODUCTO: " . $cantidad;

                    $compra->insert_detalle_compra($id_compra, $prod_id, $precio_compra, $cantidad);
                }
            }
        }

        break;
    case "calculo":
        $datos = $compra->get_compra_calculo($_POST["compr_id"]);
        foreach ($datos as $row) {
            $output["COMPR_SUBTOTAL"] = $row["Subtotal"];
            $output["COMPR_IVA"] = $row["IVA"];
            $output["COMPR_TOTAL"] = $row["TOTAL"];
        }
        echo json_encode($output);
        break;
        /*
            $datos=$compra->get_compra_calculo($_POST["compr_id"]);
            foreach($datos as $row){
                $output["COMPR_SUBTOTAL"] = $row["COMPR_SUBTOTAL"];
                $output["COMPR_IGV"] = $row["COMPR_IGV"];
                $output["COMPR_TOTAL"] = $row["COMPR_TOTAL"];
            }
            echo json_encode($output);
            break;
            */
        /* TODO:Eliminar Detalle */
    case "eliminardetalle":
        $compra->delete_compra_detalle($_POST["detc_id"]);
        break;
    /* TODO: Listar Detalle de Compra */
    case "listardetalle":

        $datos = $compra->get_compra_detalle($_POST["compr_id"]);
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
            $sub_array[] = $row["MON_SIMBOLO"] . " " . $row["PROD_PCOMPRA"];
            $sub_array[] = $row["DETC_CANT"];
            $sub_array[] = $row["MON_SIMBOLO"] . " " . ($row["PROD_PCOMPRA"] * $row["DETC_CANT"]);
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
        //De productos hay que obtener la imagen, nombre

        /*
        $producto = new Producto();
        $datos = $producto->get_info_producto($_POST["prod_id"]);
        $dataProducto = array();

        foreach ($datos as $rowproducto) {
            //1. IMAGEN
            $sub_array = array();
            if ($rowproducto["PROD_IMG"] != '') {
                $sub_array[] =
                    "<div class='d-flex align-items-center'>" .
                    "<div class='flex-shrink-0 me-2'>" .
                    "<img src='../../assets/producto/" . $rowproducto["PROD_IMG"] . "' alt='' class='avatar-xs rounded-circle'>" .
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
            $sub_array[] = $rowproducto["CAT_NOM"]; //2. CATEGORIA
            $sub_array[] = $rowproducto["PROD_NOM"]; //3. NOMBRE DEL PRODUCTO
            $sub_array[] = $rowproducto["PROD_PCOMPRA"]; //4. PRECIO DE COMPRA DEL PRODUCTO
            $sub_array[] = $_POST["detc_cant"]; //5. CANTIDAD
            $sub_array[] = $_POST["detc_cant"] * $rowproducto["PROD_PCOMPRA"]; //6.TOTAL
            //7. boton para eliminar producto de la orden de compras
            $sub_array[] = '<button type="button" onClick="eliminar(this)" class="btn btn-danger btn-icon waves-effect waves-light">
                    <i class="ri-delete-bin-5-line"></i>
                 </button>';
            //$sub_array[] = '<button type="button" onClick="eliminar()" id="" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i></button>';
            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        /*
            $datos=$compra->get_compra_detalle($_POST["compr_id"]);
            $data=Array();
            foreach($datos as $row){
                $sub_array = array();
                if ($row["PROD_IMG"] != ''){
                    $sub_array[] =
                    "<div class='d-flex align-items-center'>" .
                        "<div class='flex-shrink-0 me-2'>".
                            "<img src='../../assets/producto/".$row["PROD_IMG"]."' alt='' class='avatar-xs rounded-circle'>".
                        "</div>".
                    "</div>";
                }else{
                    $sub_array[] =
                    "<div class='d-flex align-items-center'>" .
                        "<div class='flex-shrink-0 me-2'>".
                            "<img src='../../assets/producto/no_imagen.png' alt='' class='avatar-xs rounded-circle'>".
                        "</div>".
                    "</div>";
                }
                $sub_array[] = $row["CAT_NOM"];
                $sub_array[] = $row["PROD_NOM"];
                $sub_array[] = $row["UND_NOM"];
                $sub_array[] = $row["PROD_PCOMPRA"];
                $sub_array[] = $row["DETC_CANT"];
                $sub_array[] = $row["DETC_TOTAL"];
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["DETC_ID"].','.$row["COMPR_ID"].')" id="'.$row["DETC_ID"].'" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            */
            
    /* TODO: Formato compra para la vista del documento */
    case "listardetalleformato";
        $datos = $compra->get_compra_detalle($_POST["compr_id"]);
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
                <td scope="row"><?php echo $row["UND_NOM"]; ?></td>
                <td><?php echo $row["PROD_PCOMPRA"]; ?></td>
                <td><?php echo $row["DETC_CANT"]; ?></td>
                <td class="text-end"><?php echo $row["DETC_TOTAL"]; ?></td>
            </tr>
        <?php
        }
        break;
    case "listarcompra":
        $datos = $compra->get_compra_listado($_POST["suc_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = "C-" . (($row["COMPR_ID"] > 0 && $row["COMPR_ID"] < 10) ? "0" : "") . $row["COMPR_ID"]; //No. Venta
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
            $sub_array[] = $row["COMPR_COMENT"]; //Comentario
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
           //$sub_array[] = '<button type="button" onClick="redireccionarDocumento(' . $row["COMPR_ID"] . ')" id="' . $row["COMPR_ID"] . '" class="btn  btn-primary btn-icon waves-effect waves-light"><i class="ri-eye-line"></i></button>';
            $sub_array[] = '<button type="button" onClick="ver(' . $row["COMPR_ID"] . ')" id="' . $row["COMPR_ID"] . '" class="btn btn-success btn-info waves-effect waves-light"><i class="ri-settings-2-line"></i></button>';
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

    /* TODO: Listar 5 productos con sus datos mas comprados */
    case "listartopproducto";
        $datos = $compra->get_compra_top_productos($_POST["suc_id"]);
        foreach ($datos as $row) {
        ?>
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-light rounded p-1 me-2">
                            <?php
                            if ($row["PROD_IMG"] != '') {
                            ?>
                                <?php
                                echo "<img src='../../assets/producto/" . $row["PROD_IMG"] . "' alt='' class='img-fluid d-block' />";
                                ?>
                            <?php
                            } else {
                            ?>
                                <?php
                                echo "<img src='../../assets/producto/no_imagen.png' alt='' class='img-fluid d-block' />";
                                ?>
                            <?php
                            }
                            ?>
                        </div>
                        <div>
                            <h5 class="fs-14 my-1"><?php echo $row["PROD_NOM"]; ?></h5>
                            <span class="text-muted"><?php echo $row["CAT_NOM"]; ?></span>
                        </div>
                    </div>
                </td>
                <td>
                    <h5 class="fs-14 my-1 fw-normal"><?php echo $row["PROD_PCOMPRA"]; ?></h5>
                    <span class="text-muted">P.Compra</span>
                </td>
                <td>
                    <h5 class="fs-14 my-1 fw-normal"><?php echo $row["CANT"]; ?></h5>
                    <span class="text-muted">Cant</span>
                </td>
                <td>
                    <h5 class="fs-14 my-1 fw-normal"><?php echo $row["PROD_STOCK"]; ?></h5>
                    <span class="text-muted">Stock</span>
                </td>
                <td>
                    <h5 class="fs-14 my-1 fw-normal"><b><?php echo $row["MON_NOM"]; ?></b> <?php echo $row["TOTAL"]; ?></h5>
                    <span class="text-muted">Total</span>
                </td>
            </tr>
        <?php
        }
        break;
    
    /* TODO: Listado de actividades recientes para dashboard */
    case "compraventa":
        $datos = $compra->get_compraventa($_POST["suc_id"]);
        foreach ($datos as $row) {
        ?>
            <div class="acitivity-item py-3 d-flex">
                <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                    <?php
                    if ($row["REGISTRO"] == 'Compra') {
                    ?>
                        <div class="avatar-title bg-soft-success text-success rounded-circle">
                            <i class="ri-shopping-cart-2-line"></i>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="avatar-title bg-soft-danger text-danger rounded-circle">
                            <i class="ri-stack-fill"></i>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1 lh-base"><?php echo $row["REGISTRO"]; ?> - <?php echo $row["DOC_NOM"]; ?></h6>
                    <p class="text-muted mb-1"><?php echo $row["PROV_NOM"]; ?> </p>
                    <small class="mb-0 text-muted"><?php echo $row["FECH_CREA"]; ?></small>
                </div>
            </div>
<?php
        }
        break;
    case "actualizarstock":
        $datos = $compra->updatestockproducto($_POST["prod_id"], $_POST["detc_cant"]);
        break;
    //lista el detalle de compra para la ventana modal de detalle de compra
    case "detallecompra":
        //metodo usado para rellenar el modal de detalle compra
        $datos = $compra->get_compra_detalle($_POST["compr_id"]);
        $data = array();
        /*
TD_COMPRA_DETALLE.DETC_ID,   
 TM_CATEGORIA.CAT_NOM,   
 TM_PRODUCTO.PROD_NOM,
 TM_PRODUCTO.PROD_IMG,
 TD_COMPRA_DETALLE.PROD_PCOMPRA,  
 TD_COMPRA_DETALLE.DETC_CANT,    
 TD_COMPRA_DETALLE.COMPR_ID,   
 TD_COMPRA_DETALLE.PROD_ID
         */
        foreach ($datos as $row) {
            $sub_array = array();
            //OBTENEMOS LA IMAGEN DEL PRODUCTO
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
            $sub_array[] = $row["PROD_PCOMPRA"];
            $sub_array[] = $row["DETC_CANT"];
            $sub_array[] = $row["DETC_CANT"] * $row["PROD_PCOMPRA"];
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
}
?>