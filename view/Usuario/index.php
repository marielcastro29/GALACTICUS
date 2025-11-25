<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");
$rol = new Rol();
$datos = $rol->validar_acceso_rol($_SESSION["USU_ID"], "usuario");
if (isset($_SESSION["USU_ID"])) {
    if (is_array($datos) and count($datos) > 0) {
?>
        <!doctype html>
        <html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

        <head>
            <title>Galacticus | Usuarios</title>
            <?php require_once("../html/head.php"); ?>
        </head>

        <body>

            <div id="layout-wrapper">

                <?php require_once("../html/header.php"); ?>
                <?php require_once("../html/menu.php"); ?>

                <div class="main-content">

                    <div class="page-content">
                        <div class="container-fluid">

                            <div class="container-fluid">

                                <input type="hidden" id="SUC_IDx" value="<?php echo $_SESSION["SUC_ID"] ?? 1; ?>">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                            <h4 class="mb-sm-0">Gestión de Usuarios</h4>
                                            <div class="page-title-right">
                                                <ol class="breadcrumb m-0">
                                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Menú</a></li>
                                                    <li class="breadcrumb-item active">Usuarios</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-12">
                                        <button id="btnnuevo" class="btn btn-primary btn-label waves-effect waves-light"><i class="ri-user-add-line label-icon align-middle fs-16 me-2"></i>Nuevo usuario</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div id="usuarios_cards" class="row row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-1 g-4 mb-5">

                                            <div class="col-12">
                                                <div class="text-center py-5">
                                                    <div class="spinner-border text-primary" role="status">
                                                        <span class="visually-hidden">Cargando...</span>
                                                    </div>
                                                    <p class="mt-2 text-muted">Cargando usuarios...</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <?php require_once("../html/footer.php"); ?>

                </div>
            </div> <?php require_once("mantenimiento.php"); ?>

            <?php require_once("../html/js.php"); ?>

            <script type="text/javascript" src="usuario.js"></script>
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