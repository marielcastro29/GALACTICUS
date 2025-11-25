<?php
    /* TODO: Inicio de Session */
    session_start();
    class Conectar{
        protected $dbh;

        protected function Conexion(){
            try{
                /* TODO: Cadena de Conexion */
                $conectar = $this->dbh=new PDO("sqlsrv:Server=localhost;Database=GALACTICUSBD","sa","1234");
                return $conectar;
            }catch (Exception $e){
                /* TODO: En caso de error mostrar mensaje */
                print "Error Conexion BD". $e->getMessage() ."<br/>";
                die();
            }
        }

        public static function ruta(){
            /* TODO: Ruta de acceso del Proyecto (Validar su puerto y nombre de carpeta por el suyo) */
            return "http://localhost/PROYECTO BD2/";
            /* return "https://compraventaandercode.azurewebsites.net/"; */
        }
    }
?>