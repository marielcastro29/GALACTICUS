<?php
    class Menu extends Conectar{
        /* TODO: Listar Registros */
        public function get_menu_x_rol_id($rol_id){
            $conectar=parent::Conexion();
            $sql="SP_L_MENU_BY_ROL_ID ?";//
            $query=$conectar->prepare($sql);
            $query->bindValue(1,$rol_id);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /* TODO: Registrar el detalle automaticamente que no tiene el Menu */
        public function insert_menu_detalle_x_rol_id($rol_id){
            $conectar=parent::Conexion();
            $sql="SP_I_MENU_BY_ROL_ID ?";//
            $query=$conectar->prepare($sql);
            $query->bindValue(1,$rol_id);
            $query->execute();
        }

        /* TODO: Habilitar permiso al rol */
        public function update_menu_habilitar($mend_id){
            $conectar=parent::Conexion();
            $sql="SP_U_MENU_HABILITAR ?";//
            $query=$conectar->prepare($sql);
            $query->bindValue(1,$mend_id);
            $query->execute();
        }

        /* TODO: Deshabilitar permiso al rol */
        public function update_menu_deshabilitar($mend_id){
            $conectar=parent::Conexion();
            $sql="SP_U_MENU_DESHABILITAR ?";
            $query=$conectar->prepare($sql);
            $query->bindValue(1,$mend_id);
            $query->execute();
        }

    }
?>