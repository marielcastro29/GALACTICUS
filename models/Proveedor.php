<?php

class Proveedor extends Conectar
{

    //Metodo para listar los proveedores segun sucursal
    public function get_proveedor_x_suc_id($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_PROVEEDOR_01 ?";//SP_L_PROVEEDOR
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);

    }


    //Eliminar un proveedor
    public function delete_proveedor($prov_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_D_PROVEEDOR_01 ?";//SP_D_PROVEEDOR
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $prov_id);
        $query->execute();
    }

    //Insertar un proveedor
    public function insert_proveedor($suc_id, $prov_nom, $prov_ruc, $prov_telf, $prov_direcc, $prov_correo)
    {
        $conectar = parent::Conexion();
        $sql = "SP_I_PROVEEDOR_01 ?,?,?,?,?,?";//SP_I_PROVEEDOR
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->bindValue(2, $prov_nom);
        $query->bindValue(3, $prov_ruc);
        $query->bindValue(4, $prov_telf);
        $query->bindValue(5, $prov_direcc);
        $query->bindValue(6, $prov_correo);
        $query->execute();
    }

    //Actualizar proveedor

    public function update_proveedor($prov_id, $suc_id, $prov_nom, $prov_ruc, $prov_telf, $prov_direcc, $prov_correo)
    {
        $conectar = parent::Conexion();
        $sql = "SP_U_PROVEEDOR_01 ?,?,?,?,?,?,?";//SP_U_PROVEEDOR
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $prov_id);
        $query->bindValue(2, $suc_id);
        $query->bindValue(3, $prov_nom);
        $query->bindValue(4, $prov_ruc);
        $query->bindValue(5, $prov_telf);
        $query->bindValue(6, $prov_direcc);
        $query->bindValue(7, $prov_correo);
        $query->execute();
    }

    /* TODO: Listar Registro por ID en especifico */
    public function get_proveedor_x_prov_id($prov_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_PROVEEDOR_02 ?";//SP_L_PROVEEDOR_BY_ID
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $prov_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
