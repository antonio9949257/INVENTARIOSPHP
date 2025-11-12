# Documentación Técnica: Implementación de FPDF

Este documento detalla el uso de la librería FPDF dentro de este proyecto para la generación de reportes en formato PDF para los módulos de Pacientes y Especialidades.

## 1. Introducción a FPDF

**FPDF** es una clase PHP que permite generar documentos PDF de forma nativa, sin necesidad de utilizar librerías externas complejas como PDFlib. La principal ventaja es su simplicidad y que todo el código está escrito en PHP.

El flujo de trabajo básico consiste en:
1.  **Instanciar** la clase `FPDF`.
2.  **Añadir una página** con `AddPage()`.
3.  **Establecer la fuente** con `SetFont()`.
4.  **Insertar contenido** en celdas con `Cell()` o `MultiCell()`.
5.  **Generar y mostrar/descargar** el documento con `Output()`.

## 2. Implementación en el Proyecto

Para mantener un diseño consistente y reutilizable en todos los reportes, se ha creado una clase `PDF` que hereda de la clase base `FPDF`.

```php
class PDF extends FPDF
{
    // ...
}
```

Esta aproximación nos permite definir métodos personalizados para la **cabecera** y el **pie de página** de nuestros documentos.

-   **`Header()`**: Este método es invocado automáticamente por `AddPage()`. En nuestro caso, se ha sobreescrito para incluir el logo de la empresa, el título del reporte y la fecha de generación en la parte superior de cada página.

-   **`Footer()`**: Este método también se invoca automáticamente. Lo hemos personalizado para que muestre el número de página actual en el formato "Página X de Y" en la parte inferior.

Los scripts de generación se encuentran en:
-   `paciente/generar_pdf.php`
-   `especialidad/generar_pdf.php`

## 3. Métodos Clave de FPDF Utilizados

A continuación se describen los métodos más importantes de FPDF que han sido utilizados en la implementación:

| Método | Descripción |
| :--- | :--- |
| `FPDF()` | Constructor de la clase. Inicia el documento PDF. |
| `AddPage($orientation, $size)` | Añade una nueva página. Se puede especificar la orientación (P: Portrait, L: Landscape) y el tamaño. |
| `SetFont($family, $style, $size)` | Establece la fuente, estilo (B: Bold, I: Italic, U: Underline) y tamaño para el texto subsecuente. |
| `SetTextColor($r, $g, $b)` | Define el color del texto usando componentes RGB (0-255). |
| `SetFillColor($r, $g, $b)` | Define el color de relleno para las celdas. |
| `Cell($w, $h, $txt, $border, $ln, $align, $fill)` | Dibuja una celda. Es el método principal para añadir texto. Sus parámetros controlan el ancho, alto, texto, bordes, salto de línea, alineación y si la celda se rellena con el color de `SetFillColor`. |
| `Image($file, $x, $y, $w, $h)` | Inserta una imagen en el documento (formatos JPG, PNG, GIF). |
| `Ln($h)` | Realiza un salto de línea. La altura es opcional. |
| `AliasNbPages()` | Activa la funcionalidad para mostrar el número total de páginas. Se usa en conjunto con `{nb}` en el `Footer`. |
| `Output($dest, $name)` | Envía el documento a un destino, que puede ser el navegador (`I`: inline), forzar descarga (`D`) o guardar en un archivo (`F`). |

## 4. Análisis Detallado: `paciente/generar_pdf.php`

Este archivo es un ejemplo representativo de la implementación. A continuación se desglosa su estructura y funcionamiento.

```php
<?php
require('../fpdf186/fpdf.php');
require('db.php');

// 1. Se define la clase PDF personalizada que hereda de FPDF
class PDF extends FPDF
{
    // 2. Cabecera de página (logo, título, fecha)
    function Header()
    {
        $this->Image('../img/logosinfonfo.png', 10, 8, 33);
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(80);
        $this->SetTextColor(40, 40, 40);
        $this->Cell(30, 10, 'Listado de Pacientes', 0, 0, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(80, 10, date('d/m/Y'), 0, 1, 'R');
        $this->Ln(20);
    }

    // 3. Pie de página (numeración)
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // 4. Método personalizado para crear una tabla con estilo
    function FancyTable($header, $data)
    {
        // Estilos de la cabecera de la tabla
        $this->SetFillColor(200, 200, 200);
        $this->SetTextColor(40);
        $this->SetDrawColor(150);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');

        // Dibuja la cabecera
        $w = array(35, 35, 30, 60, 25); // Anchos de columna
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();

        // Restaura estilos y define el color de relleno para las filas (efecto cebra)
        $this->SetFillColor(245, 245, 245);
        $this->SetTextColor(0);
        $this->SetFont('');

        // Itera sobre los datos y dibuja las filas
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row['nombre'], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row['apellido'], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row['fecha_nacimiento'], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, $row['direccion'], 'LR', 0, 'L', $fill);
            $this->Cell($w[4], 6, $row['telefono'], 'LR', 0, 'C', $fill);
            $this->Ln();
            $fill = !$fill; // Alterna el color de relleno
        }
        $this->Cell(array_sum($w), 0, '', 'T'); // Línea de cierre
    }
}

// 5. Lógica de ejecución principal

// Se crea el objeto PDF
$pdf = new PDF();
$pdf->AliasNbPages(); // Se activa el conteo de páginas
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Se cargan los datos desde la base de datos
$sql = "SELECT nombre, apellido, fecha_nacimiento, direccion, telefono FROM pacientes ORDER BY apellido, nombre";
$result = $con->query($sql);
$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
$con->close();

// Títulos de las columnas
$header = array('Nombre', 'Apellido', 'F. Nacimiento', 'Direccion', 'Telefono');

// Se invoca al método que genera la tabla
$pdf->FancyTable($header, $data);

// Se envía el PDF al navegador
$pdf->Output();
?>
```

## 5. Cómo Generar los PDFs

La generación de los documentos es transparente para el usuario final:

1.  Navega a la sección de **Pacientes** o **Especialidades**.
2.  Haz clic en el botón **"Generar PDF"**.
3.  El script correspondiente se ejecutará y el PDF se mostrará en una nueva pestaña del navegador.
