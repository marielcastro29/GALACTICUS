<?php
    class TipoContrato extends Conectar{
        /* TODO: Listar Registros */
        public function get_tipos_contrato(){
            $conectar=parent::Conexion();
            $sql="SP_L_TIPOS_CONTRATO";//
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>