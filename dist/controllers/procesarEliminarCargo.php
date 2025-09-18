<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["id"]) && !empty($_POST["id"])){
        require_once '../model/MYSQL.php';
        $mysql = new MySQL();
        $mysql->conectar();

        $id = $_POST["id"];
        $estados = $mysql->efectuarConsulta("SELECT * FROM cargos WHERE IDcargo = $id");
        $filaEstado = $estados->fetch_assoc()["estadoCargo"];
        if ($filaEstado == "Activo") {
            $resultado = $mysql->efectuarConsulta("UPDATE cargos set estadoCargo = 'Inactivo' WHERE IDcargo = $id");
            if ($resultado) {
                echo json_encode([
                    "success" => true,
                    "message" => "Cargo eliminado exitosamente"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Ocurrio un error"
                ]);
            }
        } else {
            $resultado = $mysql->efectuarConsulta("UPDATE cargos set estadoCargo = 'Activo' WHERE IDcargo = $id");
            if ($resultado) {
                echo json_encode([
                    "success" => true,
                    "message" => "Cargo restablecido exitosamente"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Ocurrio un error"
                ]);
            }
        }
    }
}


?>