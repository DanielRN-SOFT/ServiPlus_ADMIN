<?php

require_once '../model/MYSQL.php';
class empleadoController{
    public function obtenerEmpleados(){
        $mysql = new MySQL();
        $mysql->conectar();
        $consulta = "SELECT empleados.nombre, empleados.numDocumento, cargos.nombreCargo, departamentos.nombreDepartamento, empleados.fechaIngreso, empleados.salarioBase, empleados.estado from empleados JOIN cargos ON cargos.IDcargo = empleados.cargo_id JOIN departamentos ON departamentos.IDdepartamento = empleados.departamento_id WHERE empleados.estado = 'Activo'";
        $resultado = $mysql->efectuarConsulta($consulta);
        $empleados = [];

        while($fila = $resultado->fetch_assoc()){
            $empleados[] = $fila;
        }
          return $empleados;
        
    }

    public function obtenerEmpleadosPorDepartamento($departamento){
        $mysql = new MySQL();
        $mysql->conectar();
        $consulta = "SELECT empleados.nombre, empleados.numDocumento, cargos.nombreCargo, departamentos.nombreDepartamento, empleados.fechaIngreso, empleados.salarioBase, empleados.estado from empleados JOIN cargos ON cargos.IDcargo = empleados.cargo_id JOIN departamentos ON departamentos.IDdepartamento = empleados.departamento_id WHERE departamentos.IDdepartamento = $departamento";
        $resultado = $mysql->efectuarConsulta($consulta);
        $empleados = [];
        while($fila = $resultado->fetch_assoc()){
            $empleados[] = $fila;
        }

        return $empleados;
    }
   
}



?>