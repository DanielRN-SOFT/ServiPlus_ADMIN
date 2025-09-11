<?php

require_once '../model/MYSQL.php';

$mysql = new MySQL();
$mysql->conectar();

$resultado = $mysql->efectuarConsulta("SELECT nombreCargo, COUNT(*) as cantidad FROM empleados JOIN cargos ON IDcargo = cargo_id GROUP by nombreCargo; ");

$data = [];

while($row = mysqli_fetch_assoc($resultado)){
    $row["cantidad"] = (int)$row["cantidad"];
    $data[] = $row;
}

header('Content-Type:application/json');
echo json_encode($data);


?>