<?php



// Verificar que se envie por metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que todos los campos sean rellenados
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

        // Requerir al modelo a utilizar
        require_once '../model/MYSQL.php';

        // Instanciar el modelo 
        $mysql = new MySQL();

        // Conexion a la base de datos
        $mysql->conectar();

        //  Capturar el ID para seleccionar el empleado
        $id = intval($_POST["id"]);

        
        // Sanetizacion de datos
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


        // Verificar que el numero de documento sea POSITIVO
        if ($numDocumento < 0) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un valor positivo en el numero de documento"
            ]);
            exit();
        }

        // Verificar que el salario base sea POSITIVO
        if ($salarioBase < 0) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un valor positivo en el salario base"
            ]);
            exit();
        }

        // Verificar que el numero de telefono sea POSITIVO
        if ($telefono < 0) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un valor positivo en el telefono"
            ]);
            exit();
        }


        // Consultas para determinar si existe ya un numero de doc o email en la base de datos
        $validacionNum = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE numDocumento = $numDocumento AND IDempleado != $id");
        $validacionCorreo = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE correoElectronico = '$correoElectronico' AND IDempleado != $id");


        // Si el resultado de la consulta retorn mas de una fila YA EXISTE
        if (mysqli_num_rows($validacionNum) > 0) {
            echo json_encode([
                "success" => false,
                "message" => "No de identificacion REPETIDO"
            ]);
            exit();
        }

        // Verificar el formato correcto para el email
        if (!filter_var($correoElectronico, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un correo electronico valido"
            ]);
            exit();
        }


        // Si el resultado de la consulta retorn mas de una fila YA EXISTE
        if (mysqli_num_rows($validacionCorreo) > 0) {
            echo json_encode([
                "success" => false,
                "message" => "Correo electronico REPETIDO"
            ]);
            exit();
        }

        // Consulta para seleccionar el password y la ruta de la img en la base de datos
        $res = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE IDempleado = $id");
        $fila = $res->fetch_assoc();
        $passwordBD = $fila['password'];
        $rutaAnterior = $fila['imagen'];
        $ruta = $rutaAnterior;


        // Si el usuario subió una nueva imagen
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            // Verifique el formato de la img correcto
            $permitidos = ['image/jpeg' => '.jpg', 'image/png' => '.png'];
            $tipo = mime_content_type($_FILES['foto']['tmp_name']);

            // Si retorna false LANZA LA ALERTA de formato incorrecto
            if (!array_key_exists($tipo, $permitidos)) {
                echo json_encode([
                    "success" => false,
                    "message" => "Solo se permiten formatos JPG o PNG"
                ]);
                exit();
            } else {
                // Si no la agrega
                $ext = ($tipo === 'image/png') ? '.png' : '.jpg';
                $nombreUnico = 'imagen_' . date("Ymd_Hisv") . $ext;
                $ruta = 'assets/img/' . $nombreUnico;
                $rutaAbsoluta = __DIR__ . '/../' . $ruta;
            }


            // En caso de cumplir con las validaciones se sube la img al proyecto
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaAbsoluta)) {
                $anteriorAbsoluta = __DIR__ . '/../' . $rutaAnterior;
                if (file_exists($anteriorAbsoluta)) {
                    unlink($anteriorAbsoluta);
                }
            }
        } else {
            // Sino subio ninguna IMG se asigne el valor de la ruta al que esta puesto en la BD
            $ruta = $rutaAnterior;
        }

        // Si el usuario cambia la contraseña 
        if (isset($_POST["oldPassword"], $_POST["newPassword"]) && !empty($_POST["oldPassword"]) && !empty($_POST["newPassword"])) {
            // Verificar que coincida el password que se digita con el de la base de datos
            if (password_verify($oldPassword, $passwordBD)) {
                // En caso de que si, se asigne un nuevo hash al campo de nueva contraseña
                $newPassword = password_hash($_POST["newPassword"], PASSWORD_BCRYPT);
            } else {
                // En caso de que no, la contraseña es incorrecta
                echo json_encode([
                    "success" => false,
                    "message" => "Contraseña INCORRECTA"
                ]);
                exit();
            }
        } else {
            // Si no cambia la contraseña se deje la que esta en la BD
            $newPassword = $passwordBD;
        }


        // En caso de pasar todas la validaciones se ejecute el UPDATE
        $update = $mysql->efectuarConsulta("UPDATE empleados SET 
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

      

        // En caso de que la consulta sea exitosa retorne un mensaje de exito al sweet alert
        if($update){
            echo json_encode([
                "success" => true,
                "message" => "Empleado editado exitosamente",
            ]);
            exit();
        }else{
            echo json_encode([
                "success" => false,
                "message" => "Ocurrio un error el update",
            ]);
            exit();
        }

        //Desconexion de la base de datos
        $mysql->desconectar();
        
    } else {
        // En caso de no se envie en el formato numerico esperado por el HTML 
        // HTML convierte esos datos en un string vacio ""

        // Validar un valor numerico en el num doc
        if (!filter_var($_POST["numDocumento"], FILTER_VALIDATE_INT)) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un numero de documento valido"
            ]);
            exit();
        }

        // Validar un valor numerico en el salario base
        if (!filter_var($_POST["salarioBase"], FILTER_VALIDATE_FLOAT)) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un salario valido"
            ]);
            exit();
        }


        // Validar un valor numerico en el telefono
        if (!filter_var($_POST["telefono"], FILTER_VALIDATE_INT)) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un numero de telefono valido"
            ]);
            exit();
        }

        // En caso de que no sea ningun problema con los numeros

        // Es porque faltan campos por rellenar
        echo json_encode([
            "success" => false,
            "message" => "Todos los campos son obligatorios"
        ]);
        exit();
    }
}
