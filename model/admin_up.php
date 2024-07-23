<?php
include("../config/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $peso = $_POST['peso'];
    $imagen = $_FILES['imagen'];

    // Validar que la imagen sea PNG
    $imageFileType = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));
    if ($imageFileType != 'png') {
        echo "Solo se permiten archivos PNG.";
        exit();
    }

    // Leer la imagen y convertirla en binario
    $imageData = file_get_contents($imagen['tmp_name']);

    // Insertar producto en la base de datos
    $sql = "INSERT INTO producto (nombre, descripcion, precio, cantidad_disponible, peso_lb, imagen) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conec, $sql);
    mysqli_stmt_bind_param($stmt, 'ssdiib', $nombre, $descripcion, $precio, $cantidad, $peso, $imageData);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../View/admin_subir.html?success=1");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conec);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conec);
}
?>
