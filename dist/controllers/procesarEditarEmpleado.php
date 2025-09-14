<?php
require_once '../model/MYSQL.php';

$mysql = new MySQL();
$mysql->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["nombre"]) && !empty($_POST["nombre"])
        && isset($_POST["numDocumento"]) && !empty($_POST["numDocumento"])
        && isset($_POST["cargo"]) && !empty($_POST["cargo"])
        && isset($_POST["departamento"]) && !empty($_POST["departamento"])
        && isset($_POST["fechaIngreso"]) && !empty($_POST["fechaIngreso"])
        && isset($_POST["salarioBase"]) && !empty($_POST["salarioBase"])
        && isset($_POST["telefono"]) && !empty($_POST["telefono"])
        && isset($_POST["correoElectronico"]) && !empty($_POST["correoElectronico"])
    ) {
        $id = intval($_POST["id"]);

        $nombre = filter_var(trim($_POST["nombre"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $numDocumento = filter_var(trim($_POST["numDocumento"]), FILTER_SANITIZE_NUMBER_INT);
        $cargo = filter_var(trim($_POST["cargo"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $departamento = filter_var(trim($_POST["departamento"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fechaIngreso = filter_var(trim($_POST["fechaIngreso"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $salarioBase = filter_var(trim($_POST["salarioBase"]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND);
        $telefono = filter_var(trim($_POST["telefono"]), FILTER_SANITIZE_NUMBER_INT);
        $correoElectronico = filter_var(trim($_POST["correoElectronico"]), FILTER_SANITIZE_EMAIL);
        $estado = filter_var(trim($_POST["estado"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $rol = filter_var(trim($_POST["rol"]), FILTER_SANITIZE_NUMBER_INT);
        $oldPassword = $_POST["oldPassword"];


        $validacionNum = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE numDocumento = $numDocumento AND IDempleado != $id");
        $validacionCorreo = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE correoElectronico = '$correoElectronico' AND IDempleado != $id");

        if (mysqli_num_rows($validacionNum) > 0) {
            echo json_encode([
                "success" => false,
                "message" => "No de identificacion REPETIDO"
            ]);
            exit();
        }

        if (mysqli_num_rows($validacionCorreo) > 0) {
            echo json_encode([
                "success" => false,
                "message" => "Correo electronico REPETIDO"
            ]);
            exit();
        }

            $res = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE IDempleado = $id");
            $fila = $res->fetch_assoc();
            $passwordBD = $fila['password'];
            $rutaAnterior = $fila['imagen'];
            $ruta = $rutaAnterior;


            // Si el usuario subió una nueva imagen
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $permitidos = ['image/jpeg' => '.jpg', 'image/png' => '.png'];
                $tipo = mime_content_type($_FILES['foto']['tmp_name']);
                if (!array_key_exists($tipo, $permitidos)) {
                echo json_encode([
                    "success" => false,
                    "message" => "Solo se permiten formatos JPG o PNG"
                ]);
                exit();
                }else{
                $ext = ($tipo === 'image/png') ? '.png' : '.jpg';
                $nombreUnico = 'imagen_' . date("Ymd_Hisv") . $ext;
                $ruta = 'assets/img/' . $nombreUnico;
                $rutaAbsoluta = __DIR__ . '/../' . $ruta;
                }
                

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaAbsoluta)) {
                    $anteriorAbsoluta = __DIR__ . '/../' . $rutaAnterior;
                    if (file_exists($anteriorAbsoluta)) {
                        unlink($anteriorAbsoluta);
                    }
                }
            } else {
                $ruta = $rutaAnterior;
            }

            if (isset($_POST["oldPassword"], $_POST["newPassword"]) && !empty($_POST["oldPassword"]) && !empty($_POST["newPassword"])) {
                if (password_verify($oldPassword, $passwordBD)) {
                    $newPassword = password_hash($_POST["newPassword"], PASSWORD_BCRYPT);
                } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Contraseña INCORRECTA"
                ]);
                exit();
                }
            } else {
                $newPassword = $passwordBD;
            }


            $mysql->efectuarConsulta("UPDATE empleados SET 
        nombre = '$nombre', 
        numDocumento = $numDocumento, 
        cargo_id = '$cargo', 
        departamento_id = '$departamento', 
        fechaIngreso = '$fechaIngreso', 
        salarioBase = $salarioBase, 
        estado = '$estado', 
        correoElectronico = '$correoElectronico', 
        telefono = '$telefono', 
        imagen = '$ruta',
        rol_id = $rol,
        password = '$newPassword'
        WHERE IDempleado = $id");

            $mysql->desconectar();
        echo json_encode([
            "success" => true,
            "message" => "Empleado editado exitosamente",
        ]);

        
     
        
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Todos los campos son obligatorios"
        ]);
        exit();
    }
}
