<?php

class Proveedor extends Conectar
{

    //Metodo para listar los proveedores segun sucursal
    public function get_proveedor_x_suc_id($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_PROVEEDORES ?"; //
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    //Eliminar un proveedor
    public function delete_proveedor($prov_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_D_PROVEEDOR ?"; //SP_D_PROVEEDOR
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $prov_id);
        $query->execute();
    }
    // Insertar un proveedor (MODIFICADO para SP_I_PROVEEDOR)
    public function insert_proveedor(
        $tipo_persona_id,       // 1
        $primer_nombre,         // 2 (Nombre de persona o Razón Social)
        $segundo_nombre,        // 3
        $primer_apellido,       // 4
        $segundo_apellido,      // 5
        $ruc,                   // 6 (Fiscal - Jurídica)
        $cedula,                // 7 (Fiscal - Natural)
        $fecha_nacimiento,      // 8 (Natural)
        $telefono,              // 9
        $correo,                // 10
        $direccion,             // 11
        $sucursal_id            // 12
    ) {
        $conectar = parent::Conexion();

        $sql = "SP_I_PROVEEDOR ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?";

        $query = $conectar->prepare($sql);

        // Mapeo de Parámetros (Asegúrate de que el orden coincida con la definición del SP)

        // Parámetros de la Persona
        $query->bindValue(1, $tipo_persona_id);
        $query->bindValue(2, $primer_nombre);
        $query->bindValue(3, $segundo_nombre);
        $query->bindValue(4, $primer_apellido);
        $query->bindValue(5, $segundo_apellido);

        // Parámetros Fiscales y Fecha
        $query->bindValue(6, $ruc);
        $query->bindValue(7, $cedula);
        $query->bindValue(8, $fecha_nacimiento);

        // Parámetros de Contacto
        $query->bindValue(9, $telefono);
        $query->bindValue(10, $correo);
        $query->bindValue(11, $direccion);

        // Parámetros del Rol Proveedor
        $query->bindValue(12, $sucursal_id);

        $query->execute();
    }

    //Actualizar proveedor
    public function update_proveedor(
        $prov_id,
        $tipo_persona_id,
        $primer_nombre,
        $segundo_nombre,
        $primer_apellido,
        $segundo_apellido,
        $ruc,
        $cedula,
        $fecha_nacimiento,
        $telefono,
        $correo,
        $direccion,
        $sucursal_id
    )
    {
        $conectar = parent::Conexion();
        // El SP requiere 13 parámetros en total.
        $sql = "EXEC SP_U_PROVEEDOR ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?";
        
        $query = $conectar->prepare($sql);
        
        $query->bindValue(1, $prov_id);
        $query->bindValue(2, $tipo_persona_id);
        $query->bindValue(3, $primer_nombre);
        $query->bindValue(4, $segundo_nombre);
        $query->bindValue(5, $primer_apellido);
        $query->bindValue(6, $segundo_apellido);
        $query->bindValue(7, $ruc);
        $query->bindValue(8, $cedula);
        $query->bindValue(9, $fecha_nacimiento);
        $query->bindValue(10, $telefono);
        $query->bindValue(11, $correo);
        $query->bindValue(12, $direccion);
        $query->bindValue(13, $sucursal_id);
        
        $query->execute();
    }
    /*
    public function update_proveedor($prov_id, $suc_id, $prov_nom, $prov_ruc, $prov_telf, $prov_direcc, $prov_correo)
    {
        $conectar = parent::Conexion();
        $sql = "SP_U_PROVEEDOR_01 ?,?,?,?,?,?,?"; //SP_U_PROVEEDOR
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $prov_id);
        $query->bindValue(2, $suc_id);
        $query->bindValue(3, $prov_nom);
        $query->bindValue(4, $prov_ruc);
        $query->bindValue(5, $prov_telf);
        $query->bindValue(6, $prov_direcc);
        $query->bindValue(7, $prov_correo);
        $query->execute();
    }*/


    /* TODO: Listar Registro por ID en especifico */
    public function get_proveedor_x_prov_id($prov_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_PROVEEDOR_BY_ID ?"; //SP_L_PROVEEDOR_BY_ID
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $prov_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
