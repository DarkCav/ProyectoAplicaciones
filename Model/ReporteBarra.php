<?php
require('../fpdf186/fpdf.php');
include('../config/conexion.php');

// Establecer el juego de caracteres a UTF-8
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
        $this->Cell(190, 15, utf8_decode('REPORTE DE PRODUCTOS MÁS CAROS'), 0, 1, 'C'); // Cambiado el título a mayúsculas y el alto de la celda a 15
        
        // Descripción debajo del título
        $this->SetFont('Times', '', 12); // Tamaño de fuente para la descripción
        $this->SetTextColor(0, 0, 0); // Color negro para la descripción
        $this->Cell(50); // Espacio para el logo
        $this->Cell(190, 10, utf8_decode('Este es un reporte detallado de los 3 productos más caros registrados en el sistema.'), 0, 1, 'C');
        
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
}

// Crear una instancia de la clase PDF
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8); // Reducir el tamaño de la fuente

// Consulta para obtener los datos de los productos
$query = "SELECT nombre, precio FROM producto ORDER BY precio DESC LIMIT 3";
$result = mysqli_query($conn, $query);

// Verificar si la consulta devolvió resultados
if (!$result) {
    die('Error en la consulta: ' . mysqli_error($conn));
}

// Preparar los datos
$data = [];
$labels = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row['precio'];
    $labels[] = $row['nombre'];
}

// Crear el gráfico de barras usando la API de QuickChart
$chartData = [
    "type" => "bar",
    "data" => [
        "labels" => $labels,
        "datasets" => [
            [
                "label" => "Precio",
                "data" => $data,
                "backgroundColor" => [
                    "#FF6384",
                    "#36A2EB",
                    "#FFCE56"
                ]
            ]
        ]
    ],
    "options" => [
        "title" => [
            "display" => true,
            "text" => "Top 3 Productos Más Caros"
        ],
        "legend" => [
            "display" => false
        ]
    ]
];

$chartUrl = "https://quickchart.io/chart?c=" . urlencode(json_encode($chartData));
$imagePath = '../img/bar_chart.png';
file_put_contents($imagePath, file_get_contents($chartUrl));

// Agregar el gráfico al PDF
$pdf->Image($imagePath, 60, 55, 180, 110); // Ajustar el tamaño y la posición del gráfico

// Cerrar conexión
mysqli_close($conn);

// Generar el PDF
$pdf->Output();
?>
