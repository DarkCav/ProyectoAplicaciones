<?php
include("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST['id_cliente'];

    // Eliminar el cliente de la base de datos
    $sql = "DELETE FROM cliente WHERE id_cliente = $id_cliente";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
