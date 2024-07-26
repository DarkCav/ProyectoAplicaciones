<?php
require('../fpdf186/fpdf.php');
include('../config/conexion.php');

// Establecer el juego de caracteres a UTF-8 en el archivo de conexión
mysqli_set_charset($conn, "utf8");

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../img/SanPedroReporte.png', 20, -5, 30);
        // Título en mayúsculas y agrandado
        $this->SetFont('Times', 'B', 24); // Cambiado el tamaño de fuente a 24
        $this->SetTextColor(255, 87, 34); // Color naranja
        $this->Cell(50); // Espacio para el logo
        $this->Cell(190, 15, utf8_decode('LISTADO DE USUARIOS'), 0, 1, 'C'); // Cambiado el título a mayúsculas y el alto de la celda a 15
        
        // Descripción debajo del título
        $this->SetFont('Times', '', 12); // Tamaño de fuente para la descripción
        $this->SetTextColor(0, 0, 0); // Color negro para la descripción
        $this->Cell(50); // Espacio para el logo
        $this->Cell(190, 10, utf8_decode('Este es un reporte detallado de todos los usuarios registrados en el sistema.'), 0, 1, 'C');
        
        // Línea decorativa
        $this->SetLineWidth(1);
        $this->SetDrawColor(0, 128, 0); // Color verde
        $this->Line(10, 40, 290, 40);
        
        // Agregar la fecha de emisión alineada a la derecha
        $this->SetY(28); // Ajustar la posición vertical
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, utf8_decode('Fecha de emisión: ') . date('d/m/Y'), 0, 1, 'R');
        
        // Salto de línea
        $this->Ln(8); // Ajustado para que haya un salto de línea adicional
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 2.5 cm del final
        $this->SetY(-25);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Información del pie de página
        $this->Cell(0, 5, utf8_decode('Carnicos San Pedro'), 0, 1, 'C');
        $this->Cell(0, 5, utf8_decode('Riobamba-Ecuador | Carabobo 14-31 y Boyacá| Código Postal: EC060150'), 0, 1, 'C');
        $this->Cell(0, 5, utf8_decode('Teléfono: 593 (03) 239-3548 | Telefax: (03) 2 317-001'), 0, 1, 'C'); // Asegúrate de usar acentos correctamente
        // Número de página alineado a la esquina derecha
        $this->SetY(-15);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'R');
    }

    // Tabla coloreada
    function FancyTable($header, $data)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(200, 220, 255); // Color de fondo celeste para cabeceras
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 128, 0); // Color verde
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        // Anchuras de las columnas
        $w = array(10, 50, 40, 90); // Ajuste de anchos de columna
        $totalWidth = array_sum($w);
        $this->SetX(($this->w - $totalWidth) / 2); // Centrar la tabla

        // Cabeceras
        $this->HeaderTable($header, $w);

        // Restauración de colores y fuentes
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
        $fill = false;
        $counter = 1;
        foreach($data as $row)
        {
            // Verificar si hay suficiente espacio en la página para agregar una fila más
            if ($this->GetY() + 12 > $this->PageBreakTrigger) { // Ajustar el valor según sea necesario
                $this->SetX(($this->w - $totalWidth) / 2); // Centrar la línea de cierre
                $this->Cell($totalWidth, 0, '', 'T'); // Línea de cierre de la tabla actual
                $this->AddPage();
                $this->HeaderTable($header, $w);
                $this->SetFillColor(240, 240, 240); // Restaurar color de fondo
                $this->SetFont(''); // Restaurar fuente normal
                $fill = false; // Reset fill pattern
            }
            $this->SetX(($this->w - $totalWidth) / 2); // Centrar cada fila
            $this->SetFillColor($fill ? 255 : 236, $fill ? 255 : 236, 179); // Alternar colores de fila
            $this->Cell($w[0],6,$counter++,'LR',0,'C',$fill);
            $this->Cell($w[1],6,utf8_decode($row['nombre']),'LR',0,'C',$fill); // Centrando los campos
            $this->Cell($w[2],6,utf8_decode($row['tipo']),'LR',0,'C',$fill); // Centrando los campos
            $this->SetFont('Arial', '', 7); // Reduciendo el tamaño de la fuente para contraseñas
            $this->Cell($w[3],6,utf8_decode($row['contraseña']),'LR',0,'C',$fill); // Centrando los campos
            $this->SetFont('Arial', '', 8); // Restaurando el tamaño de la fuente
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->SetX(($this->w - $totalWidth) / 2); // Centrar la línea de cierre
        $this->Cell($totalWidth,0,'','T');
    }

    // Función para imprimir la cabecera de la tabla
    function HeaderTable($header, $w)
    {
        $this->SetFillColor(200, 220, 255); // Color de fondo celeste para las cabeceras
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 128, 0); // Color verde
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        $this->SetX(($this->w - array_sum($w)) / 2); // Centrar la cabecera de la tabla
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,utf8_decode($header[$i]),1,0,'C',true);
        $this->Ln();
    }
}

// Crear una instancia de la clase PDF en modo horizontal
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8); // Reducir el tamaño de la fuente

// Consulta para obtener los datos de los usuarios
$query = "SELECT id_usuario, nombre, tipo, contraseña FROM rol_usuario ORDER BY LENGTH(contraseña) DESC";
$result = mysqli_query($conn, $query);

// Verificar si la consulta devolvió resultados
if (!$result) {
    die('Error en la consulta: ' . mysqli_error($conn));
}

// Preparar los datos
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Truncar contraseñas largas
    if (strlen($row['contraseña']) > 50) {
        $row['contraseña'] = substr($row['contraseña'], 0, 50) . '...';
    }
    $data[] = $row;
}

// Encabezados de la tabla
$header = array('#', 'Nombre', 'Tipo', 'Contraseña');

// Generar la tabla
$pdf->FancyTable($header, $data);

// Cerrar conexión
mysqli_close($conn);

// Generar el PDF
$pdf->Output();
?>
