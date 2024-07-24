<?php
include("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $peso = $_POST['peso'];
    $id_tipo_producto = $_POST['id_tipo_producto'];
    $imagen_url = $_POST['imagen_url'];

    // Insertar el producto en la base de datos
    $sql = "INSERT INTO producto (nombre, descripcion, precio, stock, id_tipo_producto, imagen_url)
            VALUES ('$nombre', '$descripcion', '$precio', '$cantidad', '$id_tipo_producto', '$imagen_url')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Producto subido exitosamente.');
                window.location.href = '../view/admin_subir.html';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
