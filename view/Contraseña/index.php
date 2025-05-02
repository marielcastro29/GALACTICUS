<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");
$rol = new Rol();
$datos = $rol->validar_acceso_rol($_SESSION["USU_ID"], "mntperfil");
if (isset($_SESSION["USU_ID"])) {
    if (is_array($datos) and count($datos) > 0) {
?>

        <!doctype html>
        <html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

        <head>
            <title>Galacticus | Perfil</title>
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
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Usuario</a></li>
                                                <li class="breadcrumb-item active">Cambiar contraseña</li>
                                            </ol>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">

                                            <div class="card-body">
                                                <div class="live-preview">
                                                    <div class="row gy-4">
                                                        <!-- Contraseña anterior -->
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="txtpass" class="form-label">Contraseña anterior</label>
                                                                <div class="position-relative">
                                                                    <input type="password" class="form-control" id="txtpass">
                                                                    <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y bg-transparent border-0 p-2 toggle-eye" data-target="txtpass">
                                                                        <i class="ri-eye-off-line"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Nueva contraseña -->
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="txtpassconfirm" class="form-label">Nueva contraseña</label>
                                                                <div class="position-relative">
                                                                    <input type="password" class="form-control" id="txtpassconfirm">
                                                                    <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y bg-transparent border-0 p-2 toggle-eye" data-target="txtpassconfirm">
                                                                        <i class="ri-eye-off-line"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="labelInput" class="form-label">&nbsp;</label>
                                                                <button type="button" id="btnguardar" class="btn-color btn btn-soft-primary waves-effect waves-light">Actualizar contraseña</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
            <script type="text/javascript" src="contrasenia.js"></script>
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