
<?php
    require_once("../../config/conexion.php");
    require_once("../../models/Rol.php");
    require_once("../../models/Usuario.php");
    $rol = new Rol();
    $datos = $rol->validar_acceso_rol($_SESSION["USU_ID"],"mntperfil");

    $usuario = new Usuario();
    $nombreUsuario = $usuario->get_usuario_x_usu_id($_SESSION["USU_ID"])[0]["USU_NOM"]." ".$usuario->get_usuario_x_usu_id($_SESSION["USU_ID"])[0]["USU_APE"];;
    $nombreRol = $rol->get_rol_x_rol_id($usuario->get_usuario_x_usu_id($_SESSION["USU_ID"])[0]["ROL_ID"])[0]["ROL_NOM"];

    if(isset($_SESSION["USU_ID"])){
        if(is_array($datos) and count($datos)>0){
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
            <!-- ============================================================== -->
            <div class="main-content">

<div class="page-content">
    <div class="container-fluid">

        <div class="position-relative mx-n4 mt-n4">
            <div class="profile-wid-bg profile-setting-img">
                <img src="../../assets/images/login.jpg" class="profile-wid-img" alt="">
                <div class="overlay-content">
                    <div class="text-end p-3">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-3">
                <div class="card mt-n5">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                <img src="../../assets/images/users/avatar-1.jpg" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <input id="profile-img-file-input" type="file" class="profile-img-file-input">
                                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                        <span class="avatar-title rounded-circle bg-light text-body">
                                            <i class="ri-camera-fill"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <h5 class="fs-16 mb-1">
                                <?php echo $nombreUsuario;?>
                            </h5>
                            <p class="text-muted mb-0"><?php echo $nombreRol?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xxl-9">
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                    <i class="fas fa-home"></i> Información personal
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <form action="javascript:void(0);">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="firstnameInput" placeholder="Galacticus" value="">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="lastnameInput" class="form-label">Apellido</label>
                                                <input type="text" class="form-control" id="lastnameInput" placeholder="Store" value="">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="emailInput" class="form-label">Correo</label>
                                                <input type="email" class="form-control" id="emailInput" placeholder="galacticus_store@galacticus.com" value="">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="phonenumberInput" class="form-label">Teléfono</label>
                                                <input type="text" class="form-control" id="phonenumberInput" placeholder="00000000" value="">
                                            </div>
                                        </div>


                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

    </div>
    <!-- container-fluid -->
</div><!-- End Page-content -->
        </div>

        <?php require_once("../html/footer.php"); ?>
</div>

<?php require_once("../html/js.php"); ?>
            <script type="text/javascript" src="perfil.js"></script>
</body>
</html>
<?php
        }else{
            header("Location:".Conectar::ruta()."view/404/");
        }
    }else{
        header("Location:".Conectar::ruta()."view/404/");
    }
?>