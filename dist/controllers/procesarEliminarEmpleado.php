<?php

require_once '../model/MYSQL.php';

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $id = $_POST["id"];

    $mysql = new MySQL();

    $mysql->conectar();
    $estadoEmpleados = $mysql->efectuarConsulta("SELECT estado FROM empleados where IDempleado = $id");
    $estado = $estadoEmpleados->fetch_assoc()["estado"];
    if ($estado == "Activo") {
        $res = $mysql->efectuarConsulta("UPDATE empleados set estado = 'Inactivo' where IDempleado = $id");
        if($res){
            echo json_encode([
                "success" => true,
                "message" => "Empleado eliminado exitosamente"
            ]);
        }else{
            echo json_encode([
                "success" => false,
                "message" => "Error al eliminar empleado"
            ]);
        }
       
    } else {
        $mysql->efectuarConsulta("UPDATE empleados set estado = 'Activo' where IDempleado = $id");
        echo json_encode([
            "success" => true,
            "message" => "Empleado restablecido exitosamente"
        ]);
    }


    $mysql->desconectar();
}


