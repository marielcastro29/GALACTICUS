<?php
class Categoria extends Conectar
{
    /* TODO: Listar Registros */
    public function get_categoria_x_suc_id($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_CATEGORIA_BY_SUCURSAL_ID ?";//
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO: Listar Registro por ID en especifico */
    public function get_categoria_x_cat_id($cat_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_CATEGORIA_BY_ID ?";//
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $cat_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO: Eliminar o cambiar estado a eliminado */
    public function delete_categoria($cat_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_D_CATEGORIA ?";//SP_D_CATEGORIA
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $cat_id);
        $query->execute();
    }

    /* TODO: Registro de datos */
    public function insert_categoria($suc_id, $cat_nom)
    {
        $conectar = parent::Conexion();
        $sql = "SP_I_CATEGORIA ?,?";//SP_I_CATEGORIA
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->bindValue(2, $cat_nom);
        $query->execute();
    }

    /* TODO: Actualizar Datos */
    public function update_categoria($cat_id, $suc_id, $cat_nom)
    {
        $conectar = parent::Conexion();
        $sql = "SP_U_CATEGORIA ?,?,?";//SP_U_CATEGORIA
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $cat_id);
        $query->bindValue(2, $suc_id);
        $query->bindValue(3, $cat_nom);
        $query->execute();
    }

    /* TODO: Obtener el total de stock por categoria */
    public function get_categoria_total_stock($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_CATEGORIA_03 ?";//SP_L_STOCK_BY_CATEGORIA
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO: Obtener el total de categorias por sucursal */
    public function get_cantidad_categoria($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_CANTIDAD_CATEGORIA_BY_SUCURSAL_ID ?";// 
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        $resultado = $query->fetch(PDO::FETCH_ASSOC);
        $totalcategoria = $resultado['CANTIDAD CATEGORIA'];
        return $totalcategoria;
    }
}
