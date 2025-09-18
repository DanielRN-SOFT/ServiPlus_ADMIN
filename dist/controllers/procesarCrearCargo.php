<?php 

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["nombreCargo"]) && !empty($_POST["nombreCargo"])){
        require_once '../model/MYSQL.php';

        $mysql = new MySQL();
        $mysql->conectar();
        $nombreCargo = filter_var(trim($_POST["nombreCargo"]));
        $cargo = $mysql->efectuarConsulta("SELECT * FROM cargos where nombreCargo = '$nombreCargo'");
        if (mysqli_num_rows($cargo) > 0) {
            echo json_encode([
                "success" => false,
                "message" => "El nombre de ese cargo ya existe"
            ]);
        } else {
            $resultado = $mysql->efectuarConsulta("INSERT INTO cargos (nombreCargo, estadoCargo) VALUES('$nombreCargo', 'Activo')");

            if ($resultado) {
                echo json_encode(
                    [
                        "success" => true,
                        "message" => "Cargo agregado exitosamente"
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