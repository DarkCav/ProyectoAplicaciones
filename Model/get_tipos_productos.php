<?php
include '../config/conexion.php';

$query = "SELECT id_tipo_producto, nombre FROM tipo_producto";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='{$row['id_tipo_producto']}'>{$row['nombre']}</option>";
    }
} else {
    echo "<option value=''>No se encontraron tipos de productos</option>";
}

mysqli_close($conn);
?>
