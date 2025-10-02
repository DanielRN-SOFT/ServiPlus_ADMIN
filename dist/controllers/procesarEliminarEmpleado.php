<?php


// Verificar que se envie por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Capturar el ID que se envia
    $id = $_POST["id"];

    // Requerir el modelo a utilizar
    require_once '../model/MYSQL.php';

    // Instanciar el modelo
    $mysql = new MySQL();

    // Conectar a la base de datos
    $mysql->conectar();

    // Verificar el estado en el que se encuentra el empleado
    $estadoEmpleados = $mysql->efectuarConsulta("SELECT estado FROM empleados where IDempleado = $id");
    $estado = $estadoEmpleados->fetch_assoc()["estado"];

    // Si es activo es porque se va eliminar (INACTIVO)
    if ($estado == "Activo") {
        $res = $mysql->efectuarConsulta("UPDATE empleados set estado = 'Inactivo' where IDempleado = $id");
        // Si la consulta se ejecuta correctamente, manda el mensaje al sweet alert
        if ($res) {
            echo json_encode([
                "success" => true,
                "message" => "Empleado eliminado exitosamente"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Error al eliminar empleado"
            ]);
        }
    } else {
        // Sino el estado es INACTIVO por lo que se quiere reintegrar el empleado
        $mysql->efectuarConsulta("UPDATE empleados set estado = 'Activo' where IDempleado = $id");
        echo json_encode([
            "success" => true,
            "message" => "Empleado restablecido exitosamente"
        ]);
    }

    // Desconexion a la base de datos
    $mysql->desconectar();
}
