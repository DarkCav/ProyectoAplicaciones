<?php
header('Content-Type: text/html; charset=utf-8');
include '../config/conexion.php';

// Asegurarse de que la conexión use UTF-8
mysqli_set_charset($conn, "utf8mb4");
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

    $redirect_page = ($tipo_usuario === "Administrador") ? "../view/admin_menu.html" : "../index.html";

    echo '
        <script>
            alert("Usuario registrado exitosamente como ' . $tipo_usuario . '");
            window.location = "' . $redirect_page . '";
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

/*try {
    // Obtener datos del formulario
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre_completo']);
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $direccion = mysqli_real_escape_string($conn, $_POST['direccion']);
    $telefono = mysqli_real_escape_string($conn, $_POST['telefono']);
    $tipo_usuario = mysqli_real_escape_string($conn, $_POST['tipo']);

    // Insertar en la tabla usuario
    $query_usuario = "INSERT INTO usuario (nombre, tipo, contraseña) VALUES (?, ?, ?)";
    $stmt_usuario = mysqli_prepare($conn, $query_usuario);
    if ($stmt_usuario === false) {
        throw new Exception("Error en la preparación de la consulta de usuario: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt_usuario, "sss", $nombre, $tipo_usuario, $contrasena);
    if (!mysqli_stmt_execute($stmt_usuario)) {
        throw new Exception("Error al ejecutar la consulta de usuario: " . mysqli_stmt_error($stmt_usuario));
    }

    // Obtener el id_usuario recién insertado
    $id_usuario = mysqli_insert_id($conn);

    // Insertar en la tabla cliente
    $query_cliente = "INSERT INTO cliente (nombre, direccion, telefono, correo_electronico, id_usuario) VALUES (?, ?, ?, ?, ?)";
    $stmt_cliente = mysqli_prepare($conn, $query_cliente);
    if ($stmt_cliente === false) {
        throw new Exception("Error en la preparación de la consulta de cliente: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt_cliente, "ssssi", $nombre, $direccion, $telefono, $correo, $id_usuario);
    if (!mysqli_stmt_execute($stmt_cliente)) {
        throw new Exception("Error al ejecutar la consulta de cliente: " . mysqli_stmt_error($stmt_cliente));
    }

    // Si todo está bien, confirmar la transacción
    mysqli_commit($conn);

    $redirect_page = ($tipo_usuario === "Administrador") ? "../view/admin_menu.html" : "../index.html";
    
    echo json_encode([
        'success' => true,
        'message' => "Usuario registrado exitosamente como " . htmlspecialchars($tipo_usuario),
        'redirect' => $redirect_page
    ]);

} catch (Exception $e) {
    // Si algo sale mal, revertir la transacción
    mysqli_rollback($conn);
    
    echo json_encode([
        'success' => false,
        'message' => "Error al registrar el usuario: " . $e->getMessage()
    ]);
}

mysqli_close($conn);*/

?>