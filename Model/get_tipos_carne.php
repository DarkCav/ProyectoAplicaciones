<?php
include '../config/conexion.php';

$query = "SELECT * FROM tipo_producto ORDER BY id_tipo_producto ASC";
$result = mysqli_query($conn, $query);
$contador = 1;  // Contador para numerar las filas

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$contador}</td>";
        echo "<td>{$row['nombre']}</td>";
        echo "<td><button class='btn btn-danger btn-eliminar' data-id='{$row['id_tipo_producto']}'>Eliminar</button></td>";
        echo "</tr>";
        $contador++;  // Incrementar el contador para la siguiente fila
    }
} else {
    echo "<tr><td colspan='3'>No se encontraron tipos de carne.</td></tr>";
}

mysqli_close($conn);
?>
