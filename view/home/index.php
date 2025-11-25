<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");
$rol = new Rol();
$datos = $rol->validar_acceso_rol($_SESSION["USU_ID"], "inicio");
if (isset($_SESSION["USU_ID"])) {
    if (is_array($datos) and count($datos) > 0) {

        require_once("../../models/Producto.php");
        $producto = new Producto();
        $datos_producto = $producto->get_producto_x_suc_id($_SESSION["SUC_ID"]);
        $cantidadProducto = $producto->get_cantidad_producto($_SESSION["SUC_ID"]);

        require_once("../../models/Categoria.php");
        $categoria = new Categoria();
        $datos_categoria = $categoria->get_categoria_x_suc_id($_SESSION["SUC_ID"]);
        $cantidadCategoria = $categoria->get_cantidad_categoria($_SESSION["SUC_ID"]);

        require_once("../../models/Cliente.php");
        $cliente = new Cliente();
        $datos_cliente = $cliente->get_cliente_x_suc_id($_SESSION["SUC_ID"]);
        $cantidadCliente = $cliente->get_cantidad_cliente($_SESSION["SUC_ID"]);

        require_once("../../models/Proveedor.php");
        $proveedor = new Proveedor();
        $datos_proveedor = $proveedor->get_proveedor_x_suc_id($_SESSION["SUC_ID"]);

        require_once("../../models/Venta.php");
        $venta = new Venta();

        require_once("../../models/Usuario.php");
        $usuario = new Usuario();
        $cantidadUsuario = $usuario->get_cantidad_usuario($_SESSION["SUC_ID"]);

        require_once("../../models/Sucursal.php");
        $sucursal = new Sucursal();
        $nombreSucursal = $sucursal->get_sucursal_x_suc_id($_SESSION["SUC_ID"])[0]["SUC_NOM"];

?>

        <!doctype html>
        <html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

        <head>
            <title>Galacticus | Inicio</title>
            <?php require_once("../html/head.php"); ?>

            <!-- jsvectormap css -->
            <link href="../../assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

            <!--Swiper slider css-->
            <link href="../../assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />
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
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                                                <li class="breadcrumb-item active">Inicio</li>
                                            </ol>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">

                                    <div class="h-100">

                                        <div class="row mb-3 pb-1">
                                            <div class="col-12">
                                                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                                    <div class="flex-grow-1">
                                                        <h4 class="fs-16 mb-1">Buen día, <?php echo $_SESSION["USU_NOM"] ?>!</h4>
                                                        <p class="text-muted mb-0">Sistema de Galacticus Store</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>

                            <div class="row project-wrapper">
                                <div class="col-xxl-8">
                                </div><!-- end col -->
                            </div><!-- end row -->

                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Categorias</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo $cantidadCategoria; ?>"></span> </h4>
                                                    <a href="../Categoria/" class="text-decoration-underline">Ver categorias</a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-soft-success rounded fs-3">
                                                        <i class="ri-stack-line text-success"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->

                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Productos</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo $cantidadProducto; ?>"></span></h4>
                                                    <a href="../Producto/" class="text-decoration-underline">Ver productos</a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-soft-info rounded fs-3">
                                                        <i class="las la-laptop text-info"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->

                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Clientes</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo $cantidadCliente; ?>"></span></h4>
                                                    <a href="../Cliente/" class="text-decoration-underline">Ver clientes</a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-soft-warning rounded fs-3">
                                                        <i class="ri-team-line text-warning"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->

                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Usuarios</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo $cantidadUsuario; ?>"></span></h4>
                                                    <a href="../Usuario/" class="text-decoration-underline">Ver usuarios</a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-soft-primary rounded fs-3">
                                                        <i class="ri-user-settings-line text-primary"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->
                            </div> <!-- end row-->

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex flex-column align-items-start">
                                                <!-- Mostrar la tabla primero -->
                                                <div class="w-100">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                                                                $
                                                            </span>
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden ms-3">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                                TOTAL VENTA
                                                                <br>
                                                                <span class="text-primary my-2">
                                                                    <?php
                                                                    $fechaHoy = getdate();
                                                                    $fechaHaceInicioSemana = getdate(strtotime('-6 days'));

                                                                    // Mostrar la fecha en la que inicia la semana
                                                                    echo "DEL " . ($fechaHaceInicioSemana['mday'] . '-' . sprintf("%02d", $fechaHaceInicioSemana['mon']) . '-' . $fechaHaceInicioSemana['year']) . " AL " . ($fechaHoy['mday'] . '-' . sprintf("%02d", $fechaHoy['mon']) . '-' . $fechaHoy['year']);
                                                                    ?>
                                                                </span>
                                                            </p>
                                                            <table class="table caption-top table-nowrap">
                                                                <tbody id="listmontoventasxmoneda">
                                                                    <!-- Aquí se insertarán las filas de la tabla -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row w-100">
                                                    <div class="col-6 d-flex align-items-center">
                                                        <p class="text-uppercase fw-medium text-muted mb-0">
                                                            Proyección semanal
                                                        </p>
                                                    </div>
                                                    <div class="col-6 d-flex justify-content-end">
                                                        <a href="../Venta/" type="button" class="px-4 py-3 badge badge-soft-danger fs-12">
                                                            <i class="ri-add-circle-line align-middle me-1"></i> Registrar venta
                                                        </a>
                                                    </div>
                                                </div>


                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end col -->
                                </div><!-- end col -->
                            </div><!-- end row -->
                            <div class="row">

                                <div class="col-xl-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Productos más vendidos</h4>
                                        </div><!-- end card header -->

                                        <div class="card-body">
                                            <p class="text-muted">Top de 5 productos más vendidos en la sucursal <?php echo $nombreSucursal ?> </p>
                                            <div id="contact-existing-list">
                                                <div data-simplebar class="mx-n3">
                                                    <ul id="listtopventaproducto" class="list list-group list-group-flush mb-0"></ul>

                                                    <!-- end ul list -->
                                                </div>
                                            </div>
                                        </div><!-- end card -->
                                    </div>
                                    <!-- end col -->
                                </div>
                            </div>

                        </div><!-- end container-fluid -->
                    </div><!-- end page-content -->
                </div><!-- end main-content -->

                <?php require_once("../html/footer.php"); ?>
            </div><!-- end layout-wrapper -->

            <?php require_once("../html/js.php"); ?>

            <!-- apexcharts -->
            <script src="../../assets/libs/apexcharts/apexcharts.min.js"></script>

            <!-- Vector map-->
            <script src="../../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
            <script src="../../assets/libs/jsvectormap/maps/world-merc.js"></script>

            <!--Swiper slider js-->
            <script src="../../assets/libs/swiper/swiper-bundle.min.js"></script>

            <!-- Dashboard init -->
            <script src="../../assets/js/pages/dashboard-ecommerce.init.js"></script>

            <!-- Chart JS -->
            <script src="../../assets/libs/chart.js/chart.min.js"></script>

            <script src="../../assets/js/pages/chartjs.init.js"></script>

            <script type="text/javascript" src="home.js"></script>
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