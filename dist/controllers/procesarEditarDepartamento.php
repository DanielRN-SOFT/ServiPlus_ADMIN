<?php
require_once '../model/MYSQL.php';


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST["nombreDepartamento"]) && !empty($_POST["nombreDepartamento"])) {
        $mysql = new MySQL();
        $mysql->conectar();

        $id = $_POST["id"];
        $nombreDepartamento = filter_var(trim($_POST["nombreDepartamento"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $estadoDepartamento = filter_var(trim($_POST["estadoDepartamento"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $departamentos = $mysql->efectuarConsulta("SELECT * FROM departamentos WHERE nombreDepartamento = '$nombreDepartamento' AND IDdepartamento != $id");
        if (mysqli_num_rows($departamentos) > 0) {
            echo json_encode([
                "success" => false,
                "message" => "El nombre de ese departamento ya existe"
            ]);
            exit();
        } else {
            $mysql->efectuarConsulta("UPDATE departamentos SET nombreDepartamento = '$nombreDepartamento', estadoDepartamento = '$estadoDepartamento' WHERE IDdepartamento = $id");
            echo json_encode([
                "success" => true,
                "message" => "Departamento editado exitosamente"
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