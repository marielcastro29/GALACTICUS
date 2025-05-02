<?php
class Compra extends Conectar
{

    /* TODO: Listar Registro por ID en especifico */
    public function insert_compra_x_suc_id($suc_id, $usu_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_I_COMPRA_01 ?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->bindValue(2, $usu_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO: Obtener detalle de compra */
    public function get_compra_detalle($compr_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_COMPRAS_DETALLE ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $compr_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO: Eliminar un detalle de la compra */
    public function delete_compra_detalle($detc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_D_COMPRA_01 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $detc_id);
        $query->execute();
    }

    /* TODO: Calcular SUBTOTAL, IGV y TOTAL */
    public function get_compra_calculo($compr_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_CALCULO_IVA_COMPRA ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $compr_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    /* TODO: Obtener listado de todas las compras por sucursal */
    public function get_compra_listado($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_COMPRAS ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO: Obtener top 5 de compras */
    public function get_compra_top_productos($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_COMPRAS_04 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    /* TODO: Obtener datos de compra y venta para actividades recientes */
    public function get_compraventa($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_COMPRAVENTA_01 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }



    /* TODO: Actualizar el stock de productos al hacer la compra  */
    public function updatestockproducto($prod_id, $detc_cant)
    {
        $conectar = parent::Conexion();
        $sql = "SP_U_PRODUCTO_STOCK ?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $prod_id);
        $query->bindValue(2, $detc_cant);
        $query->bindValue(3, "COMPRA");
        $query->execute();
    }

    /*
      @SUC_ID INT,
@PAG_ID INT,
@COMPR_COMENT VARCHAR(500),
@USU_ID INT,
@MON_ID INT,
@DOC_ID INT
     * 
     */
    /*TODO: GUARDAR LOS DATOS DE LA COMPRA Y LOS DETALLES DE COMPRA */
    public function insert_compra($suc_id, $pag_id, $compr_coment, $usu_id, $mon_id, $doc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_I_COMPRAS ?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->bindValue(2, $pag_id);
        $query->bindValue(3, $compr_coment);
        $query->bindValue(4, $usu_id);
        $query->bindValue(5, $mon_id);
        $query->bindValue(6, $doc_id);
        $query->execute();

        $compr_id = $conectar->lastInsertId();

        return $compr_id;
    }


    /*
    CREATE TABLE SP_I_COMPRA_DETALLE
@COMPR_ID INT, 
@PROD_ID INT,
@PROD_PCOMPRA NUMERIC(18,2),
@DETC_CANT INT
    */
    public function insert_detalle_compra($compr_id,$prod_id,$prod_compra,$detc_cant) {
        $conectar = parent::Conexion();
        $sql = "SP_I_COMPRA_DETALLE ?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $compr_id);
        $query->bindValue(2, $prod_id);
        $query->bindValue(3, $prod_compra);
        $query->bindValue(4, $detc_cant);
        $query->execute();
    }
}
