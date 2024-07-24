<?php
include '../config/conexion.php';

$id = $_POST['id'];

$query = "DELETE FROM tipo_producto WHERE id_tipo_producto = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    $resetIncrement = "ALTER TABLE tipo_producto AUTO_INCREMENT = 1";
    mysqli_query($conn, $resetIncrement);
    echo 'success';
} else {
    echo 'error';
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
