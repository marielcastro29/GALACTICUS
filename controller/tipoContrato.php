<?php
require_once("../config/conexion.php");
require_once("../models/TipoContrato.php");
$tipo_contrato = new TipoContrato();

switch ($_GET["op"]) {
    case "combo":
        $datos = $tipo_contrato->get_tipos_contrato();
        if (is_array($datos) == true and count($datos) > 0) {
            $html = "<option value=''>Seleccionar</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['ID'] . "'>" . $row['NOMBRE'] . "</option>";
            }
            echo $html;
        }
        break;
}
?>