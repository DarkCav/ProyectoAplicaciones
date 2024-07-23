<?php
include '../config/conexion.php';

// Iniciar transacción
mysqli_begin_transaction($conn);

try {
    // Obtener datos del formulario
    $nombre = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);  // Hashear la contraseña
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $tipo_usuario = $_POST['tipo'];

    // Insertar en la tabla usuario
    $query_usuario = "INSERT INTO usuario (nombre, tipo, contraseña) VALUES (?, ?, ?)";
    $stmt_usuario = mysqli_prepare($conn, $query_usuario);
    mysqli_stmt_bind_param($stmt_usuario, "sss", $nombre, $tipo_usuario, $contrasena);
    mysqli_stmt_execute($stmt_usuario);

    // Obtener el id_usuario recién insertado
    $id_usuario = mysqli_insert_id($conn);

    // Insertar en la tabla cliente
    $query_cliente = "INSERT INTO cliente (nombre, direccion, telefono, correo_electronico, id_usuario) VALUES (?, ?, ?, ?, ?)";
    $stmt_cliente = mysqli_prepare($conn, $query_cliente);
    mysqli_stmt_bind_param($stmt_cliente, "ssssi", $nombre, $direccion, $telefono, $correo, $id_usuario);
    mysqli_stmt_execute($stmt_cliente);

    // Si todo está bien, confirmar la transacción
    mysqli_commit($conn);

    echo '
        <script>
            alert("Usuario registrado exitosamente");
            window.location = "../index.html";
        </script>
    ';
} catch (Exception $e) {
    // Si algo sale mal, revertir la transacción
    mysqli_rollback($conn);
    echo '
        <script>
            alert("Error al registrar el usuario: ' . $e->getMessage() . '");
            window.location = "../index.html";
        </script>
    ';
}

mysqli_close($conn);

?>