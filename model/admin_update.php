<?php
include("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    // Actualizar el producto en la base de datos
    $sql = "UPDATE producto SET nombre='$nombre', descripcion='$descripcion', precio='$precio', stock='$cantidad' WHERE id_producto='$id_producto'";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
