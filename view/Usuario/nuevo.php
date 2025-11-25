<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");
require_once("../../models/Usuario.php");
$rol = new Rol();
$datos = $rol->validar_acceso_rol($_SESSION["USU_ID"], "mntperfil");

$usuario = new Usuario();
$nombreUsuario = $usuario->get_usuario_x_usu_id($_SESSION["USU_ID"])[0]["USERNAME"];
$nombreRol = $rol->get_rol_x_rol_id($usuario->get_usuario_x_usu_id($_SESSION["USU_ID"])[0]["ROL_ID"])[0]["NOMBRE"];

//if(isset($_SESSION["USU_ID"])){
//  if(is_array($datos) and count($datos)>0){
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
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="position-relative mx-n4 mt-n4">
                        <div class="profile-wid-bg profile-setting-img">
                            <img src="../../assets/images/login.jpg" class="profile-wid-img" alt="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n5">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                        <img src="../../assets//usuario/no_imagen.jpg" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                            <input id="profile-img-file-input" type="file" class="profile-img-file-input">
                                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                <span class="avatar-title rounded-circle bg-light text-body">
                                                    <i class="ri-camera-fill"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <h5 id="username" class="fs-16 mb-1"></h5>
                                    <p id="rolname" class="text-muted mb-0"></p>
                                </div>
                            </div>
                        </div>
                        <!--end card-->


                        <div class="card" id="info_panel">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Info</h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <th class="ps-0" scope="row">Nombre completo :</th>
                                                <td class="text-muted">Anna Adame</td>
                                            </tr>

                                            <tr>
                                                <th class="ps-0" scope="row">Correo :</th>
                                                <td class="text-muted">daveadame@velzon.com</td>
                                            </tr>
                                            <tr>
                                                <th class="ps-0" scope="row">Teléfono :</th>
                                                <td class="text-muted">+(1) 987 6543</td>
                                            </tr>
                                            <tr>
                                                <th class="ps-0" scope="row">Sucursal :</th>
                                                <td class="text-muted">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                        <div class="card" id="activity_panel">
                            <div class="card-header border-bottom-dashed d-flex align-items-center">
                                <h5 class="card-title mb-0 flex-grow-1">Últimos Registros</h5>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-soft-primary btn-sm">Ver Todo</button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div data-simplebar style="max-height: 300px;" class="p-3">
                                    <div class="acitivity-timeline acitivity-main">

                                        <!-- Registro 1 -->
                                        <div class="acitivity-item d-flex">
                                            <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                                <div class="avatar-title bg-soft-success text-success rounded-circle">
                                                    <i class="ri-shopping-cart-2-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">Venta registrada</h6>
                                                <p class="text-muted mb-1">Factura #F00123 - 3 productos</p>
                                                <small class="text-muted">Hoy a las 02:14 PM</small>
                                            </div>
                                        </div>

                                        <!-- Registro 2 -->
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                                <div class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                    <i class="ri-price-tag-3-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">Nuevo producto agregado</h6>
                                                <p class="text-muted mb-1">Auriculares Bluetooth JBL</p>
                                                <small class="text-muted">Ayer a las 11:30 AM</small>
                                            </div>
                                        </div>

                                        <!-- Registro 3 -->
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                                <div class="avatar-title bg-soft-warning text-warning rounded-circle">
                                                    <i class="ri-folder-add-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">Nueva categoría creada</h6>
                                                <p class="text-muted mb-1">Accesorios para computadoras</p>
                                                <small class="text-muted">20 nov 25 - 09:15 AM</small>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--end card-->
                    </div>
                    <!--end col-->
                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                            <i class="fas fa-home"></i> Datos Personales
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                            <i class="far fa-user"></i> Datos Empleado
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#experience" role="tab">
                                            <i class="far fa-envelope"></i> Datos Usuario
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                        <form action="javascript:void(0);">
                                            <!-- id del usuario: vacío = nuevo, con valor = editar -->
                                            <input type="hidden" id="usu_id" name="usu_id" value="">

                                            <input type="hidden" id="empleado_id" name="empleado_id" value="">

                                            <input type="hidden" id="persona_id" name="persona_id" value="">

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="per_primer_nombre" class="form-label">Primer Nombre</label>
                                                        <input required type="text" class="form-control" id="per_primer_nombre" placeholder="Ingresa el primer nombre" value="">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="per_segundo_nombre" class="form-label">Segundo Nombre</label>
                                                        <input type="text" class="form-control" id="per_segundo_nombre" placeholder="Ingresa el segundo nombre" value="">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="per_primer_apellido" class="form-label">Primer Apellido</label>
                                                        <input required type="text" class="form-control" id="per_primer_apellido" placeholder="Ingresa el primer apellido" value="">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="per_segundo_apellido" class="form-label">Segundo Apellido</label>
                                                        <input type="text" class="form-control" id="per_segundo_apellido" placeholder="Ingresa el segundo apellido" value="">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="per_correo" class="form-label">Correo</label>
                                                        <input type="email" class="form-control" id="per_correo" placeholder="usuario@correo.com" value="">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="per_telefono" class="form-label">Teléfono</label>
                                                        <input type="text" class="form-control" id="per_telefono" placeholder="+(505) XXXX-XXXX" value="">
                                                    </div>
                                                </div>

                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="per_cedula" class="form-label">Cédula</label>
                                                        <input type="text" class="form-control" id="per_cedula" placeholder="XXX-XXXXXX-XXXXX" value="">
                                                    </div>
                                                </div>
                                                <!--end col-->

                                                <!--end col-->

                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="per_fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            data-provider="flatpickr"
                                                            id="per_fecha_nacimiento"
                                                            data-date-format="d M, y"
                                                            placeholder="<?php echo strtolower(date('d M y')); ?>" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="mb-3 pb-2">
                                                        <label for="per_direccion" class="form-label">Dirección:</label>
                                                        <textarea class="form-control" id="per_direccion" placeholder="Ingresa la dirección" rows="4" style="resize: none;"></textarea>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane" id="changePassword" role="tabpanel">
                                        <form action="javascript:void(0);">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="emp_tipo_contrato" class="form-label">Tipo de contrato</label>
                                                        <select required class="form-control" name="emp_tipo_contrato" id="emp_tipo_contrato">

                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="emp_salario" class="form-label">Salario</label>
                                                        <input required type="text" class="form-control" id="emp_salario" placeholder="C$" value="">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="emp_fecha_contratacion" class="form-label">Fecha de Contratación</label>
                                                        <input required type="text"
                                                            class="form-control"
                                                            data-provider="flatpickr"
                                                            id="emp_fecha_contratacion"
                                                            data-date-format="d M, y"
                                                            placeholder="<?php echo strtolower(date('d M y')); ?>" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="emp_fecha_fin_contrato" class="form-label">Fecha de Fin del Contrato</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            data-provider="flatpickr"
                                                            id="emp_fecha_fin_contrato"
                                                            data-date-format="d M, y"
                                                            placeholder="<?php echo strtolower(date('d M y')); ?>" />
                                                    </div>
                                                </div>

                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane" id="experience" role="tabpanel">
                                        <form>
                                            <div id="newlink">
                                                <div id="1">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label for="usu_nombre" class="form-label">Nombre de Usuario</label>
                                                                <input type="text" class="form-control" id="usu_nombre" placeholder="nombre_usuario" value="">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label for="usu_roles" class="form-label">Rol</label>
                                                                <select class="form-control" name="usu_roles" id="usu_roles">
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!--end col-->
                                                        <div class="col-lg-6">
                                                            <div>
                                                                <label id="passwordLabel" for="newpasswordInput" class="form-label">Nueva Contraseña*</label>
                                                                <input type="password" class="form-control" id="newpasswordInput" placeholder="Ingresa la nueva contraseña">
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-6">
                                                            <div>
                                                                <label id="confirmPasswordLabel" for="confirmpasswordInput" class="form-label">Confirmar Contraseña*</label>
                                                                <input type="password" class="form-control" id="confirmpasswordInput" placeholder="Confirma la nueva contraseña">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end row-->
                                                </div>
                                            </div>
                                            <div id="newForm" style="display: none;">

                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- ============================= -->
                            <!--   BOTONES GUARDAR / CANCELAR  -->
                            <!-- ============================= -->
                            <div class="card-footer d-flex justify-content-end gap-2">
                                <button id="btnGuardarUsuario" type="button" class="btn btn-primary">
                                    <i class="ri-save-3-line me-1"></i> Guardar
                                </button>

                                <a href="index.php" class="btn btn-light">
                                    Cancelar
                                </a>
                            </div>

                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->


            </div>
            <!-- container-fluid -->


        </div><!-- End Page-content -->

    </div> <?php require_once("../html/footer.php"); ?>

    </div>
    <!-- end main content-->


    <?php require_once("../html/footer.php"); ?>
    </div>

    <?php require_once("../html/js.php"); ?>
    <script type="text/javascript" src="nuevo.js"></script>
</body>

</html>
<?php
//   }else{
// header("Location:".Conectar::ruta()."view/404/");
//  }
//    }else{
//  header("Location:".Conectar::ruta()."view/404/");
//  }
?>