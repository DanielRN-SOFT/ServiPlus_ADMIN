<?php

require_once '../model/MYSQL.php';
$mysql = new MySQL();
$mysql->conectar();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST["id"];
    $estadoDepartamentos = $mysql->efectuarConsulta("SELECT * FROM departamentos where IDdepartamento = $id");
    $estadoFila = $estadoDepartamentos->fetch_assoc()["estadoDepartamento"];
    if ($estadoFila == "Activo") {
        $res = $mysql->efectuarConsulta("UPDATE departamentos SET estadoDepartamento = 'Inactivo' WHERE IDdepartamento = $id");
        if ($res) {
            echo json_encode([
                "success" => true,
                "message" => "Departamento eliminado exitosamente"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Ocurrio un error"
            ]);
        }
    } else {
        $res = $mysql->efectuarConsulta("UPDATE departamentos SET estadoDepartamento = 'Activo'  WHERE IDdepartamento = $id");
        if ($res) {
            echo json_encode([
                "success" => true,
                "message" => "Departamento restablecido exitosamente"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Ocurrio un error"
            ]);
        }
    }
}

?>