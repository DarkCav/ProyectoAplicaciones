<?php
// Incluir la conexión a la base de datos
include '../config/conexion.php';

require('fpdf/fpdf.php');

// Consulta para obtener los datos de los clientes
$query = "SELECT id_cliente, nombre, direccion, telefono, correo_electronico FROM clientes";
$result = mysqli_query($conn, $query);

// Verificar si la consulta devolvió resultados
if (!$result) {
    die('Error en la consulta: ' . mysqli_error($conn));
}

// Crear una instancia de la clase FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Ruta de la imagen
$imagePath = 'img/SanPedroReporte.png';

// Verificar si el archivo de imagen existe
if (!file_exists($imagePath)) {
    die('La imagen no se encuentra en la ruta especificada: ' . $imagePath);
}

// Agregar el logotipo
$pdf->Image($imagePath, 10, 6, 30);

// Establecer el tipo de letra y el encabezado
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(80); // Mover a la derecha
$pdf->Cell(30, 10, 'Listado de Clientes', 0, 1, 'C');
$pdf->Ln(20);

// Agregar los encabezados de la tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, '#', 1);
$pdf->Cell(40, 10, 'Nombre', 1);
$pdf->Cell(60, 10, 'Direccion', 1);
$pdf->Cell(30, 10, 'Telefono', 1);
$pdf->Cell(50, 10, 'Correo Electronico', 1);
$pdf->Ln();

// Agregar los datos de los clientes
$pdf->SetFont('Arial', '', 12);
$counter = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(10, 10, $counter++, 1);
    $pdf->Cell(40, 10, $row['nombre'], 1);
    $pdf->Cell(60, 10, $row['direccion'], 1);
    $pdf->Cell(30, 10, $row['telefono'], 1);
    $pdf->Cell(50, 10, $row['correo_electronico'], 1);
    $pdf->Ln();
}

// Cerrar la conexión
mysqli_close($conn);

// Generar el PDF
$pdf->Output();
?>
