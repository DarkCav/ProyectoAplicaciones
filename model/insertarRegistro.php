<?php
header('Content-Type: text/html; charset=utf-8');
include '../config/conexion.php';

// Asegurarse de que la conexión use UTF-8
mysqli_set_charset($conn, "utf8mb4");

// Obtener datos del formulario
$nombre = $_POST['nombre_completo'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$tipo_usuario = $_POST['tipo'];
$confirmarC = $_POST['confirmar'];

if($contrasena == $confirmarC){
    // Las contraseñas coinciden, proceder con el registro
    
    // Iniciar transacción
    mysqli_begin_transaction($conn);

    try {
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);  // Hashear la contraseña

        // Insertar en la tabla usuario
        $query_usuario = "INSERT INTO rol_usuario (nombre, tipo, contraseña) VALUES (?, ?, ?)";
        $stmt_usuario = mysqli_prepare($conn, $query_usuario);
        mysqli_stmt_bind_param($stmt_usuario, "sss", $nombre, $tipo_usuario, $contrasena_hash);
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

        $redirect_page = ($tipo_usuario === "Administrador") ? "../view/admin_menu.html" : "../indexU.php";

        echo '
            <script>
                alert("Usuario registrado exitosamente por favor inicie sesión");
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
} else {
    // Las contraseñas no coinciden
    echo '
        <script>
            alert("Las contraseñas no coinciden. Por favor, inténtelo de nuevo.");
            window.history.back();
        </script>
    ';
}

mysqli_close($conn);

?>