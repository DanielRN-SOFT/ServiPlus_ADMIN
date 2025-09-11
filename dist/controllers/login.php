<?php

    if (isset($_POST["numDocumento"], $_POST["password"]) && !empty($_POST["numDocumento"]) && !empty($_POST["password"])) {
        require_once "../model/MYSQL.php";
        $mysql = new MySQL();
        $mysql->conectar();

        $numDocumento = filter_var(trim($_POST["numDocumento"]), FILTER_SANITIZE_NUMBER_INT);
        $passwordPlano = $_POST["password"];
        $hash = password_hash($passwordPlano, PASSWORD_BCRYPT);

        $resultado = $mysql->efectuarConsulta("SELECT nombre, IDempleado, estado, rol_id, nombre_rol, password FROM empleados JOIN roles ON id_rol = rol_id where numDocumento = $numDocumento");
        $estadoEmpleados = $mysql->efectuarConsulta("SELECT estado from empleados where numDocumento = $numDocumento");
        $estado = $estadoEmpleados->fetch_assoc()["estado"];
        if ($usuarios = mysqli_fetch_assoc($resultado)) {
            if ($estado == "Activo") {
                if (password_verify($passwordPlano, $usuarios["password"])) {

                    session_start();

                    require_once '../model/usuarios.php';

                    $usuario = new usuarios();
                    $usuario->setNombre($usuarios["nombre"]);
                    $usuario->setId($usuarios['IDempleado']);
                    $usuario->setCargo($usuarios['rol_id']);
                    $usuario->setNombreRol($usuarios['nombre_rol']);
                    

                    $_SESSION['usuario'] = $usuario;

                    $_SESSION['acceso'] = true;

                    header("Location: ../index.php");
                }else{
                header("Location: ../views/login.php");
                }
            } else {

                echo '
            <!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ERRROR!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
  <div class="row">
  <div class="col-md-12 d-flex justify-content-center align-items-center min-vh-100 text-light">
  <div class = "bg-danger rounded shadow  p-5">
<h1 class="fw-bold text-center display-5 "> Error 404 </h1>
  <h2 class="fw-bold text-center">El usuario se encuentra INACTIVO </h2>
  </div>
    
  </div>
  </div>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>
            ';
                header("refresh:2; url=../views/login.php");
            }
        } else {
            header("Location: ../views/login.php");
        }
    } else {
        header("Location: ../views/login.php");
    }
