<?php
require_once '../model/MYSQL.php';
$mysql = new MySQL();
$mysql->conectar();
$query = "SELECT nombreDepartamento, COUNT(*) as cantidad FROM empleados LEFT JOIN departamentos ON departamentos.IDdepartamento = empleados.departamento_id GROUP BY departamentos.nombreDepartamento;";
$resultado = $mysql->efectuarConsulta($query);
$data = [];
while($row = mysqli_fetch_assoc($resultado)){
    $row["cantidad"] = (int)$row["cantidad"];
    $data[] = $row;
}
header('Content-Type:application/json');
if(!$data){
    $data = [];
}
echo json_encode($data);
exit();
?>