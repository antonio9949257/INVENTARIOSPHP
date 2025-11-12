<?php
require('fpdf186/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

// Fuente y tamaño
$pdf->SetFont('Courier', 'B', 20);

// Color del texto (R, G, B)
$pdf->SetTextColor(65, 10, 200);

// Posición X
$pdf->SetX(75);

// Texto del paciente
$pdf->Cell(50, 18, 'PACIENTE: Juan Pérez', 0, 1, 'L');

// Fuente más grande
$pdf->SetFont('Courier', '', 36);

// Color de relleno
$pdf->SetFillColor(33, 18, 137);

// Posición Y
$pdf->SetY(35);

// Celda de prueba
$pdf->Cell(25, 18, '.', 1, 0, 'L', true);
$pdf->Cell(10, 10, 'Edad: 35', 1, 1, 'L');

// Imagen (por ejemplo, icono o logo)
$pdf->Image('fpdf186/tutorial/logo.png', 58, 5, 15, 15);
$pdf->Image('fpdf186/tutorial/logo.png', 130, 20, 48, 60);

// Salida del archivo PDF
$pdf->Output();
?>