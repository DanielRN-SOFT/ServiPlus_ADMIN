<?php
require_once '../model/MYSQL.php';

$mysql = new MySQL();
$mysql->conectar();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST["nombreDepartamento"]) && !empty($_POST["nombreDepartamento"])) {
        $nombreDepartamento = filter_var(trim($_POST["nombreDepartamento"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $departamentos = $mysql->efectuarConsulta("SELECT * FROM departamentos WHERE nombreDepartamento = '$nombreDepartamento'");
        if (mysqli_num_rows($departamentos) > 0) {
            echo json_encode([
                "success" => false,
                "message" => "El nombre de ese departamento ya existe"
            ]);
            exit();
        } else {
            $mysql->efectuarConsulta("INSERT INTO departamentos(nombreDepartamento, estadoDepartamento) VALUES('$nombreDepartamento', 'Activo')");
            echo json_encode([
                "success" => true,
                "message" => "Departamento agregado exitosamente"
            ]);
        }
    }else{
        echo json_encode([
            "success" => false,
            "message" => "Faltan campos por rellenar"
        ]);
    }
}



?>