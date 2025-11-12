<?php
require('../fpdf186/fpdf.php');
require('db.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../img/logosinfonfo.png', 10, 8, 33);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 20);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->SetTextColor(40, 40, 40);
        $this->Cell(30, 10, 'Listado de Proveedores', 0, 0, 'C');
        // Fecha
        $this->SetFont('Arial', '', 10);
        $this->Cell(80, 10, date('d/m/Y'), 0, 1, 'R');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Tabla de datos
    function FancyTable($header, $data)
    {
        // Colores, ancho de línea y fuente en negrita para la cabecera
        $this->SetFillColor(200, 200, 200);
        $this->SetTextColor(40);
        $this->SetDrawColor(150);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');

        // Cabecera
        $w = array(15, 40, 35, 30, 40, 30); // Anchos de las columnas (ID, Nombre, Contacto, Telefono, Email, Direccion)
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();

        // Restauración de colores y fuentes para los datos
        $this->SetFillColor(245, 245, 245);
        $this->SetTextColor(0);
        $this->SetFont('');

        // Datos
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row['id'], 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, $row['nombre'], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row['contacto'], 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 6, $row['telefono'], 'LR', 0, 'L', $fill);
            $this->Cell($w[4], 6, $row['email'], 'LR', 0, 'L', $fill);
            $this->Cell($w[5], 6, $row['direccion'], 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// Creación del objeto PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Cargar datos
$sql = "SELECT id, nombre, contacto, telefono, email, direccion FROM proveedores ORDER BY nombre ASC";
$result = $con->query($sql);
$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
$con->close();

// Títulos de las columnas
$header = array('ID', 'Nombre', 'Contacto', 'Teléfono', 'Email', 'Dirección');

// Generar la tabla
$pdf->FancyTable($header, $data);

$pdf->Output();
?>