<?php
require_once '../libs/fpdf/fpdf.php';
require_once '../controllers/empleadoController.php';
if(isset($_POST["departamento"]) && !empty($_POST["departamento"])){
    $controlador = new empleadoController();
    $empleados = $controlador->obtenerEmpleadosPorDepartamento($_POST["departamento"]);
}

$pdf = new FPDF();

$pdf->AddPage();

$pdf->SetXY(0,30);
$pdf->SetFont('Arial', "B", 12);
$pdf->Cell(0,10, "Listado de empleados", 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 8);


$pdf->Cell(45, 10, 'Nombre', 1, 0);
$pdf->Cell(20, 10, 'Documento', 1, 0);
$pdf->Cell(30, 10, 'Cargo', 1, 0);
$pdf->Cell(40, 10, 'Departamento', 1, 0);
$pdf->Cell(20, 10, 'FechaIngreso', 1, 0);
$pdf->Cell(25, 10, 'Salario', 1, 0);
$pdf->Cell(15, 10, 'Estado', 1, 1);


$pdf->SetFont("Arial","" ,8);
foreach ($empleados as $emp) {
    $pdf->Cell(45, 10, $emp["nombre"], 1);
    $pdf->Cell(20, 10, $emp["numDocumento"], 1);
    $pdf->Cell(30, 10, $emp["nombreCargo"], 1);
    $pdf->Cell(40, 10, $emp["nombreDepartamento"], 1);
    $pdf->Cell(20, 10, $emp["fechaIngreso"], 1);
    $pdf->Cell(25, 10, $emp["salarioBase"], 1);
    $pdf->Cell(15, 10, $emp["estado"], 1);
    $pdf->Ln();
}

if ($pdf->GetY() > 250) {
    $pdf->AddPage(); // previene 
}

$pdf->SetY(265);
$pdf->SetFont('Arial', 'I', 9);
$pdf->Cell(0, 10, utf8_decode('Elaborado por Daniel F. Ramirez. Fecha de elaboracion: ') . date('d/m/Y H:i'), 0, 0, 'C');
$pdf->Output();




?>