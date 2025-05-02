<?php
require_once("../../models/Menu.php");
$menu = new Menu();
/* TODO: Obtener listado de acceso por ROL ID del Usuario */
$datos = $menu->get_menu_x_rol_id($_SESSION["ROL_ID"]);
?>

<div class="app-menu navbar-menu">

    <div class="navbar-brand-box">
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>

    </div>

    <div id="scrollbar">

        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>


                <?php
                foreach ($datos as $row) {
                    if ($row["MEN_GRUPO"] == "Inicio" && $row["MEND_PERMI"] == "SI") {

                ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo $row["MEN_RUTA"]; ?>">
                                <i class="<?php echo $row["MEN_ICON"]; ?>"></i>
                                <span data-key="t-widgets"><?php echo $row["MEN_NOM"]; ?></span>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>

                <li class="menu-title"><span data-key="t-menu">Mantenimiento</span></li>

                <?php
                foreach ($datos as $row) {
                    if ($row["MEN_GRUPO"] == "Mantenimiento" && $row["MEND_PERMI"] == "SI") {
                ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo $row["MEN_RUTA"]; ?>">
                                <i class="<?php echo $row["MEN_ICON"]; ?>"></i> <span data-key="t-widgets"><?php echo $row["MEN_NOM"]; ?></span>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>

                <li class="menu-title"><span data-key="t-menu">Compra</span></li>

                <?php
                foreach ($datos as $row) {
                    if ($row["MEN_GRUPO"] == "Compra" && $row["MEND_PERMI"] == "SI") {
                ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo $row["MEN_RUTA"]; ?>">
                            <i class="<?php  echo $row["MEN_ICON"]; ?>"></i><span data-key="t-widgets"><?php echo $row["MEN_NOM"]; ?></span>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>


                <li class="menu-title"><span data-key="t-menu">Venta</span></li>

                <?php
                foreach ($datos as $row) {
                    if ($row["MEN_GRUPO"] == "Venta" && $row["MEND_PERMI"] == "SI") {
                ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo $row["MEN_RUTA"]; ?>">
                            <i class="<?php  echo $row["MEN_ICON"]; ?>"></i><span data-key="t-widgets"><?php echo $row["MEN_NOM"]; ?></span>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>

            </ul>
        </div>

    </div>

    <div class="sidebar-background"></div>
</div>

<div class="vertical-overlay"></div>