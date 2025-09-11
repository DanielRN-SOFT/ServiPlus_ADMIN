<?php 

require_once '../model/MYSQL.php';

$id = $_GET["IDempleado"];

$mysql = new MySQL();

$mysql->conectar();
$estadoEmpleados = $mysql->efectuarConsulta("SELECT estado FROM empleados where IDempleado = $id");
$estado = $estadoEmpleados->fetch_assoc()["estado"];
if($estado == "Activo"){
    $mysql->efectuarConsulta("UPDATE empleados set estado = 'Inactivo' where IDempleado = $id");
}else {
    $mysql->efectuarConsulta("UPDATE empleados set estado = 'Activo' where IDempleado = $id");
}


$mysql->desconectar();

header('Location: ../index.php');
exit();

?>