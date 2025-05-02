<?php
class Venta extends Conectar
{

    /* TODO: Listar Registro por ID en especifico */
    public function insert_venta_x_suc_id($suc_id, $usu_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_I_VENTA_01 ?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->bindValue(2, $usu_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    public function get_venta_detalle($vent_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_VENTAS_DETALLE ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $vent_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete_venta_detalle($detv_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_D_VENTA_01 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $detv_id);
        $query->execute();
    }

    public function get_venta_calculo($vent_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_CALCULO_IVA ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $vent_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    public function get_venta($vent_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_VENTA_02 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $vent_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_venta_listado($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_VENTAS ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    public function get_view_venta($vent_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_VENTA_IMPRESION ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $vent_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_venta_top_productos($suc_id){
        $conectar=parent::Conexion();
        $sql="SP_L_TOP_PRODUCTOS_VENDIDOS ?";
        $query=$conectar->prepare($sql);
        $query->bindValue(1,$suc_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    //metodo para el inicio del programa que muestre las ventas
    /*
    public function get_monto_semanal($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_VENTA_X_SEMANA ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        $resultado = $query->fetch(PDO::FETCH_ASSOC);
        $monto_semanal = $resultado['MONTOSEMANAL'];
        return $monto_semanal;
    }
*/
  /*
    public function get_monto_semanal($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_VENTA_X_SEMANA ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    */

    public function get_monto_semanal($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_MONTO_X_MONEDA ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
@SUC_ID INT,
@USU_ID INT,
@DOC_ID INT,
@PAG_ID INT,
@MON_ID INT,
@CLI_ID INT,
@VENT_COMENT VARCHAR(500)
     * 
     */
    /*TODO: GUARDAR LOS DATOS DE LA COMPRA Y LOS DETALLES DE COMPRA */
    public function insert_venta($suc_id, $usu_id, $doc_id, $pag_id, $mon_id, $cli_id, $vent_coment)
    {
        $conectar = parent::Conexion();
        $sql = "SP_I_VENTAS ?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->bindValue(2, $usu_id);
        $query->bindValue(3, $doc_id);
        $query->bindValue(4, $pag_id);
        $query->bindValue(5, $mon_id);
        $query->bindValue(6, $cli_id);
        $query->bindValue(7, $vent_coment);
        $query->execute();

        $vent_id = $conectar->lastInsertId();

        return $vent_id;
    }


    /*
@VENT_ID INT, 
@PROD_ID INT,
@PROD_PVENTA NUMERIC(18,2),
@DETV_CANT INT
    */
    public function insert_detalle_venta($vent_id, $prod_id, $prod_pventa, $detv_cant)
    {
        $conectar = parent::Conexion();
        $sql = "SP_I_VENTA_DETALLE ?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $vent_id);
        $query->bindValue(2, $prod_id);
        $query->bindValue(3, $prod_pventa);
        $query->bindValue(4, $detv_cant);
        $query->execute();
    }
}
