<?php

require_once '../model/MYSQL.php';
$mysql = new MySQL();

$mysql->conectar();

$cargos = $mysql->efectuarConsulta("SELECT * FROM cargos");
$departamentos = $mysql->efectuarConsulta("SELECT * FROM departamentos");
$roles = $mysql->efectuarConsulta("SELECT * FROM roles");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["nombre"]) && !empty($_POST["nombre"])
        && isset($_POST["NumDocumento"]) && !empty($_POST["NumDocumento"])
        && isset($_POST["NumDocumento"]) && !empty($_POST["NumDocumento"])
        && isset($_POST["cargo"]) && !empty($_POST["cargo"])
        && isset($_POST["departamento"]) && !empty($_POST["departamento"])
        && isset($_POST["fechaIngreso"]) && !empty($_POST["fechaIngreso"])
        && isset($_POST["salarioBase"]) && !empty($_POST["salarioBase"])
        && isset($_POST["telefono"]) && !empty($_POST["telefono"])
        && isset($_POST["correoElectronico"]) && !empty($_POST["correoElectronico"])
        && isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK
        && isset($_POST["password"]) && !empty($_POST["password"])
    ) {


        $nombre = filter_var($_POST["nombre"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $numDocumento = filter_var($_POST["NumDocumento"], FILTER_SANITIZE_NUMBER_INT);
        $cargo = filter_var($_POST["cargo"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $departamento = filter_var($_POST["departamento"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fechaIngreso = filter_var($_POST["fechaIngreso"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $salarioBase = filter_var($_POST["salarioBase"], FILTER_SANITIZE_NUMBER_INT);
        $telefono = filter_var($_POST["telefono"], FILTER_SANITIZE_NUMBER_INT);
        $correoElectronico = filter_var($_POST["correoElectronico"], FILTER_SANITIZE_EMAIL);
        $passwordPlano = $_POST["password"];
        $hash = password_hash($passwordPlano, PASSWORD_BCRYPT);
        $rol = filter_var($_POST["rol"], FILTER_SANITIZE_NUMBER_INT);
        $validacionNum = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE numDocumento = $numDocumento");
        $validacionCorreo = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE correoElectronico = '$correoElectronico'");
        if (mysqli_num_rows($validacionNum) > 0 || mysqli_num_rows($validacionCorreo)) {
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
<h1 class="fw-bold text-center "> Error 404 </h1>
  <h2 class="fw-bold text-center"> Numero de documento o E-mail repetido </h2>
  </div>
    
  </div>
  </div>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>
            ';
            header("refresh:2; url=../views/crearEmpleado.php");
        } else {

            $permitidos = ['image/jpeg' => '.jpg', 'image/png' => '.png'];
            $tipo = mime_content_type($_FILES['foto']['tmp_name']);
            if (!array_key_exists($tipo, $permitidos)) {
                die("Solo se permiten imagenes JPG y PNG");
            }

            $ext = $permitidos[$tipo];
            $nombre_unico = 'imagen_' . date('Ymd_Hisv') . $ext;
            $ruta = 'assets/img/' . $nombre_unico;
            $rutaAbsoluta = __DIR__ . '/../' . $ruta;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaAbsoluta)) {
                $mysql->efectuarConsulta("INSERT INTO empleados(nombre, numDocumento, cargo_id, departamento_id, fechaIngreso, salarioBase, estado, correoElectronico, telefono, imagen, password, rol_id) VALUES('$nombre' , $numDocumento, '$cargo' , '$departamento', '$fechaIngreso' , '$salarioBase' , 'Activo', '$correoElectronico', '$telefono', '$ruta' , '$hash', '$rol')");
                $mysql->desconectar();
                header('Location: ../index.php');
                exit();
            } else {
                echo "Error al guardar la imagen";
            }
        }
    }else{
        header('Location: ../views/crearEmpleado.php');
    }
}
