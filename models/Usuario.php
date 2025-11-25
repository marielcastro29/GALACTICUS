<?php
class Usuario extends Conectar
{
    /* TODO: Listar Registros */
    public function get_usuario_x_suc_id($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_USUARIO_BY_SUCURSAL_ID ?"; //
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO: Listar Registro por ID en especifico */
    public function get_usuario_x_usu_id($usu_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_L_USUARIO_BY_ID ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $usu_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO: Eliminar o cambiar estado a eliminado */
    public function delete_usuario($usu_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_D_USUARIO ?"; //SP_D_USUARIO
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $usu_id);
        $query->execute();
    }

    /* TODO: Registro de datos */
    /*
    public function insert_usuario($suc_id, $usu_correo, $usu_nom, $usu_ape, $usu_dni, $usu_telf, $usu_pass, $rol_id, $usu_img)
    {
        $conectar = parent::Conexion();
        $sql = "SP_I_USUARIO_01 ?,?,?,?,?,?,?,?,?"; //SP_I_USUARIO
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $suc_id);
        $query->bindValue(2, $usu_correo);
        $query->bindValue(3, $usu_nom);
        $query->bindValue(4, $usu_ape);
        $query->bindValue(5, $usu_dni);
        $query->bindValue(6, $usu_telf);
        $query->bindValue(7, $usu_pass);
        $query->bindValue(8, $rol_id);
        $query->bindValue(9, $usu_img);
        $query->execute();
    }

    /* TODO:Actualizar Datos */
    /*
    public function update_usuario($usu_id, $suc_id, $usu_correo, $usu_nom, $usu_ape, $usu_dni, $usu_telf, $usu_pass, $rol_id, $usu_img)
    {
        $conectar = parent::Conexion();
        $sql = "SP_U_USUARIO_01 ?,?,?,?,?,?,?,?,?,?"; //SP_U_USUARIO
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $usu_id);
        $query->bindValue(2, $suc_id);
        $query->bindValue(3, $usu_correo);
        $query->bindValue(4, $usu_nom);
        $query->bindValue(5, $usu_ape);
        $query->bindValue(6, $usu_dni);
        $query->bindValue(7, $usu_telf);
        $query->bindValue(8, $usu_pass);
        $query->bindValue(9, $rol_id);
        $query->bindValue(10, $usu_img);
        $query->execute();
    }*/

    /* ===================================================
       INSERTAR USUARIO
       (Coincide con SP_CREAR_USUARIO - 17 Parámetros)
    =================================================== */
    public function insert_usuario($suc_id, $nom1, $nom2, $ape1, $ape2, $cedula, $telf, $correo, $dir, $fec_nac, $tipo_cont, $salario, $fec_cont, $user, $pass, $rol_id, $img)
    {
        $conectar = parent::Conexion();

        // 17 Parámetros
        $sql = "EXEC SP_CREAR_USUARIO ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?";

        $query = $conectar->prepare($sql);

        $query->bindValue(1, $suc_id);
        $query->bindValue(2, $nom1);
        $query->bindValue(3, $nom2);
        $query->bindValue(4, $ape1);
        $query->bindValue(5, $ape2);
        $query->bindValue(6, $cedula);
        $query->bindValue(7, $telf);
        $query->bindValue(8, $correo);
        $query->bindValue(9, $dir);
        $query->bindValue(10, $fec_nac); // Puede ser NULL
        $query->bindValue(11, $tipo_cont);
        $query->bindValue(12, $salario);
        $query->bindValue(13, $fec_cont); // Puede ser NULL
        $query->bindValue(14, $user);
        $query->bindValue(15, $pass);
        $query->bindValue(16, $rol_id);
        $query->bindValue(17, $img);

        $query->execute();
    }

    /* ===================================================
       ACTUALIZAR USUARIO
       (Coincide con SP_EDITAR_USUARIO - 19 Parámetros)
    =================================================== */
    public function update_usuario($usu_id, $suc_id, $nom1, $nom2, $ape1, $ape2, $cedula, $telf, $correo, $dir, $fec_nac, $tipo_cont, $salario, $fec_cont, $fec_fin, $user, $pass, $rol_id, $img)
    {
        $conectar = parent::Conexion();

        // 19 Parámetros (El primero es el ID del usuario)
        $sql = "EXEC SP_EDITAR_USUARIO ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?";

        $query = $conectar->prepare($sql);

        $query->bindValue(1, $usu_id);        // ID Usuario a editar
        $query->bindValue(2, $suc_id);
        $query->bindValue(3, $nom1);
        $query->bindValue(4, $nom2);
        $query->bindValue(5, $ape1);
        $query->bindValue(6, $ape2);
        $query->bindValue(7, $cedula);
        $query->bindValue(8, $telf);
        $query->bindValue(9, $correo);
        $query->bindValue(10, $dir);
        $query->bindValue(11, $fec_nac);
        $query->bindValue(12, $tipo_cont);
        $query->bindValue(13, $salario);
        $query->bindValue(14, $fec_cont);
        $query->bindValue(15, $fec_fin);      // Nuevo parámetro para desactivar usuario
        $query->bindValue(16, $user);
        $query->bindValue(17, $pass);         // Si viene vacío, el SP lo ignora
        $query->bindValue(18, $rol_id);
        $query->bindValue(19, $img);          // Si viene vacío, el SP lo ignora

        $query->execute();
    }

    public function update_usuario_pass($usu_id, $usu_pass)
    {
        $conectar = parent::Conexion();
        $sql = "SP_U_USUARIO_CONTRASENIA ?,?"; //
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $usu_id);
        $query->bindValue(2, $usu_pass);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO:Acceso al Sistema */
    /*
    public function login()
    {

        $conectar = parent::Conexion();
        if (is_numeric($_POST["suc_id"])) {
            if (isset($_POST["enviar"])) {
                /* TODO: Recepcion de Parametros desde la Vista Login */
    /*            $sucursal = $_POST["suc_id"];
                $correo = $_POST["usu_correo"];
                $pass =  $_POST["usu_pass"];
                echo $sucursal . ' ' . $correo . ' ' . $pass;




                $sql = "SP_L_USUARIO_04 ?,?,?";//SP_L_USUARIO_LOGIN
                $query = $conectar->prepare($sql);
                $query->bindValue(1, $sucursal);
                $query->bindValue(2, $correo);
                $query->bindValue(3, $pass);
                $query->execute();
                $resultado = $query->fetch();
                print_r($resultado);
                // echo $resultado["USU_ID"].' '.$resultado["USU_NOM"].' '.$resultado["USU_APE"].' '.$resultado["USU_CORREO"].' '.$resultado["SUC_ID"].' '.$resultado["ROL_ID"].' '.$resultado["USU_IMG"];
                if (is_array($resultado) and count($resultado) > 0) {

                    echo 'No vacio';
                    /* TODO:Generar variables de Session del Usuario */
    /*
                    $_SESSION["USU_ID"] = $resultado["USUARIO_ID"];
                    $_SESSION["SUC_ID"] = $resultado["SUCURSAL_ID"];
                    $_SESSION["ROL_ID"] = $resultado["ROL_ID"];
                    $_SESSION["USU_NOM"] = $resultado["PRIMER_NOMBRE"] + ' ' + $resultado["SEGUNDO_NOMBRE"];
                    $_SESSION["USU_IMG"] = $resultado["USUARIO_IMAGEN"];
                    $_SESSION["USU_APE"] = $resultado["PRIMER_APELLIDO"] + ' ' + $resultado["SEGUNDO_APELLIDO"];;
                    $_SESSION["USU_CORREO"] = $resultado["USUARIO_CORREO"];
                    $_SESSION["USU_USERNAME"] = $resultado["USUARIO_NOMBRE"];
                    



                    header("Location:" . Conectar::ruta() . "view/home/");


                    if (empty($sucursal) and empty($correo) and empty($pass)) {
                        exit();
                    } else {
                        $sql = "SP_L_USUARIO_LOGIN ?,?,?";//SP_L_USUARIO_LOGIN
                        $query = $conectar->prepare($sql);
                        $query->bindValue(1, $sucursal);
                        $query->bindValue(2, $correo);
                        $query->bindValue(3, $pass);
                        $query->execute();
                        $resultado = $query->fetch();

                        // echo $resultado["USU_ID"].' '.$resultado["USU_NOM"].' '.$resultado["USU_APE"].' '.$resultado["USU_CORREO"].' '.$resultado["SUC_ID"].' '.$resultado["ROL_ID"].' '.$resultado["USU_IMG"];
                        if (is_array($resultado) and count($resultado) > 0) {
                            /* TODO:Generar variables de Session del Usuario */
    /*
                            $_SESSION["USU_ID"] = $resultado["USUARIO_ID"];
                    $_SESSION["SUC_ID"] = $resultado["SUCURSAL_ID"];
                    $_SESSION["ROL_ID"] = $resultado["ROL_ID"];
                    $_SESSION["USU_NOM"] = $resultado["PRIMER_NOMBRE"] + ' ' + $resultado["SEGUNDO_NOMBRE"];
                    $_SESSION["USU_IMG"] = $resultado["USUARIO_IMAGEN"];
                    $_SESSION["USU_APE"] = $resultado["PRIMER_APELLIDO"] + ' ' + $resultado["SEGUNDO_APELLIDO"];;
                    $_SESSION["USU_CORREO"] = $resultado["USUARIO_CORREO"];
                    $_SESSION["USU_USERNAME"] = $resultado["USUARIO_NOMBRE"];
                    



                            header("Location:" . Conectar::ruta() . "view/home/");
                        } else {
                             header("Location:" . Conectar::ruta() . "view/404/");
                            exit();
                        }
                    }
                } else {
                    header("Location:" . Conectar::ruta() . "view/404/");
                    exit();
                }
            }
        }
    }
    
*/


    public function login()
    {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Validar formulario enviado
        if (!isset($_POST["enviar"]) || $_POST["enviar"] !== "si") {
            //header("Location:" . Conectar::ruta() . "view/404/");
            //exit();
        }

        // Recibir y sanear entradas
        $sucursal = isset($_POST["suc_id"]) ? trim($_POST["suc_id"]) : '';
        $correo   = isset($_POST["usu_correo"]) ? trim($_POST["usu_correo"]) : '';
        $pass     = isset($_POST["usu_pass"]) ? $_POST["usu_pass"] : '';

        //echo $sucursal.' '.$correo.' '.$pass;
        // Validaciones básicas
        if ($sucursal === '' || $correo === '' || $pass === '') {
            //header("Location:" . Conectar::ruta() . "view/404/");
            //exit();
        }
        if (!is_numeric($sucursal) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            //header("Location:" . Conectar::ruta() . "view/404/");
            //exit();
        }

        $conectar = parent::Conexion();
        try {
            // Llamada al SP que devuelve datos del usuario (incluye la contraseña guardada en texto plano)
            // SP debe aceptar (sucursal_id, correo) y devolver la fila con el campo USUARIO_PASS (o el alias que uses)
            $sql = "SP_L_USUARIO_LOGIN ?,?,?";
            $query = $conectar->prepare($sql);
            $query->bindValue(1, $sucursal);
            $query->bindValue(2, $correo);
            $query->bindValue(3, $pass);
            $query->execute();

            $resultado = $query->fetch(PDO::FETCH_ASSOC);

            if (!$resultado) {
                // usuario no encontrado
                //header("Location:" . Conectar::ruta() . "view/404/");
                //exit();
            }

            // Comparación en texto plano 
            $passAlmacenado = isset($resultado['USUARIO_PASS']) ? $resultado['USUARIO_PASS'] : '';

            if ($passAlmacenado === '' || $pass !== $passAlmacenado) {
                // contraseña incorrecta
                //header("Location:" . Conectar::ruta() . "view/404/");
                //exit();
            }

            // Autenticado: crear variables de sesión
            $_SESSION["USU_ID"]       = $resultado["USUARIO_ID"];
            $_SESSION["SUC_ID"]       = $resultado["SUCURSAL_ID"];
            $_SESSION["ROL_ID"]       = $resultado["ROL_ID"];
            $nombre1 = isset($resultado["PRIMER_NOMBRE"]) ? $resultado["PRIMER_NOMBRE"] : '';
            $nombre2 = isset($resultado["SEGUNDO_NOMBRE"]) ? $resultado["SEGUNDO_NOMBRE"] : '';
            $apellido1    = isset($resultado["PRIMER_APELLIDO"]) ? $resultado["PRIMER_APELLIDO"] : '';
            $apellido2    = isset($resultado["SEGUNDO_APELLIDO"]) ? $resultado["SEGUNDO_APELLIDO"] : '';
            //echo 'nombre 1: '.$nombre1.'apellido 1: '.$apellido1;
            //$_SESSION["USU_NOM"]      = trim($nombre1 . ' ' . $nombre2);
            //$_SESSION["USU_APE"]      = trim($apellido1 . ' ' . $apellido2);
            $_SESSION["USU_NOM"]      = $resultado["USUARIO_NOMBRE"];
            $_SESSION["ROL_NOM"]      = $resultado["ROL_NOMBRE"];
            $_SESSION["PRIMER_NOMBRE"]      = $nombre1;
            $_SESSION["PRIMER_APELLIDO"]      = $apellido1;
            $_SESSION["USU_APE"]      = trim($apellido1 . ' ' . $apellido2);
            $_SESSION["USU_CORREO"]   = isset($resultado["USUARIO_CORREO"]) ? $resultado["USUARIO_CORREO"] : $correo;
            $_SESSION["USU_USERNAME"] = isset($resultado["USUARIO_NOMBRE"]) ? $resultado["USUARIO_NOMBRE"] : '';
            $_SESSION["USU_IMG"]      = isset($resultado["USUARIO_IMAGEN"]) ? $resultado["USUARIO_IMAGEN"] : null;

            // Redirigir al home
            header("Location:" . Conectar::ruta() . "view/home/");
            exit();
        } catch (PDOException $e) {
            // Registrar error y redirigir (no exponer detalles en producción)
            error_log("Login error: " . $e->getMessage());
            //header("Location:" . Conectar::ruta() . "view/404/");
            //exit();
        }
    }

    /* TODO: Subit imagen de usuario */
    public function upload_image()
    {
        if (isset($_FILES["usu_img"])) {
            $extension = explode('.', $_FILES['usu_img']['name']);
            $new_name = rand() . '.' . $extension[1];
            $destination = '../assets/usuario/' . $new_name;
            move_uploaded_file($_FILES['usu_img']['tmp_name'], $destination);
            return $new_name;
        }
    }


    /* TODO: Obtener el total de usuarios por sucursal */
    public function get_cantidad_usuario($suc_id)
    {
        $conectar = parent::Conexion();
        $sql = "SP_CANTIDAD_USUARIO_X_SUC ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, '');
        $query->execute();
        $resultado = $query->fetch(PDO::FETCH_ASSOC);
        $totalusuario = $resultado['CANTIDAD USUARIO'];
        return $totalusuario;
    }

    /* TODO: Obtener datos completos de un usuario por su ID */
    public function get_usuario_x_id($usu_id)
    {

        $conectar = parent::Conexion();
        $sql = "SP_OBTENER_USUARIO_X_ID ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $usu_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
