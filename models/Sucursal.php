<?php
class Sucursal extends Conectar
{
    /* TODO: Listar Registros */
    public function get_sucursal()
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_SUCURSALES";
        $query = $conectar->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO: Listar Registro por ID en especifico */
    public function get_sucursal_x_suc_id($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_SUCURSAL_BY_ID ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO: Eliminar o cambiar estado a eliminado */
    public function delete_sucursal($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_D_SUCURSAL ?"; //SP_D_SUCURSAL
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
    }

    /* TODO: Registro de datos */
    public function insert_sucursal($suc_nom, $suc_dir, $suc_tel, $suc_cor)
    {
        $conectar = parent::Conexion();
        $sql = "SP_I_SUCURSAL ?,?,?,?"; //
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_nom);
        $query->bindValue(2, $suc_dir);
        $query->bindValue(3, $suc_tel);
        $query->bindValue(4, $suc_cor);
        $query->execute();
    }

    /* TODO:Actualizar Datos */
    public function update_sucursal($suc_id, $suc_nom, $suc_dir, $suc_tel, $suc_cor)
    {
        $conectar = parent::Conexion();
        $sql = "SP_U_SUCURSAL ?,?,?,?,?"; //
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->bindValue(2, $suc_nom);
        $query->bindValue(3, $suc_dir);
        $query->bindValue(4, $suc_tel);
        $query->bindValue(5, $suc_cor);
        $query->execute();
    }
}
