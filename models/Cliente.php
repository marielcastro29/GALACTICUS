<?php
class Cliente extends Conectar
{
    /* TODO: Listar Registros */
    public function get_cliente_x_suc_id($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_CLIENTE_01 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO: Listar Registro por ID en especifico */
    public function get_cliente_x_cli_id($cli_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_CLIENTE_02 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $cli_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO: Eliminar o cambiar estado a eliminado */
    public function delete_cliente($cli_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_D_CLIENTE_01 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $cli_id);
        $query->execute();
    }

    /* TODO: Registro de datos */
    public function insert_cliente($suc_id, $cli_nom, $cli_ruc, $cli_telf, $cli_direcc, $cli_correo)
    {
        $conectar = parent::Conexion();
        $sql = "SP_I_CLIENTE_01 ?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->bindValue(2, $cli_nom);
        $query->bindValue(3, $cli_ruc);
        $query->bindValue(4, $cli_telf);
        $query->bindValue(5, $cli_direcc);
        $query->bindValue(6, $cli_correo);
        $query->execute();
    }

    /* TODO:Actualizar Datos */
    public function update_cliente($cli_id, $cli_nom, $cli_ruc, $cli_telf, $cli_direcc, $cli_correo)
    {
        $conectar = parent::Conexion();
        $sql = "SP_U_CLIENTE_01 ?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $cli_id);
        $query->bindValue(2, $cli_nom);
        $query->bindValue(3, $cli_ruc);
        $query->bindValue(4, $cli_telf);
        $query->bindValue(5, $cli_direcc);
        $query->bindValue(6, $cli_correo);
        $query->execute();
    }

    /* TODO: Obtener el total de clientes por sucursal */
    public function get_cantidad_cliente($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_CANTIDAD_CLIENTE_X_SUC ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        $resultado = $query->fetch(PDO::FETCH_ASSOC);
        $totalcliente = $resultado['Cantidad Cliente'];
        return $totalcliente;
    }
}
