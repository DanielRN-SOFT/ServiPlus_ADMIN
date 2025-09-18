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
        && isset($_POST["cargo"]) && !empty($_POST["cargo"])
        && isset($_POST["departamento"]) && !empty($_POST["departamento"])
        && isset($_POST["fechaIngreso"]) && !empty($_POST["fechaIngreso"])
        && isset($_POST["salarioBase"]) && !empty($_POST["salarioBase"])
        && isset($_POST["telefono"]) && !empty($_POST["telefono"])
        && isset($_POST["correoElectronico"]) && !empty($_POST["correoElectronico"])
        && isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK
        && isset($_POST["password"]) && !empty($_POST["password"])
    ) {


        $nombre = filter_var(trim($_POST["nombre"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $numDocumento = filter_var(trim($_POST["NumDocumento"]), FILTER_SANITIZE_NUMBER_INT);
        $cargo = filter_var(trim($_POST["cargo"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $departamento = filter_var(trim($_POST["departamento"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fechaIngreso = filter_var(trim($_POST["fechaIngreso"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $salarioBase = filter_var(trim($_POST["salarioBase"]), FILTER_SANITIZE_NUMBER_FLOAT);
        $telefono = filter_var(trim($_POST["telefono"]), FILTER_SANITIZE_NUMBER_INT);
        $correoElectronico = filter_var(trim($_POST["correoElectronico"]), FILTER_SANITIZE_EMAIL);
        $passwordPlano = $_POST["password"];
        $hash = password_hash($passwordPlano, PASSWORD_BCRYPT);
        $rol = filter_var(trim($_POST["rol"]), FILTER_SANITIZE_NUMBER_INT);
        $validacionNum = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE numDocumento = $numDocumento");
        $validacionCorreo = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE correoElectronico = '$correoElectronico'");
        if (mysqli_num_rows($validacionNum) > 0 || mysqli_num_rows($validacionCorreo)) {
           session_start();
            $_SESSION["mensaje"] = "Numero de documento o E-mail ya existente en el sistema";
            $_SESSION["pagina"] = "crearEmpleado";
            header('Location: ../views/error404.php');
           
        } else {

            $permitidos = ['image/jpeg' => '.jpg', 'image/png' => '.png'];
            $tipo = mime_content_type($_FILES['foto']['tmp_name']);
            if (!array_key_exists($tipo, $permitidos)) {
                session_start();
                $_SESSION["mensaje"] = "Solo se permiten formatos .jpg y .png";
                $_SESSION["pagina"] = "crearEmpleado";
                header('Location: ../views/error404.php');
                exit();
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
    } else {
        session_start();
        $_SESSION["mensaje"] = "Faltan campos por rellenar";
        $_SESSION["pagina"] = "crearEmpleado";
        header('Location: ../views/error404.php');
    }
}
