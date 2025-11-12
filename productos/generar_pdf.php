<?php
session_start();

// Check if user is logged in and is a manager, otherwise redirect
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'gerente') {
    header("Location: ../index.html"); // Redirect to login page if not authorized
    exit();
}

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
        $this->Cell(30, 10, 'Listado de Productos', 0, 0, 'C');
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
        $w = array(10, 30, 25, 20, 20, 15, 15, 25, 25); // Anchos de las columnas (ID, Nombre, Descripcion, Precio Compra, Precio Venta, Stock, Stock Minimo, Categoria, Proveedor)
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
            $this->Cell($w[2], 6, $row['descripcion'], 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 6, $row['precio_compra'], 'LR', 0, 'R', $fill);
            $this->Cell($w[4], 6, $row['precio_venta'], 'LR', 0, 'R', $fill);
            $this->Cell($w[5], 6, $row['stock'], 'LR', 0, 'C', $fill);
            $this->Cell($w[6], 6, $row['stock_minimo'], 'LR', 0, 'C', $fill); // Display Stock Minimo
            $this->Cell($w[7], 6, $row['categoria_nombre'], 'LR', 0, 'L', $fill);
            $this->Cell($w[8], 6, $row['proveedor_nombre'], 'LR', 0, 'L', $fill);
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
$sql = "SELECT p.id, p.nombre, p.descripcion, p.precio_compra, p.precio_venta, p.stock, p.stock_minimo, c.nombre AS categoria_nombre, pr.nombre AS proveedor_nombre 
        FROM productos p
        LEFT JOIN categorias c ON p.id_categoria = c.id
        LEFT JOIN proveedores pr ON p.id_proveedor = pr.id
        ORDER BY p.nombre ASC";
$result = $con->query($sql);
$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
$con->close();

// Títulos de las columnas
$header = array('ID', 'Producto', 'Descripción', 'P. Compra', 'P. Venta', 'Stock', 'Stock Min.', 'Categoría', 'Proveedor');

// Generar la tabla
$pdf->FancyTable($header, $data);

$pdf->Output();
?>