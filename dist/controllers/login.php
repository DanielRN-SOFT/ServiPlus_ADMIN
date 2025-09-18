<?php

    if (isset($_POST["numDocumento"], $_POST["password"]) && !empty($_POST["numDocumento"]) && !empty($_POST["password"])) {
        require_once "../model/MYSQL.php";
        $mysql = new MySQL();
        $mysql->conectar();

        $numDocumento = filter_var(trim($_POST["numDocumento"]), FILTER_SANITIZE_NUMBER_INT);
        $passwordPlano = $_POST["password"];
        $hash = password_hash($passwordPlano, PASSWORD_BCRYPT);

        $resultado = $mysql->efectuarConsulta("SELECT nombre, IDempleado, estado, rol_id, nombre_rol, estado,password FROM empleados JOIN roles ON id_rol = rol_id where numDocumento = $numDocumento");
       
        if ($usuarios = mysqli_fetch_assoc($resultado)) {
        $estado = $usuarios["estado"];
            if ($estado == "Activo") {
                if (password_verify($passwordPlano, $usuarios["password"])) {

                    session_start();

                    require_once '../model/usuarios.php';

                    $usuario = new usuarios();
                    $usuario->setNombre($usuarios["nombre"]);
                    $usuario->setId($usuarios['IDempleado']);
                    $usuario->setRol($usuarios['rol_id']);
                    $usuario->setNombreRol($usuarios['nombre_rol']);
                    

                    $_SESSION['usuario'] = $usuario;

                    $_SESSION['acceso'] = true;

                    // header("Location: ../index.php");

                    echo json_encode([
                        "success" => true,
                        "message" => "Inicio de sesion EXITOSAMENTE"
                    ]);
                    exit();
                }else{
                echo json_encode([
                    "success" => false,
                    "message" => "Contraseña incorrecta"
                ]);
                exit();
                }
            } else {
            echo json_encode([
                "success" => false,
                "message" => "Usuario INACTIVO"
            ]);
            exit();
             
            }
        } else {
        echo json_encode([
            "success" => false,
            "message" => "Usuario no ENCONTRADO"
        ]);
        exit();
        }
    } else {
        header("Location: ../views/login.php");
    }
