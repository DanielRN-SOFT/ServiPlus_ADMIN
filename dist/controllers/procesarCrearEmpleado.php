<?php

// Verificar el metodo que se utilize para enviar el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_POST["nombre"]) && !empty($_POST["nombre"])
        && isset($_POST["numDocumento"]) && !empty($_POST["numDocumento"])
        && isset($_POST["cargo"]) && !empty($_POST["cargo"])
        && isset($_POST["departamento"]) && !empty($_POST["departamento"])
        && isset($_POST["fechaIngreso"]) && !empty($_POST["fechaIngreso"])
        && isset($_POST["salarioBase"]) && !empty($_POST["salarioBase"])
        && isset($_POST["telefono"]) && !empty($_POST["telefono"])
        && isset($_POST["correoElectronico"]) && !empty($_POST["correoElectronico"])
        && isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK
        && isset($_POST["password"]) && !empty($_POST["password"])
    ) {

        // Requerir el modelo a utilizar
        require_once '../model/MYSQL.php';

        // Instanciar la clase
        $mysql = new MySQL();

        // Conectar a la base de datos
        $mysql->conectar();


        // SANETIZACION DE DATOS
        $nombre = filter_var(trim($_POST["nombre"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $numDocumento = filter_var(trim($_POST["numDocumento"]), FILTER_SANITIZE_NUMBER_INT);
        $cargo = filter_var(trim($_POST["cargo"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $departamento = filter_var(trim($_POST["departamento"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fechaIngreso = filter_var(trim($_POST["fechaIngreso"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $salarioBase = filter_var(trim($_POST["salarioBase"]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $telefono = filter_var(trim($_POST["telefono"]), FILTER_SANITIZE_NUMBER_INT);
        $correoElectronico = filter_var(trim($_POST["correoElectronico"]), FILTER_SANITIZE_EMAIL);
        $correoElectronico = filter_var(trim($correoElectronico), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $passwordPlano = $_POST["password"];
        $hash = password_hash($passwordPlano, PASSWORD_BCRYPT);
        $rol = filter_var(trim($_POST["rol"]), FILTER_SANITIZE_NUMBER_INT);

        // Validar que el num de documento sea POSITIVO
        if ($numDocumento < 0) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un valor positivo en el numero de documento"
            ]);
            exit();
        }

        // Validar que el salario base sea POSITIVO
        if ($salarioBase < 0) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un valor positivo en el salario base"
            ]);
            exit();
        }

        // Validar que el telefono sea POSITIVO
        if ($telefono < 0) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un valor positivo en el telefono"
            ]);
            exit();
        }


        // CONSULTAS para validar que no se repita el numero de doc y el correo
        $validacionNum = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE numDocumento = $numDocumento");
        $validacionCorreo = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE correoElectronico = '$correoElectronico'");

        // Si la consulta retorna más de una fila YA EXISTE
        if (mysqli_num_rows($validacionNum) > 0) {
            echo json_encode([
                "success" => false,
                "message" => "No de identificacion REPETIDO"
            ]);
            exit();
        }


        // Validar el formato de EMAIL
        if (!filter_var($correoElectronico, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un correo electronico valido"
            ]);
            exit();
        }


        // Si la consulta retorna más de una fila YA EXISTE
        if (mysqli_num_rows($validacionCorreo) > 0) {
            echo json_encode([
                "success" => false,
                "message" => "Correo electronico REPETIDO"
            ]);
            exit();
        }

        // Al momento de subir una imagen se verifica su formato 
        $permitidos = ['image/jpeg' => '.jpg', 'image/png' => '.png'];
        $tipo = mime_content_type($_FILES['foto']['tmp_name']);

        // En caso de que no cumpla con los formatos mande el ALERTA
        if (!array_key_exists($tipo, $permitidos)) {
            echo json_encode([
                "success" => false,
                "message" => "Solo se permiten formatos JPG o PNG"
            ]);
            exit();
        } else {
            // Si no agregue la imagen
            $ext = $permitidos[$tipo];
            $nombre_unico = 'imagen_' . date('Ymd_Hisv') . $ext;
            $ruta = 'assets/img/' . $nombre_unico;
            $rutaAbsoluta = __DIR__ . '/../' . $ruta;
        }

        // En caso de pase las validaciones se sube la imagen al proyecto
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaAbsoluta)) {
            // Efectuar la consulta en caso de cumplir con todas las validaciones
            $insert = $mysql->efectuarConsulta("INSERT INTO empleados(nombre, numDocumento, cargo_id, departamento_id, fechaIngreso, salarioBase, estado, correoElectronico, telefono, imagen, password, rol_id) VALUES('$nombre' , $numDocumento, '$cargo' , '$departamento', '$fechaIngreso' , '$salarioBase' , 'Activo', '$correoElectronico', '$telefono', '$ruta' , '$hash', '$rol')");

            // En caso de que la consulta sea exitosa entre a la decision
            if ($insert) {
                // Mandar el mensaje a el sweet alert EXITO
                echo json_encode([
                    "success" => true,
                    "message" => "Empleado creado exitosamente",
                ]);
                exit();
            }else{
                // Mandar el mensaje a el sweet alert DE ERROR
                echo json_encode([
                    "success" => false,
                    "message" => "ERROR al insertar",
                ]);
                exit();
            }

            // Desconectar la conexion de la base de datos
            $mysql->desconectar();
        } else {
            // Error al guardar la imagen
            echo json_encode([
                "success" => false,
                "message" => "Error al guardar la imagen"
            ]);
            exit();
        }
    } else {
        // En caso de que no entre a la decision del isset y empty
        // Puesto que si se envian numeros con letras o letras los input HTML no reciben nada de eso

        // Validar el mensaje de alerta para el numero de documento
        if (!filter_var($_POST["numDocumento"], FILTER_VALIDATE_INT)) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un numero de documento valido"
            ]);
            exit();
        }

        // Validar el mensaje de alerta para el salario base
        if (!filter_var($_POST["salarioBase"], FILTER_VALIDATE_FLOAT)) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un salario valido"
            ]);
            exit();
        }

        // Validar el mensaje de alerta para el telefono
        if (!filter_var($_POST["telefono"], FILTER_VALIDATE_INT)) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un numero de telefono valido"
            ]);
            exit();
        }

        // En caso de que no sea ninguna validacion de numeros 
        // Es porque faltan campos por rellenar
        echo json_encode([
            "success" => false,
            "message" => "Todos los campos son obligatorios"
        ]);
        exit();
    }
}
