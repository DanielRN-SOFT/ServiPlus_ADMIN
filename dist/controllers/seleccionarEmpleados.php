<?php

require_once '../model/MYSQL.php';

$mysql = new MySQL();

$mysql->conectar();

$resultado = $mysql->efectuarConsulta("SELECT IDempleado, nombre, numDocumento, roles.nombre_rol, cargos.nombreCargo, departamentos.nombreDepartamento, fechaIngreso, salarioBase, estado, correoElectronico, telefono, imagen FROM empleados JOIN cargos ON cargos.IDcargo = empleados.cargo_id JOIN departamentos ON departamentos.IDdepartamento = empleados.departamento_id JOIN roles ON rol_id = id_rol");

$data = [];

while($row = mysqli_fetch_assoc($resultado)){
    $data[] = $row;
}

header('Content-Type:application/json');
echo json_encode($data);

?>