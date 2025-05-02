<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");
$rol = new Rol();
$datos = $rol->validar_acceso_rol($_SESSION["USU_ID"], "mntcompra");
if (isset($_SESSION["USU_ID"])) {
    if (is_array($datos) and count($datos) > 0) {
?>

        <!doctype html>
        <html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

        <head>
            <title>Galacticus | Compra</title>
            <?php require_once("../html/head.php"); ?>
        </head>

        <body>

            <div id="layout-wrapper">

                <?php require_once("../html/header.php"); ?>

                <?php require_once("../html/menu.php"); ?>

                <div class="main-content">
                    <div class="page-content">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h4 class="mb-sm-0"></h4>

                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Compra</a></li>
                                                <li class="breadcrumb-item active">Registrar compra</li>
                                            </ol>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- TODO:Id de Compra -->
                            <input type="hidden" name="compr_id" id="compr_id" />

                            <!-- TODO:Datos del Pago -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Tipo de Pago</h4>
                                        </div>

                                        <div class="card-body">
                                            <div class="live-preview">
                                                <div class="row align-items-center g-3">

                                                    <div class="col-lg-4">
                                                        <label for="doc_id" class="form-label">Documento</label>
                                                        <select id="doc_id" name="doc_id" class="form-control form-select" aria-label="Seleccionar">
                                                            <option value="0" selected>Seleccione</option>

                                                        </select>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <label for="pag_id" class="form-label">Pago</label>
                                                        <select id="pag_id" name="pag_id" class="form-control form-select" aria-label="Seleccionar">
                                                            <option value="0" selected>Seleccione</option>

                                                        </select>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <label for="mon_id" class="form-label">Moneda</label>
                                                        <select id="mon_id" name="mon_id" class="form-control form-select" aria-label="Seleccionar">
                                                            <option value='0' selected>Seleccione</option>

                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- TODO:Datos del Producto -->

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Agregar Producto</h4>
                                        </div>

                                        <div class="card-body">
                                            <div class="live-preview">
                                                <div class="row align-items-center g-3">

                                                    <!-- Categoría - Ocupa todo el ancho -->
                                                    <div class="col-lg-12">
                                                        <label for="cat_id" class="form-label">Categoria</label>
                                                        <select id="cat_id" name="cat_id" class="form-control form-select" aria-label="Seleccionar">
                                                            <option selected>Seleccione</option>
                                                        </select>
                                                    </div>

                                                    <!-- Producto - Ocupa todo el ancho -->
                                                    <div class="col-lg-12 my-3">
                                                        <label for="prod_id" class="form-label">Producto</label>
                                                        <select id="prod_id" name="prod_id" class="form-control form-select" aria-label="Seleccionar">
                                                         <option selected>Seleccionar</option>
                                                        </select>
                                                    </div>

                                                </div>

                                                <!-- Precio de compra, precio de venta, cantidad, stock y botón en una línea -->
                                                <div class="row align-items-center g-3">
                                                    <div class="col-lg-2">
                                                        <label for="prod_pcompra" class="form-label">Precio de compra</label>
                                                        <input type="number" class="form-control" id="prod_pcompra" name="prod_pcompra" placeholder="Precio de compra" />
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <label for="prod_pventa" class="form-label">Precio de venta</label>
                                                        <input type="number" class="form-control" id="prod_pventa" name="prod_pventa" placeholder="Precio de venta" readonly />
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <label for="prod_stock" class="form-label">Stock</label>
                                                        <input type="text" class="form-control" id="prod_stock" name="prod_stock" placeholder="Stock" readonly />
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <label for="detc_cant" class="form-label">Cantidad</label>
                                                        <input type="number" class="form-control" id="detc_cant" name="detc_cant" placeholder="Cantidad" />
                                                    </div>

                                                    <div class="col-lg-2 d-grid gap-1">
                                                        <label for="comp_cant" class="form-label">&nbsp;</label>
                                                        <button type="button" id="btnagregar" class="btn btn-primary btn-icon waves-effect waves-light">
                                                            <i class="ri-add-box-line"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Agregar Producto</h4>
                                </div>

                                <div class="card-body">
                                    <div class="live-preview">
                                        <div class="row align-items-center g-3">

                                            <div class="col-lg-12">
                                                <label for="cat_id" class="form-label">Categoria</label>
                                                <select id="cat_id" name="cat_id" class="form-control form-select" aria-label="Seleccionar">
                                                    <option selected>Seleccione</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-12">
                                                <label for="prod_id" class="form-label">Producto</label>
                                                <select id="prod_id" name="prod_id" class="form-control form-select" aria-label="Seleccionar">
                                                    <option selected>Seleccione</option>

                                                </select>
                                            </div>

                                            <div class="col-lg-3>
                                                <label for="prod_pcompra" class="form-label">Precio de compra</label>
                                                <input type="number" class="form-control" id="prod_pcompra" name="prod_pcompra" placeholder="Precio de compra"/>
                                            </div>

                                            <div class="col-lg-3>
                                                <label for="prod_pcompra" class="form-label">Precio de venta</label>
                                                <input type="number" class="form-control" id="prod_pventa" name="prod_pventa" placeholder="Precio de venta" readonly/>
                                            </div>


                                            <div class="col-lg-3">
                                                <label for="prod_stock" class="form-label">Stock</label>
                                                <input type="text" class="form-control" id="prod_stock" name="prod_stock" placeholder="Stock" readonly/>
                                            </div>


                                            <div class="col-lg-3">
                                                <label for="detc_cant" class="form-label">Cantidad</label>
                                                <input type="number" class="form-control" id="detc_cant" name="detc_cant" placeholder="Cant."/>
                                            </div>

                                            <div class="col-lg-3 d-grid gap-1">
                                                <label for="comp_cant" class="form-label">&nbsp;</label>
                                                <button type="button" id="btnagregar" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-add-box-line"></i></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        -->
                            <!-- TODO:Detalle de Compra -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Detalle de Compra</h4>
                                        </div>

                                        <div class="card-body">
                                            <table id="table_data" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Categoria</th>
                                                        <th style="display: none;">Producto ID</th>
                                                        <th>Producto</th>
                                                        <th>Precio compra</th>
                                                        <th>Cantidad</th>
                                                        <th>Total</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>

                                            <!-- TODO:Calculo Detalle -->
                                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                                <tbody>
                                                    <tr>
                                                        <td>Sub Total</td>
                                                        <td class="text-end" id="txtsubtotal">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>IVA (15%)</td>
                                                        <td class="text-end" id="txtigv">0</td>
                                                    </tr>
                                                    <tr class="border-top border-top-dashed fs-15">
                                                        <th scope="row">Total</th>
                                                        <th class="text-end" id="txttotal">0</th>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div class="mt-4">
                                                <label for="compr_coment" class="form-label text-muted text-uppercase fw-semibold">Comentario</label>
                                                <textarea class="form-control alert alert-info" id="compr_coment" name="compr_coment" placeholder="Comentario" rows="4" required=""></textarea>
                                            </div>

                                            <div class="hstack gap-2 left-content-end d-print-none mt-4">
                                                <button type="button" id="btnguardar" class="btn btn-success"><i class="ri-save-line align-bottom me-1"></i>REGISTRAR</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <?php require_once("../html/footer.php"); ?>
                </div>

            </div>

            <?php require_once("../html/js.php"); ?>
            <script type="text/javascript" src="compra.js"></script>
        </body>

        </html>
<?php
    } else {
        header("Location:" . Conectar::ruta() . "view/404/");
    }
} else {
    header("Location:" . Conectar::ruta() . "view/404/");
}
?>