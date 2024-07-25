<?php
session_start();
include '../config/conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../indexU.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM cliente WHERE id_usuario = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta</title>
    <link rel="stylesheet" href="../css//micuenta.css">
</head>
<body>
    <!--<h1>Mi Cuenta</h1>
    <p>Nombre: <?php echo htmlspecialchars($user_data['nombre']); ?></p>
    <p>Dirección: <?php echo htmlspecialchars($user_data['direccion']); ?></p>
    <p>Teléfono: <?php echo htmlspecialchars($user_data['telefono']); ?></p>
    <p>Correo electrónico: <?php echo htmlspecialchars($user_data['correo_electronico']); ?></p>
    <a href="../indexU.php">Volver al inicio</a>-->
    <div class="container">
        <h1>Mi Cuenta</h1>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($user_data['nombre']); ?></p>
        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($user_data['direccion']); ?></p>
        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($user_data['telefono']); ?></p>
        <p><strong>Correo electrónico:</strong> <?php echo htmlspecialchars($user_data['correo_electronico']); ?></p>
        <a href="../indexU.php">Volver al inicio</a>
    </div>
</body>
</html>