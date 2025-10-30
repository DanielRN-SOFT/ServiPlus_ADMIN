<?php 

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["nombreCargo"], $_POST["estadoCargo"]) && !empty($_POST["nombreCargo"]) && !empty($_POST["estadoCargo"])){
        require_once '../model/MYSQL.php';
        $id = $_POST["id"];
        $mysql = new MySQL();
        $mysql->conectar();
        $nombreCargo = filter_var(trim($_POST["nombreCargo"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $estadoCargo = filter_var(trim($_POST["estadoCargo"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cargo = $mysql->efectuarConsulta("SELECT * FROM cargos where nombreCargo = '$nombreCargo' AND IDcargo != $id");
        if (mysqli_num_rows($cargo) > 0) {
            echo json_encode([
                "success" => false,
                "message" => "El nombre de ese cargo ya existe"
            ]);
        } else {
            $resultado = $mysql->efectuarConsulta("UPDATE cargos set nombreCargo = '$nombreCargo', estadoCargo = '$estadoCargo' where IDcargo = $id");

            if ($resultado) {
                echo json_encode(
                    [
                        "success" => true,
                        "message" => "Cargo editado exitosamente"
                    ]
                );
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Ocurrio un error"
                ]);
            }
        }
    }else{
        echo json_encode([
            "success" => false,
            "message" => "Todos los campos son obligatorios"
        ]);
    }
   
   
}



?>