<?php
include '../config/conexion.php';

$nombre = $_POST['nombre'];

$queryCheck = "SELECT * FROM tipo_producto WHERE nombre = ?";
$stmtCheck = mysqli_prepare($conn, $queryCheck);
mysqli_stmt_bind_param($stmtCheck, 's', $nombre);
mysqli_stmt_execute($stmtCheck);
mysqli_stmt_store_result($stmtCheck);

if (mysqli_stmt_num_rows($stmtCheck) > 0) {
    echo 'exists';
} else {
    $query = "INSERT INTO tipo_producto (nombre) VALUES (?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $nombre);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo 'success';
    } else {
        echo 'error';
    }

    mysqli_stmt_close($stmt);
}

mysqli_stmt_close($stmtCheck);
mysqli_close($conn);
?>
